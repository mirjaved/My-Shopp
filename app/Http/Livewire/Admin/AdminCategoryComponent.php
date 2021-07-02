<?php

namespace App\Http\Livewire\Admin;
use Livewire\Component;
use App\Models\Category;
use Livewire\withPagination;

class AdminCategoryComponent extends Component
{
    use WithPagination;

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        $category->delete();
        session()->flash('message', 'Category deleted successfully!');
    }

    public function render()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate(5);
        return view('livewire.admin.admin-category-component', ['categories' => $categories])->layout('layouts.index');
    }
}
