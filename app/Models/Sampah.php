<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Sampah extends Model
{
    use HasFactory;
    use softDeletes;

    protected $table = "sampah";
    protected $fillable = [
        'kepala_keluarga',
        'no_rumah',
        'rt_rw',
        'total_karung_sampah',
        'kriteria',
        'tanggal_pengangkutan',
    ];

}
