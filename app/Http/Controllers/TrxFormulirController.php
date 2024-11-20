<?php

namespace App\Http\Controllers;

use App\Models\TrxFormulir;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        try {
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
}
