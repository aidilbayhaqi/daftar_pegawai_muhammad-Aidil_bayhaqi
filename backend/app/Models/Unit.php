<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
      use HasFactory;

    protected $table = 'units';

    protected $fillable = [
        'nama_unit',
        'tempat_tugas'
    ];

    // Relasi ke Karyawan
    public function karyawans()
    {
        return $this->hasMany(Karyawan::class);
    }
}
