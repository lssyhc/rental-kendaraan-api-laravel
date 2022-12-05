<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chatting extends Model
{
    use HasFactory;

    protected $fillable = ['konten', 'balasan'];

    protected $hidden = ['id'];

    public $timestamps = false;
}
