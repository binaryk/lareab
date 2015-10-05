@extends('layouts.master')

@section('title') 	
	<p>Modifica grup de utilizatori</p>    
@stop

{{-- Content --}}
@section('content')
<div class="row">
	<div class="col-lg-12">

		{{-- Edit Role Form --}}
		<form class="form" method="post" action="" autocomplete="off">
			<!-- CSRF Token -->
			<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
			<!-- ./ csrf token -->

			<div class="form-group panel panel-primary {{{ $errors->has('name') ? 'error' : '' }}}">						
				<div class="col-md-12 top24">
					{{ Form::textField('Nume grup', 'name', Input::old('name', $role->name)) }}                    
				</div>			
				<span class="hidden">
				    	{{ $num_cols = 5;
				    	$current_col = 1; 
				    	$current_row = 1;
				    	$num_permissions = count($permissions); 
				    	$num_rows = ceil($num_permissions / $num_cols); 
				    	$cnt = 0;}}
				</span>					
			</div>
            <div class="col-md-12 top24">
               <table class="table table-striped table-bordered table-hover" id="dataTables-permise">
                   <thead>                                                       
                       <tr>  
                       @for ($j = 0; $j < $num_cols; $j++)                                 
                           <th class="text-center">Denumire permis</th>
                       @endfor
                       </tr>
                   </thead>
                 
                   <tbody>
                        @for ($i = 0; $i < $num_rows; $i++)
                            <tr>
                            @for ($j = 0; $j < $num_cols; $j++,$cnt++)
                            	@if($cnt<$num_permissions)
                                	<td>
                                		<label>
											<input type="hidden" id="permissions[{{{ $permissions[$cnt]['id'] }}}]" name="permissions[{{{ $permissions[$cnt]['id'] }}}]" value="0" />
											<input type="checkbox" id="permissions[{{{ $permissions[$cnt]['id'] }}}]" name="permissions[{{{ $permissions[$cnt]['id'] }}}]" value="1"{{{ (isset($permissions[$cnt]['checked']) && $permissions[$cnt]['checked'] == true ? ' checked="checked"' : '')}}} />
												{{{ $permissions[$cnt]['display_name'] }}}
										</label>
									</td>
								@else
								<td></td>
                                @endif                       
                            @endfor           
                            </tr>
                        @endfor
                   </tbody>
               </table>			   								
			</div>	

			<!-- Form Actions -->
	        <div class="col-md-12 center"> 
	            <input type="submit" name="submit" class="btn btn-primary btn-lg button-width" value="Salveaza" />
	            <a href="{{ URL::to('admin/roles/list') }}">
	                <input type="button" id="back" class="btn btn-warning btn-lg button-width" value="Inapoi" />
	            </a>                         
	        </div>
			<!-- ./ form actions -->
		</form>
	</div>
</div>	
@stop

@section('footer_scripts')
    <!-- DataTables JavaScript -->    
    {{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.js') }}
    {{ HTML::script('assets/js/plugins/dataTables/dataTables.bootstrap.js') }}
    {{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.columnFilter.js') }}
    {{ HTML::script('assets/js/plugins/bootbox.js') }}
    
    <script>
        $(document).ready(function() 
        {         
            $('#dataTables-permise').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 2 ] }
                ],                                
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'},
                "order": [[0,"asc"]],
				"columns": [
				    { "width": "20%" },
					{ "width": "20%" },
					{ "width": "20%" },
					{ "width": "20%" },
					{ "width": "20%" }
					]
            	});            			       
        });
    </script>
@stop

