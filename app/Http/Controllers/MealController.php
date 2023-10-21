<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $meals = Meal::all();

        return view('admin.meals.index', compact('meals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.meals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if ($request->hasFile('photo')) {

            $path = $request->file('photo')->store('photos');
            $meal = new Meal($request->all());
            $meal->image_url = $path;
            $meal->category_id = 1; //TODO: mijenjaj ovo nakon sto zavrsis sa ai
            $meal->save();

        } elseif ($request->photo_url) {
            dd('works');
            $url = $request->photo_url;
            $client = new Client();
            $fileContents = $client->get($url)->getBody();
            $path = '/photos/'.Str::uuid().'.png';
            Storage::put($path, $fileContents);
            $meal = new Meal($request->all());
            $meal->image_url = $path;
            $meal->category_id = 1; //TODO: change this
            $meal->save();

        } else {
            Meal::create($request->all());
        }

        return redirect()->route('meals-index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $meal = Meal::findOrFail($id);
        return view('admin.meals.show', compact('meal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $meal = Meal::findOrFail($id);
        return view('admin.meals.edit', compact('meal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $meal = Meal::findOrFail($id);

        if ($request->hasFile('photo')) {

            $path = $request->file('photo')->store('photos');
            Storage::delete($meal->image_url);

            $meal->image_url = $path;
            $meal->meal_name = $request->meal_name;
            $meal->description = $request->description;
            $meal->price = $request->price;
            $meal->dietary_restrictions = $request->dietary_restrictions;

            $meal->update();

        } elseif ($request->photo_url) {

            $url = $request->photo_url;
            $client = new Client();
            $fileContents = $client->get($url)->getBody();
            $path = 'photos/'.Str::uuid().'.png';

            Storage::delete($meal->image_url);
            Storage::put($path, $fileContents);

            $meal->meal_name = $request->meal_name;
            $meal->description = $request->description;
            $meal->price = $request->price;
            $meal->image_url = $path;
            $meal->dietary_restrictions = $request->dietary_restrictions;
            $meal->update();

        } else {
            $meal->update($request->all());
        }

        return redirect()->route('meals-show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $meal = Meal::findOrFail($id);
        Storage::delete($meal->image_url);
        $meal->delete();
        return redirect()->route('meals-index');
    }
}
