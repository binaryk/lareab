@extends('layouts.master')

@section('title')
	@if($input_form['edit'])
		<p>Modifica template</p>
	@else
    	<p>Creaza template</p>
    @endif
@stop

@section('content')
	
    <style>
	.mev_hide_el {
		display:none;	
	}
	
	.mev_spacer {
		height:30px;
	}
	
	.mev_background_grey {
		background:#eee;
		color:#333;
	}
	
	.mev_active {
		background:#428bca;
		color:#fff;
	}
	
	.mev_cursor_fix {
		cursor:pointer;
	}
	.vcenter {
	    display: inline-block;
    	vertical-align: middle;
    	float: none;
	}
	</style>
	<form action="{{ URL::to('templates_add') }}" method="post" id="template_form" autocomplete="off">
    @if($input_form['edit']) <input type="hidden" name="edit" value="{{ $input_form['edit'] }}" /> @endif
    @if(Session::has('message'))
        <p class="alert @if($errors->isEmpty()) alert-success @else alert-danger @endif">{{ Session::get('message')  }}</p>
    @endif             
    <div class="row">
    	<div class="col-lg-6">
        	<!-- nume -->
        	<div class="form-group @if ($errors->has('denumire')) has-error @endif" id="denumire">
                <label>Denumire template</label>
                <input class="form-control" name="denumire" value="{{ test_and_fill_value($input_form, 'denumire') }}" />
            </div>
            <!-- sfarsit nume -->
        </div>
    	<div class="col-lg-3">
        	<!-- tip -->
            <div class="form-group @if ($errors->has('categorie_investitie')) has-error @endif" id="categorie_investitie">
                <label>Alege categoria investitiei</label>
                <select name="categorie_investitie" class="form-control">
                    <option value="">Click pentru a alege</option>
                    @foreach($categorii_investitii as $v) 
                    	<option value="{{ $v->id }}" @if(@$input_form['categorie_investitie'] == $v -> id) selected="selected" @endif>{{ $v->denumire }}</option>
                    @endforeach
                </select>
            </div>
            <!-- sfarsit tip -->
        </div>
    	<div class="col-lg-3">
        	<!-- tip -->
            <div class="form-group @if ($errors->has('tip_contract')) has-error @endif" id="tip_contract">
                <label>Alege tipul contractului</label>
                <select name="tip_contract" class="form-control">
                    <option value="">Click pentru a alege</option>
                    @foreach($tipuri_contracte as $v) 
                    	<option value="{{ $v->id }}" @if(@$input_form['tip_contract'] == $v -> id) selected="selected" @endif>{{ $v->denumire }}</option>
                    @endforeach
                </select>
            </div>
            <!-- sfarsit tip -->
        </div>
    	<div class="col-lg-12">
        	<!-- observatii -->
        	<div class="form-group">
                <label>Observatii</label>
                <input class="form-control" name="observatii" value="{{ test_and_fill_value($input_form, 'observatii') }}" />
            </div>
            <!-- observatii -->
        </div>
   	</div>
    
    <div class="row mev_spacer"></div>
    
    <div class="row">
    	<div class="col-lg-6">  
            <table class="table table-striped table-bordered table-hover" style="border-bottom:2px solid #3071A9; ">
                <thead class="mev_active">                                                       
                    <tr>                                   
                        <th class="text-center" style="width:1%;"><input type="checkbox" onchange="control_all_checkboxes_in('#activitati', this);" /></th>
                        <th class="text-left"><span class="btn btn-warning btn-circle">1</span>&nbsp <span>Denumire activitate</span></th>
                    </tr>
                </thead>
                <tbody id="activitati">
                    @foreach ($activitati as $activitate)
                        <tr id="activitate_{{ $activitate->id }}">
                            <td class="text-center">
                            	<input type="checkbox" class="checkbox_row_act" name="activitati[]" value="{{ $activitate -> id }}" onclick="control_checkboxes_in('activitati_tipizate', {{ $activitate -> id }}, this.checked);" @if(hr($activitate->id, @$input_form['activitati']) === true) checked="checked" @endif />
                            </td>
                            <td class="mev_cursor_fix" onclick="trigger_click('#activitate_' + {{ $activitate->id }})">{{ $activitate->activitate }}</td>                                   
                        </tr>
                    @endforeach
                </tbody>
            </table> 
        </div>
        <div class="col-lg-6">   
            <table class="table table-striped table-bordered table-hover" style="border-bottom:2px solid #3071A9; ">
                <thead class="mev_active">                                                       
                    <tr>                                   
                      <th class="text-center" style="width:1%;"><input type="checkbox" onchange="control_all_checkboxes_in('#activitati_tipizate', this);" /></th>
                        <th class="text-left"><span class="btn btn-warning btn-circle">2</span>&nbsp <span>Denumire activitate tipizata</span></th>
                    </tr>
                </thead>
                
                <tbody id="activitati_tipizate">
                    @foreach($activitati_tipizate as $k => $v)
                    <tr class="{{ hr($v->id_tip_activitate, @$input_form['activitati']) }} activitati_tipizate_{{ $v->id_tip_activitate}}" id="tipizate_{{ $v->id}}">
                        <td class="text-center">
                        	<input type="checkbox" name="activitati_tipizate[]" value="{{ $v->id}}"  onclick="control_checkboxes_in('tipuri_livrabile', {{ $v -> id }}, this.checked); control_checkboxes_in('tipuri_obligatii_sarcini', {{ $v -> id }}, this.checked);" {{ checked($v->id, @$input_form['activitati_tipizate']) }} />
                        </td>
                        <td class="mev_cursor_fix" onclick="trigger_click('#tipizate_' + {{ $v->id }} )">{{ $v->activitate}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>                                                                                                                                                         
        </div>
    </div>  
    
	<div class="row mev_spacer"></div>
    
    <div class="row">
        <div class="col-lg-12">   
            <table class="table table-striped table-bordered table-hover" style="border-bottom:2px solid #3071A9; ">
                <thead class="mev_background_grey">                                                       
                    <tr>                                   
                        <th class="text-center tab_li mev_active" style="width:1%;"><input type="checkbox" onchange="control_all_checkboxes_in('#tipuri_livrabile', this);" /></th>
                        <th class="text-left tab_li mev_active" style="width:49%;cursor:pointer;" onclick="activate_tab('li');"><span class="btn btn-warning btn-circle">3</span>&nbsp <span>Livrabile</span></th>
                        
                        <th class="text-center tab_os" style="width:1%;"><input type="checkbox" onchange="control_all_checkboxes_in('#tipuri_obligatii_sarcini', this);" /></th>
                        <th class="text-left tab_os" style="cursor:pointer;" onclick="activate_tab('os');"><span class="btn btn-warning btn-circle">4</span>&nbsp <span>Obligatii si sarcini</span></th>
                    </tr>
                </thead>
                <tbody id="tipuri_livrabile">
                    @foreach($tipuri_livrabile as $k => $v)
                    <tr class="{{ hr($v->id_tip_activitate_tipizata, @$input_form['activitati_tipizate']) }} tipuri_livrabile_{{ $v->id_tip_activitate_tipizata }}" id="li_{{ $v->id}}">
                        <td>
                        	<input type="checkbox" name="livrabile[]" value="{{ $v->id }}" {{ checked($v->id, @$input_form['livrabile']) }} />
                        </td>
                        <td class="mev_cursor_fix" colspan="3" onclick="trigger_click('#li_' + {{ $v->id }})">{{ $v->denumire }}</td>
                    </tr>                        
                    @endforeach
                </tbody>
                <tbody class="mev_hide_el" id="tipuri_obligatii_sarcini">
                    @foreach($tipuri_obligatii_sarcini as $k => $v)
                    <tr class="{{ hr($v->id_tip_activitate_tipizata, @$input_form['activitati_tipizate']) }} tipuri_obligatii_sarcini_{{ $v->id_tip_activitate_tipizata }}" id="os_{{ $v->id}}">
                        <td>
                        	<input type="checkbox" name="obligatii_sarcini[]" value="{{ $v->id}}" {{ checked($v->id, @$input_form['obligatii_sarcini']) }} />
                        </td>
                        <td class="mev_cursor_fix" colspan="3" onclick="trigger_click('#os_' + {{ $v->id }})">{{ $v->denumire }}</td>
                    </tr>                        
                    @endforeach
                </tbody>
            </table>                                                                                                                                                         
        </div>
    </div>  
    
	<div class="row mev_spacer"></div>    

    <div class="row col-lg-12 text-center">
        <input type="submit" name="btn_submit" class="btn btn-primary btn-lg button-width" value="Salveaza" onclick="return verificare_form();" />
        <a href="{{ URL::route('template_contract') }}">
            <input type="button" id="back" class="btn btn-warning btn-lg button-width" value="Inapoi" />
        </a>                                                
    </div>
    {{ Form::token() }} 
</form>
@stop

@section('footer_scripts')
    {{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.js') }}
    {{ HTML::script('assets/js/plugins/dataTables/dataTables.bootstrap.js') }}
    {{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.columnFilter.js') }}
    {{ HTML::script('assets/js/plugins/bootbox.js') }}

    <script>
        $(document).ready(function(){
        });
		
		/* UI core */
		function trigger_click(selector) {
			$(selector).find(':checkbox').trigger('click');	
		}
		function control_checkboxes_in(container, id, checked) { // utilizata la (de)selectarea checkbox-urilor dintr-un tabel
			$('.' + container + '_' + id).each(function(){
				if(checked == true)
				$(this).removeClass('mev_hide_el');
				else {
					if($(this).find(':checkbox').prop('checked') == true) {
						$(this).find(':checkbox').trigger('click');
						$(this).find(':checkbox').prop('checked', false);
					}
					$(this).addClass('mev_hide_el');
				}
			});
		} //end f
		
		
		function control_all_checkboxes_in(container, el) {
			var status = el.checked;
			if(status == true)
			status = false;
			else
			status = true;
			$(container).find(':checkbox').each(function(){
				if($(this).closest('tr').hasClass('mev_hide_el') == false) {
					$(this).prop('checked', status);
					$(this).trigger('click');
				}
			});
		} //end f
		
		function de_checkbox (cont) { //disable - enable checboxes
			$(cont).find(':checkbox').each(function(){
				$(this).prop('checked', status);
				$(this).trigger('click');
			});	
		} //end f
		
		function activate_tab(tab) {
			$('.tab_li').removeClass('mev_active');
			$('.tab_os').removeClass('mev_active');
			$('#tipuri_livrabile').removeClass('mev_hide_el');
			$('#tipuri_obligatii_sarcini').removeClass('mev_hide_el');
			if(tab == 'os') {
				$('#tipuri_livrabile').addClass('mev_hide_el');
				$('.tab_os').addClass('mev_active');
			}
			else {
				$('#tipuri_obligatii_sarcini').addClass('mev_hide_el');
				$('.tab_li').addClass('mev_active');
			}
		}
			
		
		function verificare_form() {
			var denumire = $('#denumire');
			var tip_contract = $('#tip_contract');
			var categorie_investitie = $('#categorie_investitie');
			var r = true;
			var errors = new Array();
			
			if(denumire.find('input').val() == '') {
				denumire.addClass('has-error');
				errors.push('Denumirea nu a fost completata.');
			}
			else {
				denumire.removeClass('has-error');	
			}
			
			if(tip_contract.find('select').val() == '') {
				tip_contract.addClass('has-error');
				errors.push('Tipul contractului nu a fost ales.');
			}
			else {
				tip_contract.removeClass('has-error');	
			}
			
			if(categorie_investitie.find('select').val() == '') {
				categorie_investitie.addClass('has-error');
				errors.push('Categoria investitiei nu a fost aleasa.');
			}
			else {
				categorie_investitie.removeClass('has-error');	
			}
			
			$('.alert.alert-danger').remove();
			
			if(errors.length > 0) {
				$('#template_form').prepend('<p class="alert alert-danger">' + errors.join('<br />') + '</p>');
				window.scrollTo(0, 0);
				r = false;
			}
			
			return r;
		}
		
		/* Sfarsit UI Core */
    </script>
    <?php
	
	function test_and_fill_value($input_form, $input) {
		if(isset($input_form[$input]))
		return $input_form[$input];
		
		else return '';
	}
	
	function hr($needle, $haystack) { //hide row
		if(!is_array($haystack))
		$haystack = array();
		
		if(!in_array($needle, $haystack))
		return 'mev_hide_el';
		
		return true;
	}
	
	function checked($needle, $haystack) {
		if(hr($needle, $haystack) === true)
		return 'checked="checked"';	
	}
	
	?>
    
@stop