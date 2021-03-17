<div>
    <div class="container" style="padding: 30px 0;">
    	<div class="row">
    		<div class="col-md-12">
    			<div class="panel panel-default">
    				<div class="panel-heading">
    				    <div class="row">
    				    	<div class="col-md-6">
    				    		<b>All Slides</b>
    				    	</div>
    				    	<div class="col-md-6">
    				    		<a href="{{route('admin.addhomeslider')}}" class="btn btn-success pull-right">Add New Slide</a>
    				    	</div>
    				    </div>
    				</div>
    				<div class="panel-body">
    					<table class="table table-striped table-bordered">
    						<thead>
    							<tr>
    								<th>Id</th>
    								<th>Image</th>
    								<th>Title</th>
    								<th>Subtitle</th>
    								<th>Price</th>
    								<th>Link</th>
    								<th>Status</th>
    								<th>Date</th>
    								<th>Action</th>
    							</tr>
    						</thead>
    						<tbody>
    							@foreach ($sliders as $slider)
                                    <tr>
                                    	<td>{{$slider->id}}</td>
                                    	<td><img src="{{asset('assets/images/sliders')}}/{{$slider->image}}" width="120" alt=""></td>
                                    	<td>{{$slider->title}}</td>
                                    	<td>{{$slider->subtitle}}</td>
                                    	<td>{{$slider->price}}</td>
                                    	<td>{{$slider->link}}</td>
                                    	<td>{{$slider->status == 1 ? 'Active':'Inactive'}}</td>
                                    	<td>{{$slider->created_at}}</td>
                                    	<td></td>
                                    </tr>
    							@endforeach
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
