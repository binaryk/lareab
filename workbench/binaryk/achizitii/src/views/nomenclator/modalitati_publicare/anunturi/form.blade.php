<div class="row">
	<div class="col-md-12">
		{{$controls[0]->out()}}
	</div>
</div>

{{
	Form::hidden('id_tip_procedura', $procedura->id, ['id' => 'id_tip_procedura', 'class' => 'data-source', 'data-control-source' => 'id_tip_procedura', 'data-control-type' => 'persistent'])
}}
