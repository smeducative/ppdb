<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUkuranSeragamRequest extends FormRequest
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
            'uuid' => ['required', 'exists:peserta_ppdb,id'],
            'baju' => ['nullable'],
            'jas' => ['nullable'],
            'sepatu' => ['nullable'],
            'peci' => ['nullable'],
            'seragam_praktik' => ['boolean'],
            'baju_batik' => ['boolean'],
            'seragam_olahraga' => ['boolean'],
            'jas_almamater' => ['boolean'],
            'kaos_bintalsik' => ['boolean'],
            'atribut' => ['boolean'],
            'kegiatan_bintalsik' => ['boolean'],
        ];
    }
}
