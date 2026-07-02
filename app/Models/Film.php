<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Film extends Model
{
    use SoftDeletes;
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

    public function getPosterUrlAttribute(): ?string
    {
        if (! $this->poster) {
            return null;
        }

        if (Str::startsWith($this->poster, ['http://', 'https://'])) {
            return $this->poster;
        }

        $storagePath = Storage::url($this->poster);
        $relativePath = Str::startsWith($storagePath, '/')
            ? ltrim($storagePath, '/')
            : $storagePath;

        if (request()) {
            $baseUrl = rtrim(request()->getSchemeAndHttpHost() . request()->getBaseUrl(), '/');

            return $baseUrl.'/'.$relativePath;
        }

        return asset($relativePath);
    }

    protected static function booted()
    {
        static::deleting(function ($film) {
            // Ketika film dihapus (soft delete), hapus juga semua jadwalnya (soft delete)
            // agar tidak muncul di halaman jadwal, tapi history e-ticket tetap aman
            $film->schedules()->each(function($schedule) {
                $schedule->delete();
            });
        });
    }
}
