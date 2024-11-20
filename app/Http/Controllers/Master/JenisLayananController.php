<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\JenisLayananRequest;
use App\Models\RefJenisLayanan;
use Illuminate\Http\Request;

class JenisLayananController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = RefJenisLayanan::all();
            return $this->sendResponse($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    public function Show($id)
    {
        try {
            $data = RefJenisLayanan::find($id);
            if (!$data) return $this->sendError('Jenis layanan tidak ditemukan!');

            return $this->sendResponse($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(JenisLayananRequest $request)
    {
        try {
            $data = new RefJenisLayanan([
                'nama' => $request->nama
            ]);
            $data->save();

            return $this->sendResponse($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JenisLayananRequest $request, string $id)
    {
        try {
            $data = RefJenisLayanan::find($id);
            if (!$data) return $this->sendError('Jenis layanan tidak ditemukan');

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
            $data = RefJenisLayanan::find($id);
            if (!$data) return $this->sendError('Jenis layanan tidak ditemukan');

            $data->delete();
            return $this->sendResponse(null);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }
}
