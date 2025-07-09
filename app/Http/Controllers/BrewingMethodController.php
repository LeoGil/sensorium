<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrewingMethod\StoreBrewingMethodRequest;
use App\Http\Requests\BrewingMethod\UpdateBrewingMethodRequest;
use App\Models\BrewingMethod;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class BrewingMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brewingMethods = BrewingMethod::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        return Inertia::render('brewing-method/Index', [
            'brewingMethods' => $brewingMethods,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrewingMethodRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = Storage::disk('public')->putFile('brewing-methods', $request->file('image'));
        }

        BrewingMethod::create($data);

        return to_route('brewing-methods.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrewingMethodRequest $request, BrewingMethod $brewingMethod)
    {
        Gate::authorize('update', $brewingMethod);

        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            if ($brewingMethod->image) {
                Storage::disk('public')->delete($brewingMethod->image);
            }
            $data['image'] = Storage::disk('public')->putFile('brewing-methods', $request->file('image'));
        }

        $brewingMethod->update($data);

        return to_route('brewing-methods.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BrewingMethod $brewingMethod)
    {
        Gate::authorize('delete', $brewingMethod);

        if ($brewingMethod->image) {
            Storage::disk('public')->delete($brewingMethod->image);
        }

        $brewingMethod->delete();

        return to_route('brewing-methods.index');
    }
}
