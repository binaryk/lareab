<div class="table form-group{{$feedback ? ' has-' . $feedback : ''}}">
	<label class="control-label" for="{{$name}}">
		@if($feedback == Easy\Form\Base::FEEDBACK_SUCCESS)
			<i class="fa fa-check"></i>
		@elseif($feedback == Easy\Form\Base::FEEDBACK_WARNING)
			<i class="fa fa-bell-o"></i>
		@elseif($feedback == Easy\Form\Base::FEEDBACK_ERROR)
			<i class="fa fa-times-circle-o"></i>
		@endif
		{{ $caption }}
	</label>

	<table class="table table-bordered" id = {{$name}}>
		<thead>
				
				@if(isset($records['header']))
						
					@foreach($records['header'] as $r => $record)
						
							<th>{{$record['caption']}}</th>
					
					@endforeach
				
				@endif

		</thead>
		<tbody>
				@if(isset($records['body']))
						
					@foreach($records['body'] as $r => $record)
						
							<tr>
								<td>{{$record['caption']->control}}</td>
							</tr>
					
					@endforeach
				
				@endif
		</tbody>
	</table>


	@if($help)
		<p class="help-block">{{$help}}</p>
	@endif
</div>

