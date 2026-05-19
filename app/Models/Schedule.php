<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'film_id', 'studio', 'tanggal', 'jam_tayang', 'harga'
    ];

    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}
