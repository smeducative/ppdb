<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePendaftarRequest extends FormRequest
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
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'nik' => 'required',
            'alamat_lengkap' => 'required',
            'dukuh' => 'nullable',
            'rt' => 'nullable',
            'rw' => 'nullable',
            'desa_kelurahan' => 'nullable',
            'kecamatan' => 'nullable',
            'kabupaten_kota' => 'nullable',
            'provinsi' => 'nullable',
            'kode_pos' => 'nullable',
            'pilihan_jurusan' => 'required',
            'asal_sekolah' => 'required',
            'tahun_lulus' => 'required',
            'nisn' => 'nullable',
            'penerima_kip' => 'nullable',
            'no_hp' => 'required',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
            'peringkat' => 'nullable',
            'hafidz' => 'nullable',
            'jenis_lomba' => 'nullable',
            'juara_ke' => 'nullable',
            'juara_tingkat' => 'nullable',
            'rekomendasi_mwc' => 'nullable',
        ];
    }
}
