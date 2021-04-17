<?php

namespace App\Http\Livewire;

use App\Models\Coupon;
use Cart;
use Livewire\Component;

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
		$this->emitTo('cart-count-component', 'refreshComponent');
	}

	public function decreaseQuantity($rowId)
	{
		$product = Cart::instance('cart')->get($rowId);
		$qty = $product->qty - 1;
		Cart::instance('cart')->update($rowId, $qty);
		$this->emitTo('cart-count-component', 'refreshComponent');
	}

	public function delete($rowId)
	{
		Cart::instance('cart')->remove($rowId);
		$this->emitTo('cart-count-component', 'refreshComponent');
		session()->flash('success_message', 'Item has been removed');
	}

	public function destroyAll()
	{
		Cart::instance('cart')->destroy();
		$this->emitTo('cart-count-component', 'refreshComponent');
	}

	public function switchToSaveForLater($rowId)
	{
		$item = Cart::instance('cart')->get($rowId);
		Cart::instance('cart')->remove($rowId);
		Cart::instance('saveForLater')->add($item->id, $item->name, 1, $item->price)->associate('App\Models\Product');
		$this->emitTo('cart-count-component', 'refreshComponent');
		session()->flash('success_message', 'Item has been saved for Later!');
	}

	public function moveToCart($rowId)
	{
		$item = Cart::instance('saveForLater')->get($rowId);
		Cart::instance('saveForLater')->remove($rowId);
		Cart::instance('cart')->add($item->id, $item->name, 1, $item->price)->associate('App\Models\Product');
		$this->emitTo('cart-count-component', 'refreshComponent');
		session()->flash('s_success_message', 'Item has been moved to Cart!');
	}

	public function deleteFromSaveForLater($rowId)
	{
		Cart::instance('saveForLater')->remove($rowId);
		session()->flash('s_success_message', 'Item has been removed from save for later');
	}

	public function applyCouponCode()
	{
		$coupon = Coupon::where('code', $this->couponCode)->where('cart_value', '<=', Cart::instance('cart')->subtotal())->first();
		if (!$coupon) {
			session()->flash('coupon_message', 'Coupon Code is Invalid!');
			return;
		}

		session()->put('coupon', [
			'code' => $coupon->code,
			'type' => $coupon->type,
			'value' => $coupon->value,
			'cart_value' => $coupon->cart_value
		]);
	}

	public function calculateDiscount()
	{
		if (session()->has('coupon')) {
			if (session()->get('coupon')['type'] == 'fixed') {
				$this->discount = session()->get('coupon')['value'];
			} else {
				$this->discount = (Cart::instance('cart')->subtotal() * session()->get('coupon')['value']) / 100;
			}
			$this->subtotalAfterDiscount = Cart::instance('cart')->subtotal() - $this->discount;
			$this->taxAfterDiscount = ($this->subtotalAfterDiscount * config('cart.tax')) / 100;
			$this->totalAfterDiscount = $this->subtotalAfterDiscount + $this->taxAfterDiscount;
		}
	}

	public function removeCoupon()
	{
		session()->forget('coupon');
	}

	public function render()
	{
		if (session()->has('coupon')) {
			if (Cart::instance('cart')->subtotal() < session()->get('coupon')['cart_value']) {
				session()->forget('coupon');
			} else {
				$this->calculateDiscount();
			}
		}
		return view('livewire.cart-component')->layout("layouts.base");
	}
}
