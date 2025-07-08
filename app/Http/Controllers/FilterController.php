<?php

namespace App\Http\Controllers;

use App\Http\Requests\Filter\StoreFilterRequest;
use App\Http\Requests\Filter\UpdateFilterRequest;
use App\Models\Filter;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class FilterController extends Controller
{
    public function index()
    {
        $filters = Filter::where('user_id', auth()->id())
            ->orderBy('brand')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return Inertia::render('filter/Index', [
            'filters' => $filters
        ]);
    }

    public function store(StoreFilterRequest $request)
    {
        $filterData = $request->validated();
        $filterData['user_id'] = auth()->id();
        Filter::create($filterData);
        return to_route('filters.index');
    }

    public function update(UpdateFilterRequest $request, Filter $filter)
    {
        Gate::authorize('update', $filter);
        $filterData = $request->validated();
        $filter->update($filterData);
        return to_route('filters.index');
    }

    public function destroy(Filter $filter)
    {
        Gate::authorize('delete', $filter);
        $filter->delete();
        return to_route('filters.index');
    }
} 