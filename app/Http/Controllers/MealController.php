<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Yajra\DataTables\Facades\DataTables;

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
        Meal::create($request->all());

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
        $meal->update($request->all());
        return redirect()->route('meals-show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $meal = Meal::findOrFail($id);
        $meal->delete();
        return redirect()->route('meals-index');
    }
}
