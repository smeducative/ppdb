<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UkuranSeragam extends Model
{
    use HasFactory;

    protected $table = 'ukuran_seragam';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'seragam_praktik' => 'boolean',
            'baju_batik' => 'boolean',
            'seragam_olahraga' => 'boolean',
            'jas_almamater' => 'boolean',
            'kaos_bintalsik' => 'boolean',
            'atribut' => 'boolean',
            'kegiatan_bintalsik' => 'boolean',
        ];
    }

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
