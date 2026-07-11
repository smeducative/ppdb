<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ExportPesertaRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'jurusan' => ['nullable', 'exists:jurusan,id'],
            'status' => ['nullable', 'in:semua,diterima,sudah_du,belum_du'],
            'tahun' => ['nullable', 'integer'],
        ];
    }
}
