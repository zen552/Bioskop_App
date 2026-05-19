<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Film;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('film')->latest()->paginate(10);
        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $films = Film::all();
        return view('admin.schedules.create', compact('films'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'film_id'    => 'required|exists:films,id',
            'studio'     => 'required|string|max:100',
            'tanggal'    => 'required|date',
            'jam_tayang' => 'required',
            'harga'      => 'required|integer|min:0',
        ]);

        Schedule::create($request->all());
        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function edit(Schedule $schedule)
    {
        $films = Film::all();
        return view('admin.schedules.edit', compact('schedule', 'films'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'film_id'    => 'required|exists:films,id',
            'studio'     => 'required|string|max:100',
            'tanggal'    => 'required|date',
            'jam_tayang' => 'required',
            'harga'      => 'required|integer|min:0',
        ]);

        $schedule->update($request->all());
        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil diupdate!');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil dihapus!');
    }
}