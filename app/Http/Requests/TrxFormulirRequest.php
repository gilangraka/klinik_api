<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrxFormulirRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string'],
            'usia' => ['required', 'integer'],
            'email' => ['required', 'string', 'email'],
            'gender' => ['required', 'in:laki-laki,perempuan'],
            'nomor_hp' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
            'keluhan' => ['required', 'string'],
            'datetime' => ['required', 'date'],
            'lokasi' => ['string'],
            'list_layanan' => ['required', 'array']
        ];
    }
}
