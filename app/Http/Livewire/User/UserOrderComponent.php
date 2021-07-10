<?php

namespace App\Http\Livewire\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Livewire\Component;

class UserOrderComponent extends Component
{
    public function render()
    {
        $orders = Order::where('user_id', Auth::user()->id)->paginate(10);
        return view('livewire.user.user-order-component', ['orders' => $orders])->layout('layouts.index');
    }
}
