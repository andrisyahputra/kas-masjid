<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateKurbanHewanRequest extends FormRequest
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
            'kurban_id' => [
                'required',
                Rule::exists('kurbans', 'id')->where('masjid_id', auth()->user()->masjid_id)
            ],
            'hewan' => 'required|in:kambing,sapi,domba,kerbau,onta',
            'kriteria' => 'nullable',
            'iuran_perorang' => 'required|numeric',
            'harga' => 'nullable|numeric',
            'biaya_operasional' => 'nullable|numeric',
        ];
    }
    protected function prepareForValidation()
    {
        if ($this->harga != null) {
            $this->merge([
                'harga' => str_replace('.', '', $this->harga),
            ]);
        }

        if ($this->biaya_operasional != null) {
            $this->merge([
                'biaya_operasional' => str_replace('.', '', $this->biaya_operasional),
            ]);
        }

        return $this->merge([
            'iuran_perorang' => str_replace('.', '', $this->iuran_perorang),
        ]);
    }
}
