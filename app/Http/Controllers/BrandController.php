<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::where('user_id', auth()->id())
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return Inertia::render('brand/Index', [
            'brands' => $brands,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $brand = $request->validated();

        $logo = $brand['logo'] ?? null;

        $brand['user_id'] = auth()->id();

        if ($logo) {
            $brand['logo'] = Storage::disk('public')->putFile('brands', $logo);
        }

        Brand::create($brand);

        return to_route('brands.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        Gate::authorize('update', $brand);

        $brandData = $request->validated();

        $logo = $brandData['logo'] ?? null;

        if ($logo) {
            $brandData['logo'] = Storage::disk('public')->putFile('brands', $logo);
            if ($brand->logo) {
                Storage::disk('public')->delete($brand->logo);
            }
        } else {
            $brandData['logo'] = $brand->logo;
        }

        $brand->update($brandData);

        return to_route('brands.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        Gate::authorize('forceDelete', $brand);

        if ($brand->logo) {
            Storage::disk('public')->delete($brand->logo);
        }

        $brand->delete();

        return to_route('brands.index');
    }
}
