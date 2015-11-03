<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-info" id="select-templete-info-filter">
			Criterii de filtrare: Tip Achizitor : <span class="badge">{{ $tip_achizitor}}</span>, Tip Contract : <span class="badge">{{ $tip_contract}}</span>,  Plafon : <span class="badge">{{ _toFloat($plafon) }} EUR</span> 
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div style="max-height:240px; scroll:auto">
			<table class="table" id="template-list-for-select">
				<tbody>
					@foreach($records as $i => $record)
						<tr>
							<td><input class="selected-record" type="radio" name="selected-record" data-id="{{ $record->id }}"/></td>
							<td>{{ $record->tip_achizitor_}}</td>
							<td>{{ $record->tip_contract_}}</td>
							<td>{{ $record->tipprocedura ? $record->tipprocedura->nume : '' }}</td>
							<td>{{ $record->tipanunt ? $record->tipanunt->nume : '' }}</td>
							@if(0)
							<td>{{ $record->cod_procedura }}</td>
							@endif
							<td>{{ $record->descriere_procedura }}</td>
							<td>{{ $record->data_semnare_cf }}</td>
							<td>{{ _toFloat($record->plafon_maxim) }} EUR</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>