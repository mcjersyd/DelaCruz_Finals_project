<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Vehicle;
use App\Models\Brand;

class VehicleSearch extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $vehicles = Vehicle::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('plate_number', 'like', '%' . $this->search . '%')
            ->orWhere('color', 'like', '%' . $this->search . '%')
            ->orWhereHas('brand', function($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.vehicle-search', [
            'vehicles' => $vehicles,
        ]);
    }
}
