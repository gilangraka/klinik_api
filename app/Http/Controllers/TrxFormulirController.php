<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListFormulirRequest;
use App\Http\Requests\TrxFormulirRequest;
use App\Models\NotAvailable;
use App\Models\Payment;
use App\Models\RefLayanan;
use App\Models\TrxFormulir;
use App\Models\TrxFormulirLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Xendit\Configuration;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\InvoiceApi;
use Illuminate\Support\Str;

class TrxFormulirController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(ListFormulirRequest $request)
    {
        try {
            $params = $request->validated();
            $per_page = $params['per_page'] ?? 10;
            $status = $params['status'] ?? null;
            $start_date = $params['start_date'] ?? null;
            $end_date = $params['end_date'] ?? null;
            $is_done = $params['is_done'] ?? null;

            $data = TrxFormulir::select([
                'id',
                'nama',
                'nomor_hp',
                'start_time',
                'end_time',
                'is_done'
            ])
                ->with([
                    'payments:id,formulir_id,external_id,status'
                ])
                ->when(
                    !is_null($status),
                    fn($q) => $q->whereHas('payments', function ($query) use ($status) {
                        $query->whereIn('status', explode(',', $status));
                    })
                )
                ->when(
                    !is_null($start_date) && !is_null($end_date),
                    fn($q) => $q->whereBetween('created_at', [$start_date, $end_date])
                )
                ->when(
                    !is_null($is_done),
                    fn($q) => $q->whereIn('is_done', explode(',', $is_done))
                )
                ->paginate($per_page);

            return $this->sendResponse($data, '', true);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = TrxFormulir::with('trx_pembayaran')->find($id);
            if (!$data) return $this->sendError('Formulir tidak ditemukan');

            return $this->sendResponse($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TrxFormulirRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = new TrxFormulir($request->validated());
            $data->save();

            $available = new NotAvailable($request->validated());
            $available->formulir_id = $data->id;
            $available->save();

            $list_layanan = $request->list_layanan;
            $total_amount = 0;

            $layanan_data = RefLayanan::whereIn('id', $list_layanan)->get();

            foreach ($list_layanan as $value) {
                $layanan = $layanan_data->firstWhere('id', $value);

                if (!$layanan) {
                    throw new Exception("Layanan dengan ID {$value} tidak ditemukan.");
                }

                $trx_formulir_layanan = new TrxFormulirLayanan([
                    'formulir_id' => $data->id,
                    'layanan_id'  => $value
                ]);
                $trx_formulir_layanan->save();

                $total_amount += $layanan->biaya;
            }

            // Xendit Config
            Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));
            $payment = new Payment([
                'formulir_id' => $data->id,
                'external_id' => Str::uuid(),
                'amount' => $total_amount,
                'status' => 'pending',
            ]);

            $createInvoice = new CreateInvoiceRequest([
                'external_id' => "$payment->external_id",
                'amount' => $payment->amount,
                'invoice_duration' => 600,
                'payer_email' => $data->email,
                'description' => 'Pembayaran klinik'
            ]);
            $apiInstance = new InvoiceApi();
            $generateInvoice = $apiInstance->createInvoice($createInvoice);

            $payment->checkout_link = $generateInvoice['invoice_url'];
            $payment->save();

            DB::commit();
            return $this->sendResponse([
                'data' => [
                    'checkout_link' => $payment->checkout_link
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage(), 500);
        }
    }

    public function handleHook(Request $request)
    {
        $data = $request->all();
        $external_id = $data['external_id'];
        $status = strtolower($data['status']);
        $payment_method = $data['payment_method'];

        $order = Payment::where('external_id', $external_id)->first();

        if (!$order) {
            return $this->sendError('Order not found!');
        }

        $order->status = $status;
        $order->payment_method = $payment_method;
        $order->save();

        if ($order->status == 'expired') {
            $not_available = NotAvailable::where('formulir_id', $order->formulir_id)->first();
            $not_available->delete();
        }

        return $this->sendResponse([
            'data' => [
                'status' => $status,
                'payment_method' => $payment_method,
            ]
        ]);
    }
}
