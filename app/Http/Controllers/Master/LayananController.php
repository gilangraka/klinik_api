<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\BaseController;
use App\Http\Requests\LayananRequest;
use App\Http\Requests\ListRequest;
use App\Models\RefLayanan;

class LayananController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(ListRequest $request)
    {
        try {
            $per_page = $request->per_page ?? 10;

            $data = RefLayanan::with(['ref_jenis_layanan:id,nama'])
                ->select(['id', 'nama', 'deskripsi', 'biaya', 'jenis_layanan_id'])
                ->paginate($per_page);
            return $this->sendResponse($data, '', true);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LayananRequest $request)
    {
        try {
            $data = new RefLayanan($request->validated());
            $data->save();

            return $this->sendResponse($data);
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
            $data = RefLayanan::with(['ref_jenis_layanan:id,nama'])
                ->select(['id', 'nama', 'deskripsi', 'biaya', 'jenis_layanan_id'])
                ->find($id);
            if (!$data) return $this->sendError('Layanan tidak ditemukan');

            return $this->sendResponse($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LayananRequest $request, string $id)
    {
        try {
            $data = RefLayanan::find($id);
            if (!$data) return $this->sendError('Layanan tidak ditemukan');

            $data->update($request->validated());
            return $this->sendResponse($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = RefLayanan::find($id);
            if (!$data) return $this->sendError('Layanan tidak ditemukan');

            $data->delete();
            return $this->sendResponse(null);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }
}
