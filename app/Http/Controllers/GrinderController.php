<?php

namespace App\Http\Controllers;

use App\Http\Requests\Grinder\StoreGrinderRequest;
use App\Http\Requests\Grinder\UpdateGrinderRequest;
use App\Models\Grinder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class GrinderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grinders = Grinder::where('user_id', auth()->id())
            ->orderBy('brand')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return Inertia::render('grinder/Index', [
            'grinders' => $grinders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGrinderRequest $request)
    {
        $grinderData = $request->validated();
        $grinderData['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $grinderData['image'] = Storage::disk('public')->putFile('grinders', $request->file('image'));
        }

        Grinder::create($grinderData);
        return to_route('grinders.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGrinderRequest $request, Grinder $grinder)
    {
        Gate::authorize('update', $grinder);

        $grinderData = $request->validated();

        if ($request->hasFile('image')) {
            if ($grinder->image) {
                Storage::disk('public')->delete($grinder->image);
            }
            $grinderData['image'] = Storage::disk('public')->putFile('grinders', $request->file('image'));
        }

        $grinder->update($grinderData);
        return to_route('grinders.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grinder $grinder)
    {
        Gate::authorize('delete', $grinder);

        if ($grinder->image) {
            Storage::disk('public')->delete($grinder->image);
        }

        $grinder->delete();
        return to_route('grinders.index');
    }
} 