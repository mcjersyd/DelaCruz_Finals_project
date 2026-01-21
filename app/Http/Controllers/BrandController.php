<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Vehicle;
use App\Traits\HandleFileUploads;
use App\Services\PDFExportService;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    use HandleFileUploads;

    public function index()
    {
        $vehicles = Vehicle::with('brand')->get();
        $brands = Brand::all();

        // Use the same welcome.blade.php view
        return view('welcome', compact('vehicles', 'brands'));
    }

    public function vehicles($id)
    {
        $brand = Brand::findOrFail($id);
        $vehicles = Vehicle::where('brand_id', $id)->paginate(10);

        return view('Brands.vehicles', compact('brand', 'vehicles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $exists = Brand::where('name', $value)->whereNull('deleted_at')->exists();
                    if ($exists) {
                        $fail('The ' . $attribute . ' has already been taken.');
                    }
                }
            ],
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only('name');

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->uploadPhoto($request->file('photo'), 'brands');
        }

        Brand::create($data);

        return redirect()->back()->with('success', 'Brand added successfully!');
    }

    public function show(Brand $brand)
    {
        return view('Brands.show', compact('brand'));
    }

    public function edit(Brand $brand)
    {
        return view('Brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($brand) {
                    $exists = Brand::where('name', $value)
                        ->where('id', '!=', $brand->id)
                        ->whereNull('deleted_at')
                        ->exists();
                    if ($exists) {
                        $fail('The ' . $attribute . ' has already been taken.');
                    }
                }
            ],
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only('name');

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->updatePhoto($brand->photo, $request->file('photo'), 'brands');
        }

        $brand->update($data);

        return redirect()->route('dashboard')->with('success', 'Brand updated successfully!');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete(); // Soft delete

        return redirect()->back()->with('success', 'Brand moved to trash!');
    }

    public function restore($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);
        $brand->restore();

        return redirect()->back()->with('success', 'Brand restored successfully!');
    }

    public function permanentDelete($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);
        
        // Delete photo from storage
        if ($brand->photo && Storage::disk('public')->exists($brand->photo)) {
            Storage::disk('public')->delete($brand->photo);
        }
        
        $brand->forceDelete();

        return redirect()->back()->with('success', 'Brand permanently deleted!');
    }

    public function trash()
    {
        $brands = Brand::onlyTrashed()->paginate(10);
        return view('Brands.trash', compact('brands'));
    }

    public function exportPDF()
    {
        $brands = Brand::all();
        $pdfService = new PDFExportService();
        return $pdfService->exportBrands($brands);
    }
}
