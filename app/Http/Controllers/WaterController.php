<?php

namespace App\Http\Controllers;

use App\Models\Water;
use App\Http\Requests\Water\StoreWaterRequest;
use App\Http\Requests\Water\UpdateWaterRequest;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class WaterController extends Controller
{
    public function index()
    {
        $waters = Water::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        return Inertia::render('water/Index', [
            'waters' => $waters,
        ]);
    }

    public function create()
    {
        return Inertia::render('water/Create');
    }

    public function store(StoreWaterRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['hardness'] = ($data['calcium'] * 2.5) + ($data['magnesium'] * 4.2);
        $data['alkalinity'] = $data['bicarbonate'] * 0.8;
        Water::create($data);
        return to_route('waters.index');
    }

    public function edit(Water $water)
    {
        Gate::authorize('update', $water);
        return Inertia::render('water/Edit', [
            'water' => $water,
        ]);
    }

    public function update(UpdateWaterRequest $request, Water $water)
    {
        Gate::authorize('update', $water);
        $data = $request->validated();
        $data['hardness'] = ($data['calcium'] * 2.5) + ($data['magnesium'] * 4.2);
        $data['alkalinity'] = $data['bicarbonate'] * 0.8;
        $water->update($data);
        return to_route('waters.index');
    }

    public function destroy(Water $water)
    {
        Gate::authorize('forceDelete', $water);
        $water->delete();
        return to_route('waters.index');
    }
} 