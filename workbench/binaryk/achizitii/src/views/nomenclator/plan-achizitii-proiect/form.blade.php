<div class="row">
	@include('achizitii::nomenclator.plan-achizitii-proiect.1-date-intrare')
	@include('achizitii::nomenclator.plan-achizitii-proiect.2-date-procedura')
	@include('achizitii::nomenclator.plan-achizitii-proiect.3-detalii')
</div>
{{
	Form::hidden('id_proiect', $proiect->id, ['id' => 'id_proiect', 'class' => 'data-source', 'data-control-source' => 'id_proiect', 'data-control-type' => 'persistent'])
}}
{{
	Form::hidden('id_template', 0, ['id' => 'id_template', 'class' => 'data-source', 'data-control-source' => 'id_template', 'data-control-type' => 'persistent'])
}}
{{
	Form::hidden('id_tip_procedura', 0, ['id' => 'id_tip_procedura', 'class' => 'data-source', 'data-control-source' => 'id_tip_procedura', 'data-control-type' => 'persistent'])
}}
{{
	Form::hidden('id_tip_anunt', 0, ['id' => 'id_tip_anunt', 'class' => 'data-source', 'data-control-source' => 'id_tip_anunt', 'data-control-type' => 'persistent'])
}}

{{
	Form::hidden('is_anunt_anterior', 0, ['id' => 'is_anunt_anterior', 'class' => 'data-source', 'data-control-source' => 'is_anunt_anterior', 'data-control-type' => 'persistent'])
}}
{{
	Form::hidden('complexitate', 0, ['id' => 'complexitate', 'class' => 'data-source', 'data-control-source' => 'complexitate', 'data-control-type' => 'persistent'])
}}
{{
	Form::hidden('zile_depunere_publicare', 0, ['id' => 'zile_depunere_publicare', 'class' => 'data-source', 'data-control-source' => 'zile_depunere_publicare', 'data-control-type' => 'persistent'])
}}