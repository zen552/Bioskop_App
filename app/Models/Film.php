<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $fillable = [
        'judul', 
        'genre', 
        'durasi', 
        'deskripsi', 
        'poster'
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
