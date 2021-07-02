<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\HomeSlider;
use App\Models\Product;
use App\Models\HomeCategory;
use App\Models\Category;
use App\Models\Sale;

class HomeComponent extends Component
{
    public function render()
    {
        $homeSlider = HomeSlider::where('status', 1)->get();
        $lastestProducts = Product::orderBy('created_at', 'DESC')->get()->take(8);
        $category = HomeCategory::find(1);
        $cats = explode(',', $category->sel_categories);
        $categories = Category::whereIn('id', $cats)->get();
        $no_of_products = $category->number_of_products;
        $sale = Sale::find(1);
        $sale_products = Product::where('sale_price', '>', 0)->inRandomOrder()->get();
        return view('livewire.home-component', [
            'homeSlider' => $homeSlider,
            'lastestProducts' => $lastestProducts,
            'categories' => $categories,
            'no_of_products' => $no_of_products,
            'sale_products' => $sale_products,
            'sale' => $sale
            ])->layout('layouts.index');
    }
}
