<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jurusan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jurusan';

    protected $guarded = [];

    // public $timestamps = false;

    public function pesertaPpdb()
    {
        return $this->hasMany(PesertaPPDB::class);
    }
}
