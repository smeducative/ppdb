<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaPPDB extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'peserta_ppdb';

    protected $guarded = [];

    protected $casts = [
        'akademik' => 'array',
        'non_akademik' => 'array',
        'tanggal_lahir' => 'date'
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function getNoUrut()
    {
        return $this->whereYear('created_at', now()->year)->count() + 1;
    }
}
