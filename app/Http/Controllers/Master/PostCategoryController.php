<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\BaseController;
use App\Http\Requests\PostCategoryRequest;
use App\Models\RefPostCategory;

class PostCategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = RefPostCategory::all();
            return $this->sendResponse($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCategoryRequest $request)
    {
        try {
            $data = new RefPostCategory($request->validated());
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
            $data = RefPostCategory::find($id);
            if (!$data) return $this->sendError('Post category tidak ditemukan');

            return $this->sendResponse($data);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostCategoryRequest $request, string $id)
    {
        try {
            $data = RefPostCategory::find($id);
            if (!$data) return $this->sendError('Post category tidak ditemukan');
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
            $data = RefPostCategory::find($id);
            if (!$data) return $this->sendError('Post category tidak ditemukan');

            $data->delete();
            return $this->sendResponse(null);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }
}
