<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'film_id', 'studio', 'tanggal', 'jam_tayang', 'harga'
    ];

    public function film()
    {
        return $this->belongsTo(Film::class)->withTrashed();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
