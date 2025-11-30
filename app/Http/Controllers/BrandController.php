<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Vehicle;

class BrandController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('brand')->get();
        $brands = Brand::all();

        // Use the same welcome.blade.php view
        return view('welcome', compact('vehicles', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
        ]);

        Brand::create($request->all());

        return redirect()->back()->with('success', 'Brand added successfully!');
    }

    public function edit(Brand $brand)
{
    return view('brands.edit', compact('brand'));
}

public function update(Request $request, Brand $brand)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
    ]);

    $brand->update($request->all());

    return redirect()->route('dashboard')->with('success', 'Brand updated successfully!');
}


    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->back()->with('success', 'Brand deleted successfully!');
    }
}
