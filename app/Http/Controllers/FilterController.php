<?php

namespace App\Http\Controllers;

use App\Http\Requests\Filter\StoreFilterRequest;
use App\Http\Requests\Filter\UpdateFilterRequest;
use App\Models\Filter;
use App\Models\BrewingMethod;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class FilterController extends Controller
{
    public function index()
    {
        $filters = Filter::where('user_id', auth()->id())
            ->orderBy('brand')
            ->orderBy('name')
            ->with('brewingMethods')
            ->paginate(12)
            ->withQueryString();

        $brewingMethods = BrewingMethod::where('user_id', auth()->id())->get();

        return Inertia::render('filter/Index', [
            'filters' => $filters,
            'brewingMethods' => $brewingMethods
        ]);
    }

    public function store(StoreFilterRequest $request)
    {
        $filterData = $request->validated();
        $brewingMethods = $filterData['brewing_methods'] ?? [];
        unset($filterData['brewing_methods']);
        
        $filterData['user_id'] = auth()->id();
        $filter = Filter::create($filterData);
        
        // Salvar as relações com brewing methods
        if (!empty($brewingMethods)) {
            $filter->brewingMethods()->attach($brewingMethods);
        }
        
        return to_route('filters.index');
    }

    public function update(UpdateFilterRequest $request, Filter $filter)
    {
        Gate::authorize('update', $filter);
        
        $filterData = $request->validated();
        $brewingMethods = $filterData['brewing_methods'] ?? [];
        unset($filterData['brewing_methods']);
        
        $filter->update($filterData);
        
        // Atualizar as relações com brewing methods
        $filter->brewingMethods()->sync($brewingMethods);
        
        return to_route('filters.index');
    }

    public function destroy(Filter $filter)
    {
        Gate::authorize('delete', $filter);
        $filter->delete();
        return to_route('filters.index');
    }
}
