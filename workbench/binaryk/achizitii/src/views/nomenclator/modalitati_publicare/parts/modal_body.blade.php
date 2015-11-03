<div class="row">
	<div class="col-xs-12">
		<div style="overflow:auto">
			<table class="table table-bordered table-condensed">
				<tbody>
					<tr>
						<th class="text-center" style="width: 5%; font-size:90%">#</th>
						<th class="text-center" style="width: 35%; font-size:90%">Denumire</th>
						<th class="text-center" style="width: 20%; font-size:90%">Anunt intenție publicat anterior</th>
						<th class="text-center" style="width: 20%; font-size:90%">Tip complexitate</th>
						<th class="text-center" style="width: 20%; font-size:90%">Zile D-P</th>
					</tr>
                    
                    @foreach($records as $i => $record)
                    	<tr>
                    		<td class="text-center">{{ ($i+1) }}.</td>
                    		<td class="text-left">{{ $record->nume }}.</td>
                    		<td class="text-center">{{ \Binaryk\Models\Nomenclator\ModalitatiPublicare::toTextAnterior($record->anunt_anterior) }}</td>
                    		<td class="text-center">{{ \Binaryk\Models\Nomenclator\ModalitatiPublicare::toTextTipComplexitate($record->tip_complexitate) }}</td>
                    		<td class="text-center">{{ \Binaryk\Models\Nomenclator\ModalitatiPublicare::toTextZileDP($record->zile_dp) }}</td>
                    	</tr>
                    @endforeach

                </tbody>
            </table>
        </div>
	</div>
</div>