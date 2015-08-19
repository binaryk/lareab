@extends('layouts.master')

@section('title') 	
	<p>Adauga grup de utilizatori cu permisele aferente</p>    
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

		{{-- Create Role Form --}}
		<form class="form" method="post" action="" autocomplete="off">
			<!-- CSRF Token -->
			<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
			<!-- ./ csrf token -->

			<!-- Tabs Content -->
			<div class="tab-content">
				<!-- Tab General -->
				<div class="tab-pane active" id="tab-general">		
					<div class="col-md-12 top24">
        				{{ Form::textField('Nume grup', 'name', Input::old('name')) }}                    
        			</div>
					<div class="col-md-12 top24">
        				{{ Form::textareaField('Descriere', 'descriere', Input::old('descriere')) }}                    
        			</div>	        			
				</div>
				<!-- ./ tab general -->

		        <!-- Permissions tab -->
		        <div class="tab-pane" id="tab-permissions">
	                <div class="form-group">
	                    @foreach ($permissions as $permission)
	                    <label>
	                        <input class="control-label" type="hidden" id="permissions[{{{ $permission['id'] }}}]" name="permissions[{{{ $permission['id'] }}}]" value="0" />
	                        <input class="form-control" type="checkbox" id="permissions[{{{ $permission['id'] }}}]" name="permissions[{{{ $permission['id'] }}}]" value="1"{{{ (isset($permission['checked']) && $permission['checked'] == true ? ' checked="checked"' : '')}}} />
	                        {{{ $permission['display_name'] }}}
	                    </label>
	                    @endforeach
	                </div>
		        </div>
		        <!-- ./ permissions tab -->
			</div>
			<!-- ./ tabs content -->

	        <div class="col-md-12 center"> 
	            <input type="submit" name="btn_submit" class="btn btn-primary btn-lg button-width" value="Salveaza" />
	            <a href="{{ URL::to('admin/roles/list') }}">
	                <input type="button" id="back" class="btn btn-warning btn-lg button-width" value="Inapoi" />
	            </a>                         
	        </div>
		</form>
	</div>
</div>
@stop
