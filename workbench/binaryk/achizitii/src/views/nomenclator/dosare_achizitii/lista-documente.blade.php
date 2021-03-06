<div class="row">
	<div class="col-xs-12 col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				@{{ caption(tip) }} (@{{records[tip].length}})
				<button v-on="click:showForm('add', null)" class="btn btn-primary btn-xs btn-add pull-right">
					Adaugă
				</button>
			</div>
			<div class="panel-body">
		    	<ol class="list-group">

		    		<li v-class="selected-item: (record.id == currentRecord.id)" v-repeat="record: records[tip] | orderBy 'numar_ordine'" class="list-group-item">
		    			<div class="row document-record">
		    				<div class="col-xs-12 col-md-1">
		    					@{{record.numar_ordine}}
		    				</div>
		    				<div class="col-xs-12 col-md-9">
		    					@{{record.document_necesar}}
		    				</div>
		    				<div class="col-xs-12 col-md-2 text-right">
		    					<span v-on="click:changeCurrentRecord(record, 'edit')" class="glyphicon glyphicon-pencil edit-record" aria-hidden="true"></span>
		    					<span v-on="click:changeCurrentRecord(record, 'del')" class="glyphicon glyphicon-trash delete-record" aria-hidden="true"></span>
		    				</div>
		    			</div>
		    			
		    		</li>
		    	</ol>
		    </div>
		</div>
	</div>
	<div class="col-xs-12 col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">@{{ actionTitle() }}</div>
			<div class="panel-body">

		    	<table class="table">

		    		<tr>
		    			<td>Număr ordine: </td>
		    			<td>
		    				<div v-class="has-error:(fieldsErrors.numar_ordine.length && (currentRecord.numar_ordine.length == 0)), has-feedback:(fieldsErrors.numar_ordine.length && (currentRecord.numar_ordine.length == 0))" class="form-group">
    							<input v-attr="disabled:(currentAction == 'del')" v-model="currentRecord.numar_ordine" type="text" class="form-control" id="numar_ordine" placeholder="Numar ordine">
    							<span v-if="(fieldsErrors.numar_ordine.length && (currentRecord.numar_ordine.length == 0))" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
    							<p v-if="(fieldsErrors.numar_ordine.length && (currentRecord.numar_ordine.length == 0))" class="help-block">@{{fieldsErrors.numar_ordine[0]}}</p>
  							</div>
		    			</td>
		    		</tr>

		    		<tr>
		    			<td>Document necesar: </td>
		    			<td>
		    				<div v-class="has-error:(fieldsErrors.document_necesar.length && (currentRecord.document_necesar.length == 0)), has-feedback:(fieldsErrors.document_necesar.length && (currentRecord.document_necesar.length == 0))" class="form-group">
    							<input v-attr="disabled:(currentAction == 'del')" v-model="currentRecord.document_necesar" type="text" class="form-control" id="document_necesar" placeholder="Document necesar">
    							<span v-if="(fieldsErrors.document_necesar.length && (currentRecord.document_necesar.length == 0))" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
    							<p v-if="(fieldsErrors.document_necesar.length && (currentRecord.document_necesar.length == 0))" class="help-block">@{{fieldsErrors.document_necesar[0]}}</p>
  							</div>
		    			</td>
		    		</tr>

		    		<tr>
		    			<td>Clasificare documente: </td>
		    			<td>
		    				<div v-class="has-error:(fieldsErrors.id_clasificare_documente.length && (currentRecord.id_clasificare_documente == '0')), has-feedback:(fieldsErrors.id_clasificare_documente.length && (currentRecord.id_clasificare_documente == '0'))" class="form-group">
		    					<select v-attr="disabled:(currentAction == 'del')" v-model="currentRecord.id_clasificare_documente" options="clasificareDocumente()" id="id_clasificare_documente" class="form-control"></select>
    							<p v-if="(fieldsErrors.id_clasificare_documente.length && (currentRecord.id_clasificare_documente == '0'))" class="help-block">@{{fieldsErrors.id_clasificare_documente[0]}}</p>
		    				</div>
		    			</td>
		    		</tr>

		    		<tr>
		    			<td>Mod solicitare: </td>
		    			<td>
		    				<div v-class="has-error:(fieldsErrors.mod_solicitare.length && (currentRecord.mod_solicitare == '0')), has-feedback:(fieldsErrors.mod_solicitare.length && (currentRecord.mod_solicitare == '0'))" class="form-group">
		    					<select v-attr="disabled:(currentAction == 'del')" v-model="currentRecord.mod_solicitare" options="modSolicitare()" id="mod_solicitare" class="form-control"></select>
		    					<p v-if="(fieldsErrors.mod_solicitare.length && (currentRecord.mod_solicitare == '0'))" class="help-block">@{{fieldsErrors.mod_solicitare[0]}}</p>
		    				</div>
		    			</td>
		    		</tr>

		    		<tr>
		    			<td>Mod predare: </td>
		    			<td>
		    				<div v-class="has-error:(fieldsErrors.mod_predare.length && (currentRecord.mod_predare == '0')), has-feedback:(fieldsErrors.mod_predare.length && (currentRecord.mod_predare == '0'))" class="form-group">
		    					<select v-attr="disabled:(currentAction == 'del')" v-model="currentRecord.mod_predare" options="modPredare()" id="mod_predare" class="form-control"></select>
		    					<p v-if="(fieldsErrors.mod_predare.length && (currentRecord.mod_predare == '0'))" class="help-block">@{{fieldsErrors.mod_predare[0]}}</p>
		    				</div>
		    			</td>
		    		</tr>

		    		<tr>
		    			<td style="vertical-align:top !important">Observaţii: </td>
		    			<td><textarea v-attr="disabled:(currentAction == 'del')" v-model="currentRecord.observatii" id="observatii" class="form-control" rows="3"></textarea></td>
		    		</tr>
		    	</table>
		    </div>
		    <div class="panel-footer text-center">
		    	<button v-if="currentAction == 'add'" v-on="click:addNewRecord()" class="btn btn-primary">Salvează</button>
		    	<button v-if="currentAction == 'edit'" v-on="click:editRecord()" class="btn btn-primary">Salvează</button>
		    	<button v-if="currentAction == 'del'" v-on="click:delRecord()" class="btn btn-danger">Şterge</button>
		    </div>
		</div>
	</div>
</div>