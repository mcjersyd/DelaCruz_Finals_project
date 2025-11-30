<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Brand;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('brand')->get();
        $brands = Brand::all();
        return view('welcome', compact('vehicles', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'plate_number' => 'required|string|max:50|unique:vehicles,plate_number',
            'color' => 'required|string|max:100', // ✅ add color validation
            'brand_id' => 'nullable|exists:brands,id',
        ]);

        Vehicle::create($request->only('name', 'plate_number', 'color', 'brand_id'));

        return redirect()->back()->with('success', 'Vehicle added successfully!');
    }

    public function edit(Vehicle $vehicle)
    {
        $brands = Brand::all();
        return view('vehicles.edit', compact('vehicle', 'brands'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'plate_number' => 'required|string|max:50|unique:vehicles,plate_number,' . $vehicle->id,
            'color' => 'required|string|max:100',
            'brand_id' => 'nullable|exists:brands,id',
        ]);

        $vehicle->update($request->only('name', 'plate_number', 'color', 'brand_id'));

        return redirect()->route('dashboard')->with('success', 'Vehicle updated successfully!');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->back()->with('success', 'Vehicle deleted successfully!');
    }
}
