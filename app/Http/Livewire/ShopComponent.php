<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\withPagination;
use Cart;

class ShopComponent extends Component
{
    public $sorting;
    public $pageSize;

    public function mount()
    {
        $this->sorting = "deafult";
        $this->pageSize = 12;
    }

    public function store($product_id, $product_name, $product_price)
    {
        Cart::add($product_id, $product_name, 1, $product_price)->associate('App\Models\Product');
        session()->flash('success_message', 'Item added in cart.');
        return redirect()->route('product.cart');
    }

    use withPagination;
    public function render()
    {
        if($this->sorting=='date')
        {
            $products = Product::orderBy('created_at', 'DESC')->paginate($this->pageSize);
        }

        else if($this->sorting=='price')
        {
            $products = Product::orderBy('regular_price', 'ASC')->paginate($this->pageSize);
        }

        else if($this->sorting=='price-desc')
        {
            $products = Product::orderBy('regular_price', 'DESC')->paginate($this->pageSize);
        }
        
        else
        {
            $products = Product::paginate($this->pageSize);
        }

        $categories = Category::all();
        
        return view('livewire.shop-component', ['products' => $products, 'categories' => $categories])->layout('layouts.index');
    }
}
