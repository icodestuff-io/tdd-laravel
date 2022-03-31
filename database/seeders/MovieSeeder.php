<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = file_get_contents(database_path('movies.json'));
        $movies = collect(json_decode($data, TRUE));

        $movies->map(function ($movie) {
            $movie['cover'] = asset($movie['cover']);
            Movie::create($movie);
        });
    }
}
