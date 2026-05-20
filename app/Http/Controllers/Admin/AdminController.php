<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Schedule;

class AdminController extends Controller
{
    public function dashboard()
    {
        $todaySchedules = Schedule::whereDate('tanggal', today())->count();
        $totalFilms = Film::count();
        $latestFilms = Film::latest()->take(3)->get();

        return view('admin.dashboard', compact(
            'todaySchedules',
            'totalFilms',
            'latestFilms'
        ));
    }

    public function previewHome()
    {
        $films = Film::latest()->get();
        $schedules = Schedule::with('film')
            ->whereDate('tanggal', today())
            ->orderBy('jam_tayang')
            ->get();

        return view('welcome', [
            'films' => $films,
            'schedules' => $schedules,
            'previewMode' => true,
        ]);
    }

    public function previewFilm(Film $film)
    {
        $schedules = Schedule::with('film')
            ->where('film_id', $film->id)
            ->whereDate('tanggal', '>=', today())
            ->orderBy('tanggal')
            ->orderBy('jam_tayang')
            ->get();

        return view('films.detail', [
            'film' => $film,
            'schedules' => $schedules,
            'previewMode' => true,
        ]);
    }
}
