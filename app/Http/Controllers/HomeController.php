<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        return $this->getHomeView($request, false);
    }

    public function getHomeView(Request $request, $previewMode = false)
    {
        // 1. Ambil input pencarian dan filter
        $search = $request->input('search');
        $genre = $request->input('genre');
        $duration = $request->input('duration');
        $dateFilter = $request->input('date');
        $studio = $request->input('studio');

        // 2. Query Film
        $filmQuery = Film::query();

        if ($search) {
            $filmQuery->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('genre', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($genre) {
            $filmQuery->where('genre', 'like', "%{$genre}%");
        }

        if ($duration) {
            if ($duration === 'short') {
                $filmQuery->where('durasi', '<', 90);
            } elseif ($duration === 'medium') {
                $filmQuery->whereBetween('durasi', [90, 120]);
            } elseif ($duration === 'long') {
                $filmQuery->where('durasi', '>', 120);
            }
        }

        if ($request->has('date') && $dateFilter) {
            $filmQuery->whereHas('schedules', function ($q) use ($dateFilter) {
                $q->whereDate('tanggal', $dateFilter);
            });
        }

        $films = $filmQuery->latest()->get();

        // 3. Query Jadwal Tayang
        $scheduleQuery = Schedule::with('film');

        if ($dateFilter) {
            $scheduleQuery->whereDate('tanggal', $dateFilter);
        } else {
            $scheduleQuery->whereDate('tanggal', '>=', today());
        }

        if ($studio) {
            $scheduleQuery->where('studio', $studio);
        }

        // Tambah filter jadwal berdasarkan pencarian film juga agar sinkron
        if ($search) {
            $scheduleQuery->whereHas('film', function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('genre', 'like', "%{$search}%");
            });
        }

        if ($genre) {
            $scheduleQuery->whereHas('film', function ($q) use ($genre) {
                $q->where('genre', 'like', "%{$genre}%");
            });
        }

        $schedules = $scheduleQuery->orderBy('tanggal')
            ->orderBy('jam_tayang')
            ->get();

        // 4. Dapatkan opsi unik untuk dropdown filter
        $allGenres = Film::pluck('genre')
            ->flatMap(function ($g) {
                // Split genre yang digabung dengan / atau ,
                $splits = preg_split('/[\/,]/', $g);
                return array_map('trim', $splits);
            })
            ->filter()
            ->unique()
            ->values();

        $allStudios = Schedule::distinct()->pluck('studio')->filter()->values();

        return view('welcome', compact(
            'films',
            'schedules',
            'previewMode',
            'allGenres',
            'allStudios',
            'search',
            'genre',
            'duration',
            'dateFilter',
            'studio'
        ));
    }
}
