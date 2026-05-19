<?php

namespace App\Models;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'schedule_id',
        'seat_number',
        'status',
        'snap_token',
    ];

    /**
     * Relasi ke User (Siapa yang memesan)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Schedule (Jadwal tayang mana yang dipesan)
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }
}