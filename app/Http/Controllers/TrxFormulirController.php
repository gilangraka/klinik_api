<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrxFormulirRequest;
use App\Models\RefLayanan;
use App\Models\TrxFormulir;
use App\Models\TrxFormulirLayanan;
use Illuminate\Support\Facades\DB;

class TrxFormulirController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = TrxFormulir::with('trx_pembayaran')->get();
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
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
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
}
