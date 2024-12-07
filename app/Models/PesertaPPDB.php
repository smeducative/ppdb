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
        'tanggal_lahir' => 'date',
    ];

    protected $with = ['jurusan'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->attributes['nama_lengkap'] = str($model->attributes['nama_lengkap'])->title();
            $model->attributes['tempat_lahir'] = str($model->attributes['tempat_lahir'])->title();
        });

        static::updating(function ($model) {
            $model->attributes['nama_lengkap'] = str($model->attributes['nama_lengkap'])->title();
            $model->attributes['tempat_lahir'] = str($model->attributes['tempat_lahir'])->title();
        });
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class)->withTrashed();
    }

    public function getNoUrut()
    {
        return $this->whereYear('created_at', now()->year)
            ->whereJurusanId(request('pilihan_jurusan'))
            ->withTrashed()
            ->max('no_urut') + 1;
    }

    public function Kwitansi()
    {
        return $this->hasMany(Kwitansi::class, 'peserta_ppdb_id');
    }

    public function ukuranSeragam()
    {
        return $this->hasOne(UkuranSeragam::class, 'peserta_ppdb_id');
    }

    public function toWhatsapp($no)
    {
        if (! $no) return $no;

        $no = preg_replace('/^0/', '62', $no);
        $no = preg_replace('/^8/', '628', $no);

        // Menghasilkan URL WhatsApp
        return 'https://wa.me/' . $no;
    }
}
