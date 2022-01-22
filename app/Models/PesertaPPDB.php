<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PesertaPPDB extends Model
{
    use HasFactory, SoftDeletes;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'peserta_ppdb';

    protected $guarded = [];

    protected $casts = [
        'akademik' => 'array',
        'non_akademik' => 'array',
        'tanggal_lahir' => 'date'
    ];

    protected $with = [
        'jurusan'
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function getNoUrut()
    {
        return $this->whereYear('created_at', now()->year)->withTrashed()->max('no_urut') + 1;
    }

    public function Kwitansi()
    {
        return $this->hasMany(Kwitansi::class, 'peserta_ppdb_id');
    }

    public function ukuranSeragam()
    {
        return $this->hasOne(UkuranSeragam::class, 'peserta_ppdb_id');
    }
}
