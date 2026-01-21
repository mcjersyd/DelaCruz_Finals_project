<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Brand;
use App\Traits\HandleFileUploads;
use App\Services\PDFExportService;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    use HandleFileUploads;

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
            'plate_number' => [
                'required',
                'string',
                'max:50',
                function ($attribute, $value, $fail) {
                    $exists = Vehicle::where('plate_number', $value)->whereNull('deleted_at')->exists();
                    if ($exists) {
                        $fail('The ' . $attribute . ' has already been taken.');
                    }
                }
            ],
            'color' => 'required|string|max:100',
            'brand_id' => 'nullable|exists:brands,id',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only('name', 'plate_number', 'color', 'brand_id');

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->uploadPhoto($request->file('photo'), 'vehicles');
        }

        Vehicle::create($data);

        return redirect()->back()->with('success', 'Vehicle added successfully!');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load('brand');
        return view('vehicles.show', compact('vehicle'));
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
            'plate_number' => [
                'required',
                'string',
                'max:50',
                function ($attribute, $value, $fail) use ($vehicle) {
                    $exists = Vehicle::where('plate_number', $value)
                        ->where('id', '!=', $vehicle->id)
                        ->whereNull('deleted_at')
                        ->exists();
                    if ($exists) {
                        $fail('The ' . $attribute . ' has already been taken.');
                    }
                }
            ],
            'color' => 'required|string|max:100',
            'brand_id' => 'nullable|exists:brands,id',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only('name', 'plate_number', 'color', 'brand_id');

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->updatePhoto($vehicle->photo, $request->file('photo'), 'vehicles');
        }

        $vehicle->update($data);

        return redirect()->route('dashboard')->with('success', 'Vehicle updated successfully!');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete(); // Soft delete
        return redirect()->back()->with('success', 'Vehicle moved to trash!');
    }

    public function restore($id)
    {
        $vehicle = Vehicle::onlyTrashed()->findOrFail($id);
        $vehicle->restore();

        return redirect()->back()->with('success', 'Vehicle restored successfully!');
    }

    public function permanentDelete($id)
    {
        $vehicle = Vehicle::onlyTrashed()->findOrFail($id);
        
        // Delete photo from storage
        if ($vehicle->photo && Storage::disk('public')->exists($vehicle->photo)) {
            Storage::disk('public')->delete($vehicle->photo);
        }
        
        $vehicle->forceDelete();

        return redirect()->back()->with('success', 'Vehicle permanently deleted!');
    }

    public function trash()
    {
        $vehicles = Vehicle::onlyTrashed()->paginate(10);
        return view('vehicles.trash', compact('vehicles'));
    }

    public function exportPDF()
    {
        $vehicles = Vehicle::all();
        $pdfService = new PDFExportService();
        return $pdfService->exportVehicles($vehicles);
    }
}
