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

    public function getNoPendaftaranAttribute($value)
    {
        return '000' . $this->jurusan->id . $this->created_at->format('my');
    }
}
