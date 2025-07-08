<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoastLevel\StoreRoastLevelRequest;
use App\Http\Requests\RoastLevel\UpdateRoastLevelRequest;
use App\Models\RoastLevel;
use Illuminate\Support\Facades\Gate;

class RoastLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roastLevels = RoastLevel::where('user_id', auth()->id())
            ->orderBy('created_at', 'asc')
            ->paginate(10)
            ->withQueryString();

        return inertia('roast-level/Index', [
            'roastLevels' => $roastLevels,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoastLevelRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        RoastLevel::create($data);

        return to_route('roast-levels.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoastLevelRequest $request, RoastLevel $roastLevel)
    {
        Gate::authorize('update', $roastLevel);

        $data = $request->validated();

        $roastLevel->update($data);

        return to_route('roast-levels.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoastLevel $roastLevel)
    {
        Gate::authorize('forceDelete', $roastLevel);

        $roastLevel->delete();

        return to_route('roast-levels.index');
    }

    public function createDefault()
    {
        Gate::authorize('createDefault', RoastLevel::class);

        $userId = auth()->id();

        $roastLevels = [
            [
                'name' => 'Claro',
                'description' => 'Claro',
                'user_id' => $userId,
            ],
            [
                'name' => 'Médio Claro',
                'description' => 'Médio Claro',
                'user_id' => $userId,
            ],
            [
                'name' => 'Médio',
                'description' => 'Médio',
                'user_id' => $userId,
            ],
            [
                'name' => 'Médio Escuro',
                'description' => 'Médio Escuro',
                'user_id' => $userId,
            ],
            [
                'name' => 'Escuro',
                'description' => 'Escuro',
                'user_id' => $userId,
            ],
        ];

        foreach ($roastLevels as $roastLevel) {
            RoastLevel::create($roastLevel);
        }

        return to_route('roast-levels.index');
    }
}
