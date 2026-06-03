<?php

namespace Tests\Feature;

use App\Models\Film;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilmGenreTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat user admin
        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);
    }

    /**
     * Test admin can create a new genre via AJAX route.
     */
    public function test_admin_can_store_new_genre_via_ajax(): void
    {
        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.genres.store'), [
                'name' => 'Misteri',
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'genre' => [
                    'name' => 'Misteri',
                ]
            ]);

        $this->assertDatabaseHas('genres', [
            'name' => 'Misteri',
        ]);
    }

    /**
     * Test validation on storing duplicate genre.
     */
    public function test_admin_cannot_store_duplicate_genre(): void
    {
        Genre::create(['name' => 'Fantasy-Horror']);

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.genres.store'), [
                'name' => 'Fantasy-Horror',
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    /**
     * Test admin can create a film with multiple selected genres.
     */
    public function test_admin_can_create_film_with_multiple_genres(): void
    {
        $genres = ['Action', 'Thriller', 'Sci-Fi'];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.films.store'), [
                'judul' => 'Inception',
                'genre' => $genres,
                'durasi' => 148,
                'deskripsi' => 'A thief who steals corporate secrets through the use of dream-sharing technology.',
            ]);

        $response->assertRedirect(route('admin.films.index'));

        // Cek apakah data tersimpan di database dalam format string terpisah koma
        $film = Film::where('judul', 'Inception')->first();
        $this->assertNotNull($film);
        $this->assertEquals('Action / Thriller / Sci-Fi', $film->genre);
    }

    /**
     * Test admin can update a film's genres.
     */
    public function test_admin_can_update_film_genres(): void
    {
        $film = Film::create([
            'judul' => 'Inception',
            'genre' => 'Action, Thriller',
            'durasi' => 148,
            'deskripsi' => 'Original description',
        ]);

        $response = $this->actingAs($this->admin)
            ->put(route('admin.films.update', $film), [
                'judul' => 'Inception Updated',
                'genre' => ['Sci-Fi', 'Adventure'],
                'durasi' => 150,
                'deskripsi' => 'Updated description',
            ]);

        $response->assertRedirect(route('admin.films.index'));

        $film->refresh();
        $this->assertEquals('Inception Updated', $film->judul);
        $this->assertEquals('Sci-Fi / Adventure', $film->genre);
    }

    /**
     * Test visitors can filter films on home page by multiple genres.
     */
    public function test_user_can_filter_films_by_multiple_genres(): void
    {
        $film1 = Film::create([
            'judul' => 'Action Movie',
            'genre' => 'Action / Adventure',
            'durasi' => 120,
            'deskripsi' => 'An action packed movie.',
        ]);

        $film2 = Film::create([
            'judul' => 'Comedy Movie',
            'genre' => 'Comedy / Romance',
            'durasi' => 100,
            'deskripsi' => 'A funny movie.',
        ]);

        $film3 = Film::create([
            'judul' => 'Drama Movie',
            'genre' => 'Drama',
            'durasi' => 110,
            'deskripsi' => 'A serious movie.',
        ]);

        // Request with action and comedy filters
        $response = $this->get(route('home', ['genre' => ['Action', 'Comedy']]));

        $response->assertStatus(200);
        $response->assertSee('Action Movie');
        $response->assertSee('Comedy Movie');
        $response->assertDontSee('Drama Movie');
    }
}
