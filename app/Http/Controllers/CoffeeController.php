<?php

namespace App\Http\Controllers;

use App\Http\Requests\Coffee\StoreCoffeeRequest;
use App\Http\Requests\Coffee\UpdateCoffeeRequest;
use App\Models\Coffee;
use App\Models\RoastLevel;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CoffeeController extends Controller
{
    public function index()
    {
        $coffees = Coffee::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        $roastLevels = RoastLevel::where('user_id', auth()->id())
            ->orderBy('name', 'asc')
            ->get();

        $brands = auth()->user()->brands()
            ->orderBy('name', 'asc')
            ->get();

        return Inertia::render('coffee/Index', [
            'coffees' => $coffees,
            'roastLevels' => $roastLevels,
            'brands' => $brands,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roastLevels = RoastLevel::where('user_id', auth()->id())
            ->orderBy('name', 'asc')
            ->get();

        $brands = auth()->user()->brands()
            ->orderBy('name', 'asc')
            ->get();

        return Inertia::render('coffee/Create', [
            'roastLevels' => $roastLevels,
            'brands' => $brands,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCoffeeRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = Storage::disk('public')->putFile('coffees', $request->file('image'));
        }

        Coffee::create($data);

        return to_route('coffees.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coffee $coffee)
    {
        Gate::authorize('update', $coffee);

        $roastLevels = RoastLevel::where('user_id', auth()->id())
            ->orderBy('name', 'asc')
            ->get();

        $brands = auth()->user()->brands()
            ->orderBy('name', 'asc')
            ->get();

        return Inertia::render('coffee/Edit', [
            'coffee' => $coffee,
            'roastLevels' => $roastLevels,
            'brands' => $brands,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCoffeeRequest $request, Coffee $coffee)
    {
        Gate::authorize('update', $coffee);

        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($coffee->image) {
                Storage::disk('public')->delete($coffee->image);
            }
            $data['image'] = Storage::disk('public')->putFile('coffees', $request->file('image'));
        }

        $coffee->update($data);

        return to_route('coffees.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coffee $coffee)
    {
        Gate::authorize('forceDelete', $coffee);

        if ($coffee->image) {
            Storage::disk('public')->delete($coffee->image);
        }

        $coffee->delete();

        return to_route('coffees.index');
    }
}
