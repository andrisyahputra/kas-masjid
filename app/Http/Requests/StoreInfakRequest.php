<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInfakRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'created_at' => 'required|date',
            'sumber' => 'required',
            'atas_nama' => 'nullable',
            'jenis' => 'required',
            'jumlah' => 'required|numeric',
            'satuan' => 'required',
        ];
    }
    protected function prepareForValidation()
    {
        return $this->merge([
            'jumlah' => str_replace('.', '', $this->jumlah),
        ]);
    }
}
