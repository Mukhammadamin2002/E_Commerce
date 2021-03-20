<div>
	<style type="text/css">
		nav svg {
			height: 20px;
		}
		nav .hidden {
			display: block !important;
		}
	</style>
    <div class="container" style="padding:30px 0; ">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="panel panel" -default="
    			.panel-heading">
    				<div class="row">
              <div class="col-md-6">
                All Products
              </div>
              <div class="col-md-6">
                <a href="{{route('admin.addproduct')}}" class="btn btn-success pull-right">Add New Products</a>
              </div>    
            </div>
    			</div>
    			<div class="panel-body">
            @if(Session::has('message'))
              <div class="alert alert-danger" role="alert">{{Session::get('message')}}</div>
            @endif
    				<table class="table table-striped table-hover">
    					<thead>
    						<tr>
    							<th>Id</th>
    							<th>Image</th>
    							<th>Product Name</th>
    							<th>Stock</th>
                  <th>Price</th>
    							<th>Sale Price</th>
    							<th>Category</th>
    							<th>Date</th>
    							<th>Action</th>
    						</tr>
    					</thead>
    					<tbody>
    						@foreach ($products as $product)
                 <tr>
                 	<td>{{$product->id}}</td>
                 	<td><img src="{{asset('assets/images/products')}}/{{$product->image}}" width="60" alt="" /></td>
                 	<td>{{$product->name}}</td>
                 	<td>{{$product->stock_status}}</td>
                  <td>{{$product->regular_price}}</td>
                 	<td>{{$product->sale_price}}</td>
                 	<td>{{$product->category->name}}</td>
                 	<td>{{$product->created_at}}</td>
                 	<td>
                    <a href="{{route('admin.editproduct',['product_slug'=>$product->slug])}}"><i class="fa fa-edit fa-2x text-info"></i></a>
                    <a href="" style="margin-left: 20px" onclick="confirm('Are you sure, You want to delete product?') || event.stopImmediatePropagation()" wire:click.prevent="deleteProduct({{$product->id}})"><i class="fa fa-trash fa-2x text-danger"></i></a>
                  </td>
                 </tr>
    						@endforeach
    					</tbody>
    				</table>
    				{{$products->links()}}
    			</div>
    		</div>
    	</div>
    </div>
</div>
