<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Genre;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function index()
    {
        $films = Film::latest()->paginate(10);
        return view('admin.films.index', compact('films'));
    }

    public function create()
    {
        $genres = Genre::orderBy('name')->get();
        return view('admin.films.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'genre'     => 'required|array|min:1',
            'genre.*'   => 'string|max:50',
            'durasi'    => 'required|integer|min:1',
            'deskripsi' => 'required|string',
            'poster'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['judul', 'durasi', 'deskripsi']);
        $data['genre'] = implode(' / ', $request->input('genre'));

        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        Film::create($data);
        return redirect()->route('admin.films.index')->with('success', 'Film berhasil ditambahkan!');
    }

    public function edit(Film $film)
    {
        $genres = Genre::orderBy('name')->get();
        return view('admin.films.edit', compact('film', 'genres'));
    }

    public function update(Request $request, Film $film)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'genre'     => 'required|array|min:1',
            'genre.*'   => 'string|max:50',
            'durasi'    => 'required|integer|min:1',
            'deskripsi' => 'required|string',
            'poster'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['judul', 'durasi', 'deskripsi']);
        $data['genre'] = implode(' / ', $request->input('genre'));

        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $film->update($data);
        return redirect()->route('admin.films.index')->with('success', 'Film berhasil diupdate!');
    }

    public function destroy(Film $film)
    {
        $film->delete();
        return redirect()->route('admin.films.index')->with('success', 'Film berhasil dihapus!');
    }

    /**
     * Store a newly created genre via AJAX.
     */
    public function storeGenre(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:genres,name',
        ]);

        $genre = Genre::create([
            'name' => trim($request->name),
        ]);

        return response()->json([
            'success' => true,
            'genre' => $genre,
        ]);
    }
}