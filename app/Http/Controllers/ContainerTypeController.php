<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContainerType\StoreContainerTypeRequest;
use App\Http\Requests\ContainerType\UpdateContainerTypeRequest;
use App\Models\ContainerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
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

        if ($request->hasFile('image')) {
            $containerTypeData['image'] = Storage::disk('public')->putFile('container-types', $request->file('image'));
        }

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

        if ($request->hasFile('image')) {
            if ($containerType->image) {
                Storage::disk('public')->delete($containerType->image);
            }
            $containerTypeData['image'] = Storage::disk('public')->putFile('container-types', $request->file('image'));
        }

        $containerType->update($containerTypeData);
        return to_route('container-types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContainerType $containerType)
    {
        Gate::authorize('delete', $containerType);

        if ($containerType->image) {
            Storage::disk('public')->delete($containerType->image);
        }

        $containerType->delete();
        return to_route('container-types.index');
    }
}
