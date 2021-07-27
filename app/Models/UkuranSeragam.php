<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UkuranSeragam extends Model
{
    use HasFactory;

    protected $table = 'ukuran_seragam';

    protected $guarded = [];

    public function pesertaPpdb()
    {
        return $this->belongsTo(PesertaPPDB::class, 'peserta_ppdb_id');
    }

    public function getJsonUkuranAttribute()
    {
        return json_encode([
            'baju' => $this->baju,
            'jas' => $this->jas,
            'sepatu' => $this->sepatu,
            'peci' => $this->peci,
        ]);
    }
}
