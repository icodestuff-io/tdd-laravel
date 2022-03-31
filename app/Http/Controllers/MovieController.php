<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::get();

        return new Response($movies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateMovieRequest $request
     * @return Response
     */
    public function store(CreateMovieRequest $request)
    {
        $fileName = $request->name . "." . $request->file('cover')->getClientOriginalExtension();

        $data = $request->all();
        $request->file('cover')->storePubliclyAs("public/images", $fileName);

        $data['cover'] = asset("storage/images/$fileName");

        $movie = Movie::create($data);

        return new Response($movie);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Movie::findOrFail($id);

        return new Response($movie);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMovieRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( $id, UpdateMovieRequest $request)
    {
        $movie = Movie::findOrFail($id);

        if ($request->has('name')) {
            $movie->update(['name' => $request->name]);
        }

        if ($request->has('release_year')) {
            $movie->update(['release_year' => $request->release_year]);
        }

        if ($request->has('director')) {
            $movie->update(['director' => $request->director]);
        }

        if ($request->has('description')) {
            $movie->update(['description' => $request->description]);
        }

        if ($request->has('genre')) {
            $movie->update(['genre' => $request->genre]);
        }

        if ($request->has('cover')) {
            $fileName = $request->name . "." . $request->file('cover')->getClientOriginalExtension();
            $request->file('cover')->storePubliclyAs("public/images", $fileName);
            $movie->update(['cover' => asset("storage/images/$fileName")]);
        }

        return new Response($movie->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);

        $movie->delete();

        return new Response(['message' => "Successfully removed $movie->name"]);
    }
}
