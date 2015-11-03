@extends('achizitii::~layout.master') 

@section('title')
    Dosar achizitii (<i>{{ $template_achizitii->nume }}</i>)
@stop

@section('_content')
<div class="row">
	<div class="col-xs-12">
		<div id="dosar-achizitii-container">

			<div class="row">
				<div class="col-xs-12">
					<div>
						<!-- Nav tabs -->
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active">
								<a v-on="click:changeTip('achizitor')" href="#achizitor" aria-controls="achizitor" role="tab" data-toggle="tab">Achizitor</a>
							</li>
							<li role="presentation">
								<a v-on="click:changeTip('ofertant')" href="#ofertant" aria-controls="ofertant" role="tab" data-toggle="tab">Ofertant</a>
							</li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content" style="margin-top:12px">
							<div role="tabpanel" class="tab-pane active" id="achizitor">
								@include('achizitii::nomenclator.dosare_achizitii.lista-documente', ['tip' => 'achizitor', 'lista' => $documente_achizitor])
							</div>
							<div role="tabpanel" class="tab-pane" id="ofertant">
								@include('achizitii::nomenclator.dosare_achizitii.lista-documente', ['tip' => 'ofertant', 'lista' => $documente_ofertant])
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>	
	</div>
</div>
@stop

@section('custom-styles')
	{{ HTML::style('packages/binaryk/achizitii/assets/css/custom/dosare-achizitii.css')}}
@stop

@section('custom-scripts')
	{{ HTML::script('packages/binaryk/achizitii/assets/js/template-achizitii/dosar-achizitii.js') }}
	{{ HTML::script('packages/binaryk/achizitii/packages/vue/vue.min.js') }}
	{{ HTML::script('packages/binaryk/achizitii/packages/vue/vue-resource.min.js') }}
	<script>
		var dosarAchizitii = new Dosarchizitii({
			documente_achizitor   : {{ $documente_achizitor }},
			documente_ofertant    : {{ $documente_ofertant }},
			clasificare_documente : {{ $clasificare_documente }},
			mod_solicitare        : {{ json_encode($mod_solicitare) }},
			mod_predare           : {{ json_encode($mod_predare) }},
			template_achizitii    : {{ $template_achizitii }},
			endpoints             : {
				'insert' : "{{ route('insert-document-dosar-achizitie')}}",
				'update' : "{{ route('update-document-dosar-achizitie')}}",
				'delete' : "{{ route('delete-document-dosar-achizitie')}}"
			}
		});
	</script>
@stop