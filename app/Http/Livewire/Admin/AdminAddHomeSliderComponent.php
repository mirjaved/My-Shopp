<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\HomeSlider;
use Carbon\Carbon;
use Livewire\WithFileUploads;

class AdminAddHomeSliderComponent extends Component
{
    use WithFileUploads;

    public $image;
    public $title;
    public $subtitle;
    public $price;
    public $link;
    public $status;

    public function mount()
    {
        $this->status = 0;
    }

    public function resetInputFields()
    {        
        $this->image = '';
        $this->title = '';
        $this->subtitle = '';
        $this->price = '';
        $this->link = '';
        $this->status = ''; 
    }

    public function addSlide()
    {
        $slider = new HomeSlider();        
        $slider->title  = $this->title;
        $slider->subtitle = $this->subtitle;
        $slider->price = $this->price;
        $slider->link = $this->link;
        $slider->status = $this->status;        
        $imageName = Carbon::now()->timestamp.'.'.$this->image->extension();
        $this->image->storeAs('sliders', $imageName);
        $slider->image = $imageName;
        $slider->save();
        session()->flash('message', 'Slide added successfully!');
        $this->resetInputFields();
    }

    public function render()
    {
        return view('livewire.admin.admin-add-home-slider-component')->layout('layouts.index');
    }
}
