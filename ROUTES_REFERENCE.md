# New Routes & Endpoints Reference

## Photo Upload Routes (Existing CRUD)
- Form file inputs added to existing routes:
  - `POST /brands` - Create brand with photo
  - `POST /brands/{id}` - Update brand with photo
  - `POST /vehicles` - Create vehicle with photo
  - `POST /vehicles/{id}` - Update vehicle with photo

## Trash Management Routes

### Brands Trash
```
GET  /brands/trash              → Show all deleted brands
POST /brands/{id}/restore       → Restore a deleted brand
DELETE /brands/{id}/permanent-delete → Permanently delete a brand
```

### Vehicles Trash
```
GET  /vehicles/trash            → Show all deleted vehicles
POST /vehicles/{id}/restore     → Restore a deleted vehicle
DELETE /vehicles/{id}/permanent-delete → Permanently delete a vehicle
```

## PDF Export Routes
```
GET /brands/export/pdf          → Download brands as PDF
GET /vehicles/export/pdf        → Download vehicles as PDF
```

---

## API Usage Examples

### Upload Brand Photo
```html
<form action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="file" name="photo" accept=".jpg,.jpeg,.png">
    <button type="submit">Update Brand</button>
</form>
```

### Restore Brand
```html
<form action="{{ route('brands.restore', $brand->id) }}" method="POST">
    @csrf
    <button type="submit">Restore</button>
</form>
```

### Permanent Delete Brand
```html
<form action="{{ route('brands.permanent-delete', $brand->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Are you sure?')">Delete Permanently</button>
</form>
```

### Export PDF
```html
<a href="{{ route('brands.export-pdf') }}" class="btn">Export Brands to PDF</a>
<a href="{{ route('vehicles.export-pdf') }}" class="btn">Export Vehicles to PDF</a>
```

---

## Named Routes

### Brand Routes
- `brands.index` - List all brands
- `brands.create` - Create brand form
- `brands.store` - Store brand
- `brands.show` - Show brand
- `brands.edit` - Edit brand form
- `brands.update` - Update brand (with photo support)
- `brands.destroy` - Delete brand (soft delete)
- `brands.trash` - View trash
- `brands.restore` - Restore from trash
- `brands.permanent-delete` - Permanent delete
- `brands.export-pdf` - Export to PDF
- `brands.vehicles` - View vehicles of a brand

### Vehicle Routes
- `vehicles.index` - List all vehicles
- `vehicles.create` - Create vehicle form
- `vehicles.store` - Store vehicle
- `vehicles.show` - Show vehicle
- `vehicles.edit` - Edit vehicle form
- `vehicles.update` - Update vehicle (with photo support)
- `vehicles.destroy` - Delete vehicle (soft delete)
- `vehicles.trash` - View trash
- `vehicles.restore` - Restore from trash
- `vehicles.permanent-delete` - Permanent delete
- `vehicles.export-pdf` - Export to PDF

---

## Controller Methods

### BrandController
- `index()` - List brands
- `store($request)` - Create brand with photo upload
- `edit(Brand $brand)` - Edit form
- `update($request, Brand $brand)` - Update with photo handling
- `destroy(Brand $brand)` - Soft delete
- `trash()` - Show trash
- `restore($id)` - Restore from trash
- `permanentDelete($id)` - Hard delete
- `exportPDF()` - Generate PDF

### VehicleController
- `index()` - List vehicles
- `store($request)` - Create vehicle with photo upload
- `edit(Vehicle $vehicle)` - Edit form
- `update($request, Vehicle $vehicle)` - Update with photo handling
- `destroy(Vehicle $vehicle)` - Soft delete
- `trash()` - Show trash
- `restore($id)` - Restore from trash
- `permanentDelete($id)` - Hard delete
- `exportPDF()` - Generate PDF

---

## Helper Methods (Traits)

### HandleFileUploads Trait
```php
// Upload new photo
$path = $this->uploadPhoto($request->file('photo'), 'brands');

// Update photo (deletes old, saves new)
$path = $this->updatePhoto($oldPath, $request->file('photo'), 'brands');
```

### Model Methods

```php
// Get initials for avatar fallback
$initials = $brand->getInitials();  // e.g., "TM" for "Toyota Motors"
$initials = $vehicle->getInitials(); // e.g., "MA" for "Mercedes AMG"

// Soft delete query
Brand::onlyTrashed()->get();        // Get only deleted brands
Brand::whereNotNull('deleted_at')->get(); // Alternative

// Restore
$brand->restore();

// Permanent delete
$brand->forceDelete();
```

---

## View Components

### Photo Display in Tables
```html
@if($brand->photo)
    <img src="{{ asset('storage/' . $brand->photo) }}" alt="{{ $brand->name }}">
@else
    <div class="avatar">
        {{ $brand->getInitials() }}
    </div>
@endif
```

### Export Button
```html
<a href="{{ route('brands.export-pdf') }}" class="btn">📥 Export PDF</a>
```

---

## Database Queries

### Check Trash Records
```php
// Soft deleted brands
Brand::onlyTrashed()->count();

// All brands including trashed
Brand::withTrashed()->count();

// Active brands only
Brand::count();
```

### Restore Multiple Records
```php
Brand::onlyTrashed()->restore();
Vehicle::onlyTrashed()->restore();
```

### Permanent Delete Multiple
```php
Brand::onlyTrashed()->forceDelete();
Vehicle::onlyTrashed()->forceDelete();
```

---

## Validation Rules

### File Upload Validation
```php
'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
```

**Rules Explained:**
- `nullable` - Optional field
- `image` - Must be a valid image file
- `mimes:jpg,jpeg,png` - Only these MIME types
- `max:2048` - Maximum 2MB (2048 KB)

---

## File Storage Paths

### Upload Directories
- Brand photos: `storage/app/public/brands/`
- Vehicle photos: `storage/app/public/vehicles/`

### Access URLs
```
/storage/brands/filename.jpg
/storage/vehicles/filename.jpg
```

### Setup Symlink
```bash
php artisan storage:link
```

---

**Last Updated:** January 21, 2026
**Version:** 1.0
