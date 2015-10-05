@section('content')

@yield('before-report-row')

<div class="row">
	<div class="col-xs-12">
		<div class="box box-solid box-default box-rpt" id="box-{{$rpt->id()}}">
			@if( $rpt->caption() )
				<div class="box-header">
					@if($rpt->icon())
						{{HTML::image($rpt->icon())}}
					@endif
					<h3 class="box-title">{{$rpt->caption()}}</h3>
		        </div><!-- /.box-header -->
			@endif
			<div class="box-body">

				<!-- toolbar -->
				@if( ! empty($toolbar) )
				<div class="rpt-toolbar-container">
					<div class="row">
						<div class="col-xs-12">{{$toolbar}}</div>
					</div>
				</div>
				@endif <!-- /toolbar -->
				
				<!-- Message -->
				<div id="rpt-action-message"></div>
				<!-- /Message -->

				<!-- Filter form -->
				@if($form)
				<div class="rpt-form-container" id="form-{{$rpt->id()}}">
					<div class="row">
						<div class="col-xs-12">
							<div class="box box-solid box-primary">
								<div class="box-header">
									<h3 id="action-title" class="box-title">Parametrii raportului</h3>
								</div>
								<div class="box-body">{{$form->showForm()}}</div>
								<div class="box-footer">
									
									<a id="pdf-open" data-action="pdf-open" class="btn btn-primary" target="_blank" href="{{ URL::route('open-pdf-report', ['report' => $rpt->id() ]) . '?perioada=2015-01-01,' .  Carbon\Carbon::now()->format('Y-m-d') }}" data-href="{{ URL::route('open-pdf-report', ['report' => $rpt->id() ]) }}"><i class="fa fa-bar-chart-o"></i> Generare PDF</a>
									
									<a data-action="pdf-download" class="btn btn-primary" href="{{ URL::route('download-pdf-report', ['report' => $rpt->id() ]) }}" data-href="{{ URL::route('download-pdf-report', ['report' => $rpt->id() ]) }}"><i class="fa fa-download"></i> Download</a>
									<!--
									<a data-action="pdf-print" class="btn btn-primary btn-do-report"><i class="fa fa-print"></i> Imprimantă</a>
									-->
								</div>
							</div>
						</div>
					</div>
				</div>
				@endif
				<!-- /Form -->
			</div>
		</div>
	</div>
</div>
@stop

@section('custom-styles')
	{{ $rpt->styles() }}
@stop

@section('custom-scripts')
	{{ $rpt->scripts() }}

	<script>
	$(document).ready(function(){
		$('#perioada').daterangepicker({
			'format' : 'DD.MM.YYYY',
			startDate: '01.01.2015',
			endDate: "{{ Carbon\Carbon::now()->format('d.m.Y') }}",
			locale: {
	            applyLabel       : 'Aplică',
	            cancelLabel      : 'Renunţă',
	            fromLabel        : 'De la',
	            toLabel          : 'Pâna la',
	            customRangeLabel : 'Custom',
	            daysOfWeek       : ['Lu', 'Ma', 'Mi', 'Joi', 'Vi', 'Sâ','Du'],
	            monthNames       : ['Ianuarie', 'Februarie', 'Martie', 'Aprilie', 'Mai', 'Iunie', 'Iulie', 'August', 'Septembrie', 'Octombrie', 'Noiembrie', 'Decembrie'],
	            firstDay: 1
	        }
		}, function(start, end, label){
			var url = $('#pdf-open').data('href') + '?perioada=' + start.format('YYYY-MM-DD') + ',' + end.format('YYYY-MM-DD') ;
			$('#pdf-open').attr('href', url);
		});

		@yield('datatable-specific-page-jquery-initializations')
	});

	</script>
@stop