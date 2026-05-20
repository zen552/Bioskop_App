<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
}
