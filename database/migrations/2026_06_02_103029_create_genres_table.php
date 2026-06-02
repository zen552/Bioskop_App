<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Daftar genre standar untuk seed awal
        $defaultGenres = [
            'Action',
            'Comedy',
            'Drama',
            'Horror',
            'Romance',
            'Sci-Fi',
            'Thriller',
            'Animation',
            'Adventure',
            'Fantasy',
            'Documentary',
            'Mystery',
            'Family'
        ];

        // Masukkan genre default
        foreach ($defaultGenres as $genre) {
            DB::table('genres')->insertOrIgnore([
                'name' => $genre,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Migrasikan genre yang sudah ada di tabel films jika ada
        try {
            if (Schema::hasTable('films')) {
                $existingGenres = DB::table('films')->pluck('genre')
                    ->flatMap(function ($g) {
                        $splits = preg_split('/[\/,]/', $g);
                        return array_map('trim', $splits);
                    })
                    ->filter()
                    ->unique()
                    ->values();

                foreach ($existingGenres as $genreName) {
                    DB::table('genres')->insertOrIgnore([
                        'name' => $genreName,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Abaikan jika terjadi error (misalnya tabel films belum ada atau kolom genre belum ada)
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genres');
    }
};
