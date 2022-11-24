<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = ['nomor_kendaraan', 'merk', 'tarif'];

    public $timestamps = false;

    protected $hidden = ['id'];
}
