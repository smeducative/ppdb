<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kwitansi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kwitansi';

    protected $guarded = [];

    protected $with = ['pesertaPpdb', 'penerima', 'deletedBy'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $model->attributes['deleted_by'] = \auth()->id();

            $model->save();
        });
    }

    public function pesertaPpdb()
    {
        return $this->belongsTo(PesertaPPDB::class, 'peserta_ppdb_id');
    }

    public function penerima()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }
}
