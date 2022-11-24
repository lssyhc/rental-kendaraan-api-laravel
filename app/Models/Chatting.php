<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chatting extends Model
{
    use HasFactory;

    protected $fillable = ['id_customer', 'konten', 'id_admin', 'balasan'];

    protected $hidden = ['id'];

    public $timestamps = false;
}
