<ul class="page-breadcrumb">
	<li>
		<i class="fa fa-home"></i>
		<a href="{{URL::to('/') }}">Home</a>  
	@if( isset($breadcrumbs) )
		<i class="fa fa-angle-right"></i>
	</li>
		@foreach($breadcrumbs as $key => $breadcrumb)
			<li>
				<a href="{{ URL::route($breadcrumb['url'], $breadcrumb['ids']) }}">{{$breadcrumb['name']}}</a>
				@if( $key < count($breadcrumbs) - 1 )
					<i class="fa fa-angle-right"></i>
				@endif
			</li>
		@endforeach
	@endif
</ul>
<style type="text/css">
	.page-breadcrumb{
		font-size: 12px;
	    float: right;
	    position: relative;
	    top: 17px;
	    right: 10px;
	}
	.page-breadcrumb li {
		list-style-type: none;
		float: left;

	}
</style>