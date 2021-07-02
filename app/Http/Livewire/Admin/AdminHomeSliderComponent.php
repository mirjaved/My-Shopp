<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\HomeSlider;
use Livewire\WithPagination;

class AdminHomeSliderComponent extends Component
{
    use WithPagination;
    
    public function deleteHomeSlide($slide_id)
    {
        $slide = HomeSlider::find($slide_id);
        $slide->delete();
        session()->flash('message', 'Slide deleted successfully!');
    }

    public function render()
    {
        $sliders = HomeSlider::orderBy('id', 'DESC')->paginate(10);
        return view('livewire.admin.admin-home-slider-component', ['sliders' => $sliders])->layout('layouts.index');
    }
}
