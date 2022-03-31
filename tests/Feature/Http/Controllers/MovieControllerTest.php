<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class MovieControllerTest extends TestCase
{
    public function test_user_can_see_list_of_movies(): void
    {
        $this->get(route('movies.index'))
            ->assertOk()
            ->assertJsonStructure([
                ['id', 'name', 'director', 'release_year']
            ]);
    }

    public function test_user_can_see_a_single_movie(): void
    {
        $movie = Movie::first();

        $this->get(route('movies.show', ['movie' => $movie->id]))
            ->assertOk()
            ->assertJsonStructure(['id', 'name', 'director', 'release_year']);
    }

    public function test_user_can_add_a_movie(): void
    {
        $this->assertDatabaseMissing('movies', ['name' => 'Goodfellas']);

        $this->post(route('movies.store'), [
            'name' => 'Goodfellas',
            'release_year' => '1990',
            'director' => 'Martin Scorsese',
            'description' => 'A young man grows up in the mob and advances himself through the ranks',
            'genre' => ['crime','drama'],
            'cover' => UploadedFile::fake()->image('cover.jpg')
        ])->assertOk();

        $this->assertDatabaseHas('movies', ['name' => 'Goodfellas']);
    }

    public function test_user_can_remove_movie(): void
    {
        $movie = Movie::first();

        $this->delete(route('movies.destroy', ['movie' => $movie->id]))
            ->assertOk();

        $this->assertDatabaseMissing('movies', ['id' => $movie->id]);
    }

    public function test_user_can_edit_existing_movie(): void
    {
        $movie = Movie::first();

        $this->post(route('movies.update', ['movie' => $movie->id]), [
            'name' => 'FooBarBaz'
        ])->assertOk();

        $this->assertDatabaseHas('movies', ['id' => $movie->id, 'name' => 'FooBarBaz']);
    }
}
