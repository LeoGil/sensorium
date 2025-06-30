<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
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
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Brands/Index', [
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
            $brand['logo'] = $logo->store('brands', 'public');
        }

        Brand::create($brand);

        return to_route('brands.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $brandData = $request->validated();

        $logo = $brandData['logo'] ?? null;

        if ($logo) {
            $brandData['logo'] = $logo->store('brands', 'public');
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
        //
    }
}
