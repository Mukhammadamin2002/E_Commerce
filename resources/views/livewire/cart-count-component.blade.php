<div class="wrap-icon-section minicart">
	<a href="{{ route('product.cart') }}" class="link-direction">
		<i class="fa fa-shopping-basket" style="color: #033047" aria-hidden="true"></i>
		<div class="left-info">
			@if(Cart::instance('cart')->count() > 0)
			<span class="index">{{Cart::instance('cart')->count()}} 
				{{ Str::plural('item',Cart::instance('cart')->count()) }}</span>
			@endif
			<span class="title">CART</span>
		</div>
	</a>
</div>