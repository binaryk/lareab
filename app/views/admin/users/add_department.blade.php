@extends('layouts.master')

@section('title')
    <p>Atribuire departamente</p>
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
	</style>
	<form action="{{ URL::to('salveaza_departamente_utilizator') }}" method="post" id="template_form" autocomplete="off">
    @if($input_form['edit']) <input type="hidden" name="edit" value="{{ $input_form['edit'] }}" /> @endif
    @if(Session::has('message'))
        <p class="alert @if($errors->isEmpty()) alert-success @else alert-danger @endif">{{ Session::get('message')  }}</p>
    @endif    
    
           
        <div class="row">            
            <div class="col-lg-6">
                <!-- nume -->
                <div class="form-group">
                    <label>Nume utilizator</label>
                    <input class="form-control" name="full_name" disabled="disabled" value="{{ $utilizator -> full_name }}" />
                </div>
                <!-- sfarsit nume -->
            </div>            
            <div class="col-lg-6">
                <!-- tip -->
                <div class="form-group @if ($errors->has('organizatie')) has-error @endif" id="organizatie">
                    <label>Alege organizatia</label>
                    <select name="organizatie" class="form-control" onchange="arata_entitate(this);" 
                        @if(count($organizatii) == 1) 
                        onClick="arata_entitate(document.getElementsByName('organizatie')[0]);"
                        @endif>
                    	@if(count($organizatii) != 1)
                        <option value="">Click pentru a alege</option>
                        @endif
                        @foreach($organizatii as $id => $denumire) 
                            <option value="{{ $id }}" @if(@$input_form['organizatie'] == $id) selected="selected" @endif>{{ $denumire }}</option>
                        @endforeach
                    </select>
                </div>
            </div> <!-- end col -->
        </div>
         
    
    
        <div class="row">   
            <div class="col-lg-6">
            	@foreach ($organizatii as $oid => $odenumire)
                <table class="table table-striped table-bordered table-hover tabel_entitati @if( $input_form['organizatie'] != $oid) mev_hide_el @endif" id="organizatie_{{ $oid }}" style="border-bottom:2px solid #3071A9; ">
                    <thead class="btn-warning">                                                       
                        <tr>                                   
                            <th class="text-center" style="width:1%;"><input type="checkbox" onchange="control_all_checkboxes_in('#organizatie_' + {{ $oid }}, this);" /></th>
                            <th class="text-left">Companii {{ $odenumire }}</th>
                        </tr>
                    </thead>
                    <tbody id="entitati">
                    	@if(isset($entitati[$oid]))
            				@foreach ($entitati[$oid] as $cid => $cdenumire)
                            <tr id="companie_{{ $cid }}">
                                <td class="text-center">
                                    <input type="checkbox" class="checkbox_row_act" name="entitati[]" value="{{ $cid }}" onclick="show_hide_departments(this);" @if(hr($cid, @$input_form['entitati']) === true) checked="checked" @endif />
                                </td>
                                <td class="mev_cursor_fix" onclick="trigger_click('#companie_' + {{ $cid }})">{{ $cdenumire }}</td>                                   
                            </tr>
               				@endforeach
                         @endif
                    </tbody>
                </table>
                @endforeach
            </div> <!-- end col -->
            
            @foreach($departamente as $cid => $departament)
                <!-- arata departamente -->
                <div class="col-lg-6">  
                    <table class="table table-striped table-bordered table-hover tabel_departamente companie_{{ $cid }} @if(hr($cid, @$input_form['entitati']) !== true)  mev_hide_el @endif" style="border-bottom:2px solid #3071A9; ">
                        <thead class="mev_active">                                                       
                            <tr>                                   
                                <th class="text-center" style="width:1%;"><input type="checkbox" onchange="control_all_checkboxes_in('.companie_' + {{ $cid }}, this);" /></th>
                                <th class="text-left">Departamente {{ $entitati_simplu[$cid] }}</th>
                            </tr>
                        </thead>
                        <tbody id="departamente_{{ $cid }}">
                            @foreach ($departament as $did => $ddenumire)
                                <tr id="departament_{{ $did }}">
                                    <td class="text-center">
                                        <input type="checkbox" class="checkbox_row_act" name="departamente[{{ $cid }}][]" value="{{ $did }}"  @if(hr($did, @$input_form['departamente'][$cid] ) === true) checked="checked" @endif />
                                    </td>
                                    <td class="mev_cursor_fix" onclick="trigger_click('#departament_' + {{ $did }})">{{ $ddenumire }}</td>                                   
                                </tr>
                            @endforeach
                        </tbody>
                    </table> 
                    <div class="row mev_spacer"></div> <!-- make some space --> 
                </div> <!-- end col -->
                <!-- sfarsit afisare departamente -->
            @endforeach            
            
            
        </div>
        <div class="row mev_spacer"></div>
    
	<div class="row mev_spacer"></div>    

    <div class="row col-lg-12 text-center">
        <input type="submit" name="btn_submit" class="btn btn-primary btn-lg button-width" value="Salveaza" />
        <a href="{{ URL::to('admin/users/list') }}">
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
		
		function arata_entitate(el) {
			var id = el.options[el.selectedIndex].value;
			uncheck_all();
			$('.tabel_entitati').removeClass('mev_hide_el').addClass('mev_hide_el');
			$('#organizatie_' + id).removeClass('mev_hide_el');
		}
		
		function show_hide_departments(el) {
			var id = el.value;
			if(el.checked == false) {
				$('.companie_' + id).find(':checkbox').prop('checked', false);
				$('.companie_' + id).removeClass('mev_hide_el').addClass('mev_hide_el');
			}
			else {
				$('.companie_' + id).removeClass('mev_hide_el');
			}
		}
		
		function uncheck_all() {
			$('.tabel_entitati').find(':checkbox').prop('checked', false);
			$('.tabel_departamente').find(':checkbox').prop('checked', false);
			$('.tabel_departamente').removeClass('mev_hide_el').addClass('mev_hide_el');
		}
		
		function show (selector) {
			$(selector).removeClass('mev_hide_el');
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
			
			$(container + ' tbody').find(':checkbox').each(function(){
					$(this).prop('checked', status);
					$(this).trigger('click');
			});
		} //end f
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