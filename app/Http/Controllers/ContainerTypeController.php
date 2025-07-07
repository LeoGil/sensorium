<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContainerType\StoreContainerTypeRequest;
use App\Http\Requests\ContainerType\UpdateContainerTypeRequest;
use App\Models\ContainerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ContainerTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $containerTypes = ContainerType::where('user_id', auth()->id())
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return Inertia::render('container-type/Index', [
            'containerTypes' => $containerTypes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContainerTypeRequest $request)
    {
        $containerTypeData = $request->validated();
        $containerTypeData['user_id'] = auth()->id();
        ContainerType::create($containerTypeData);
        return to_route('container-types.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContainerTypeRequest $request, ContainerType $containerType)
    {
        Gate::authorize('update', $containerType);

        $containerTypeData = $request->validated();

        $containerType->update($containerTypeData);
        return to_route('container-types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContainerType $containerType)
    {
        Gate::authorize('delete', $containerType);

        $containerType->delete();
        return to_route('container-types.index');
    }
}
