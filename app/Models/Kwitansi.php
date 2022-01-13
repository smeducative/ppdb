<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kwitansi extends Model
{
    use HasFactory;

    protected $table = 'kwitansi';

    protected $guarded = [];

    protected $with = ['pesertaPpdb', 'penerima'];

    public function pesertaPpdb()
    {
        return $this->belongsTo(PesertaPPDB::class, 'peserta_ppdb_id');
    }

    public function penerima()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
