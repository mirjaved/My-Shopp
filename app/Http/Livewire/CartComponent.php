<?php

namespace App\Http\Livewire;

use App\Models\Coupon;
use Livewire\Component;
use Cart;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CartComponent extends Component
{
    public $haveCouponCode;
    public $couponCode;
    public $discount;
    public $subtotalAfterDiscount;
    public $taxAfterDiscount;
    public $totalAfterDiscount;

    public function increaseQuantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId, $qty);
        $this->emitTO('cart-count-component', 'refreshComponent');
    }

    public function decreaseQuantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        Cart::instance('cart')->update($rowId, $qty);
        $this->emitTO('cart-count-component', 'refreshComponent');
    }

    public function destroyProduct($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        $this->emitTO('cart-count-component', 'refreshComponent');
        session()->flash('message', 'Item has been removed.');        
    }

    public function destroyAll()
    {
        Cart::instance('cart')->destroy();
        $this->emitTO('cart-count-component', 'refreshComponent');
    }

    public function switchToSaveForLater($rowId)
    {        
        $item = Cart::instance('cart')->get($rowId);
        Cart::instance('cart')->remove($rowId);
        Cart::instance('saveForLater')->add($item->id, $item->name, 1, $item->price)->associate('App\Models\Product');
        $this->emitTO('wish-list-count-component', 'refreshComponent');
        session()->flash('success_message', 'Item is saved for later!');
    }

    public function moveToCart($rowId)
    {        
        $item = Cart::instance('saveForLater')->get($rowId);
        Cart::instance('saveForLater')->remove($rowId);
        Cart::instance('cart')->add($item->id, $item->name, 1, $item->price)->associate('App\Models\Product');
        $this->emitTO('wish-list-count-component', 'refreshComponent');
        session()->flash('s_success_message', 'Item is moved to cart!');
    }

    public function deleteFromSaveForLater($rowId)
    {
        Cart::instance('saveForLater')->remove($rowId);
        session()->flash('s_success_message', 'Item is removed from saved to cart!');
    }

    public function applyCouponCode()
    {
        $coupon = Coupon::where('code', $this->couponCode)->where('expiry_date', '>=', Carbon::today())->where('cart_value', '<=', Cart::instance('cart')->subtotal()) ->first();
        if(!$coupon)
        {
            session()->flash('coupon_message', 'Coupon code is invalid!');
            return;
        }
        
        session()->put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'cart_value' => $coupon->cart_value
        ]);
    }

    public function calculateDiscounts()
    {   
        if(session()->has('coupon'))
        {
            if(session()->get('coupon')['type'] == 'fixed')
            {                
                $this->discount = session()->get('coupon')['value'];
            }
            else
            {
                $this->discount = (Cart::instance('cart')->subtotal() * session()->get('coupon')['value'])/100;
            }
            $this->subtotalAfterDiscount = Cart::instance('cart')->subtotal() - $this->discount;
            $this->taxAfterDiscount = ($this->subtotalAfterDiscount * config('cart.tax'))/100;
            $this->totalAfterDiscount = $this->subtotalAfterDiscount + $this->taxAfterDiscount;            
        }
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        session()->flash('message', 'Coupon removed!');
    }

    public function checkout()
    {
        if(Auth::check())
        {            
            return redirect()->route('checkout');
        }
        else 
        {
            return redirect()->route('login');
        }
    }

    public function setAmountForCheckout()
    {
        if(!Cart::instance('cart')->count() > 0)
        {
            session()->forget('checkout');
            return;
        }

        if(session()->has('coupon'))
        {
            session()->put('coupon', [
                'discount' => $this->discount,
                'subtotal' => $this->subtotal,
                'tax' => $this->tax,
                'total' => $this->total,                
            ]);
        }
        else
        {
            session()->put('checkout', [
                'discount' => 0,
                'subtotal' => Cart::instance('cart')->subtotal(),
                'tax' => Cart::instance('cart')->tax(),
                'total' => Cart::instance('cart')->total(),
            ]);
        }
    }

    public function render()
    {
        if(session()->has('coupon'))
        {
            if(Cart::instance('cart')->subtotal() < session()->get('coupon')['cart_value'])
            {
                session()->forget('coupon');                
            }
            else
            {
                $this->calculateDiscounts();
            }
        }
        $this->setAmountForCheckout();
        return view('livewire.cart-component')->layout('layouts.index');
    }
}