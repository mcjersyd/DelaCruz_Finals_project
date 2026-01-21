<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Redirect;
use App\Models\Brand;

class BrandSearch extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedBrand = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function viewVehicles()
    {
        if ($this->selectedBrand) {
            return Redirect::route('brands.vehicles', $this->selectedBrand);
        }
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedBrand = '';
        $this->resetPage();
    }

    public function render()
    {
        $brands = Brand::withCount('vehicles')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.brand-search', [
            'brands' => $brands,
        ]);
    }
}
