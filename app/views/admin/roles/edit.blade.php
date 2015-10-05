@extends('layouts.master')

@section('title') 	
	<p>Modifica grup de utilizatori</p>    
@stop

{{-- Content --}}
@section('content')
<div class="row">
	<div class="col-lg-12">
		<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
			<li><a href="#tab-permissions" data-toggle="tab">Permise</a></li>
		</ul>
		<!-- ./ tabs -->

		{{-- Edit Role Form --}}
		<form class="form" method="post" action="" autocomplete="off">
			<!-- CSRF Token -->
			<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
			<!-- ./ csrf token -->

			<!-- Tabs Content -->
			<div class="tab-content">
				<!-- General tab -->
				<div class="tab-pane active" id="tab-general">
					<!-- Name -->
					<div class="form-group panel panel-primary {{{ $errors->has('name') ? 'error' : '' }}}">
						<div class="panel-body">
							<div class="col-md-12 top24">
		        				{{ Form::textField('Nume grup', 'name', Input::old('name', $role->name)) }}                    
		        			</div>			
							<div class="col-md-12 top24">
		        				{{ Form::textareaField('Descriere', 'descriere', Input::old('descriere', $role->descriere)) }}                    
		        			</div>			
	        			</div>		
					</div>
					<!-- ./ name -->
				</div>
				<!-- ./ general tab -->

				<div class="tab-pane" id="tab-permissions">
					<div class="row">
						<div class="row-same-height row-full-height">

						    <span class="hidden">
						    	{{ $num_rows = 3;
						    	$current_col = 1; 
						    	$current_row = 1;
						    	$num_permissions = count($permissions); 
						    	$num_cols = ceil($num_permissions / 3); }}						
							</span>

							@for ($j = 0; $j < $num_cols; $j++)
							    <div class="col-xs-6 col-xs-height col-full-height"><div class="item"><div class="content">
									@for ($i = $j * $num_rows; ($i < ($j + 1) * $num_rows); $i++)
										@if ($i < $num_permissions)
							     		<label>
											<input type="hidden" id="permissions[{{{ $permissions[$i]['id'] }}}]" name="permissions[{{{ $permissions[$i]['id'] }}}]" value="0" />
											<input type="checkbox" id="permissions[{{{ $permissions[$i]['id'] }}}]" name="permissions[{{{ $permissions[$i]['id'] }}}]" value="1"{{{ (isset($permissions[$i]['checked']) && $permissions[$i]['checked'] == true ? ' checked="checked"' : '')}}} />
												{{{ $permissions[$i]['display_name'] }}}
										</label><br>
										@endif
									@endfor
							    </div></div></div>
						    @endfor

					   </div>
					</div>			
				</div>	
				<!-- ./ permissions tab -->
			</div>
			<!-- ./ tabs content -->

			<!-- Form Actions -->
	        <div class="col-md-12 center"> 
	            <input type="submit" name="btn_submit" class="btn btn-primary btn-lg button-width" value="Salveaza" />
	            <a href="{{ URL::to('admin/roles/list') }}">
	                <input type="button" id="back" class="btn btn-warning btn-lg button-width" value="Inapoi" />
	            </a>                         
	        </div>
			<!-- ./ form actions -->
		</form>
	</div>
</div>	
@stop
