<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $fillable = ['nomor_polisi', 'jenis_kendaraan', 'merk', 'tarif', 'kapasitas'];

    public $timestamps = false;

    protected $hidden = ['id'];
}
