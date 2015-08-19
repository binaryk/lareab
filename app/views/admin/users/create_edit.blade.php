@extends('layouts.master')

@section('title') 
	@if ($mode == 'create')
		<p>Adauga utilizator</p>    
	@else
    	<p>Modifica date utilizator</p>
    @endif
@stop

{{-- Content --}}
@section('content')
<div class="row">
<div class="col-lg-12">
	{{-- Create User Form --}}
	<form class="form" method="post" action="@if (isset($user)){{ URL::to('admin/users/' . $user->id . '/edit') }}@endif" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

        @if(Session::has('error'))
            <p class="alert alert-danger">{{ Session::get('error')  }}</p>
        @elseif (Session::has('success'))
            <p class="alert alert-success">{{ Session::get('success')  }}</p>
        @endif

		<div class="col-md-12">
        	{{ Form::textField('Nume si prenume utilizator', 'full_name', Input::old('full_name', isset($user) ? $user->full_name : null)) }}                    
        </div>       
		<div class="col-md-6">
        	{{ Form::textField('Nume utilizator', 'username', Input::old('username', isset($user) ? $user->username : null)) }}                    
        </div>       
		<div class="col-md-6">
        	{{ Form::textField('Email', 'email', Input::old('email', isset($user) ? $user->email : null)) }}                    
        </div>
		<div class="col-md-6">
        	{{ Form::passwordField('Parola', 'password') }}                    
        </div>
		<div class="col-md-6">
        	{{ Form::passwordField('Confirmare parola', 'password_confirmation') }}                    
        </div>


		<!-- Activation Status -->
		<div class="form-group col-md-12 {{{ $errors->has('activated') || $errors->has('confirm') ? 'error' : '' }}}">
			<label class="control-label" for="confirm">Utilizator activ?</label>
			<div>
				@if ($mode == 'create')
					<select class="form-control" name="confirm" id="confirm">
						<option value="1"{{{ (Input::old('confirm', 0) === 1 ? ' selected="selected"' : '') }}}>Da</option>
						<option value="0"{{{ (Input::old('confirm', 0) === 0 ? ' selected="selected"' : '') }}}>Nu</option>
					</select>
				@else
					<select class="form-control" {{{ ($user->id === Confide::user()->id ? ' disabled="disabled"' : '') }}} name="confirm" id="confirm">
						<option value="1"{{{ ($user->confirmed ? ' selected="selected"' : '') }}}>Da</option>
						<option value="0"{{{ ( ! $user->confirmed ? ' selected="selected"' : '') }}}>Nu</option>
					</select>
				@endif
				{{ $errors->first('confirm', '<span class="help-inline">:message</span>') }}
			</div>
		</div>
		<!-- ./ activation status -->

		<!-- Groups -->
		<div class="form-group col-md-6 {{{ $errors->has('roles') ? 'error' : '' }}}">
            <label class="control-label" for="roles">Grupuri de utilizatori</label>
            <div class="">
                <select class="form-control" name="roles[]" id="roles[]" multiple>
                    @foreach ($roles as $role)
						@if ($mode == 'create')
                    		<option value="{{{ $role->id }}}"{{{ ( in_array($role->id, $selectedRoles) ? ' selected="selected"' : '') }}}>{{{ $role->name }}}</option>
                    	@else
							<option value="{{{ $role->id }}}"{{{ ( array_search($role->id, $user->currentRoleIds()) !== false && array_search($role->id, $user->currentRoleIds()) >= 0 ? ' selected="selected"' : '') }}}>{{{ $role->name }}}</option>
						@endif
                    @endforeach
				</select>

				<span class="help-block">
					Selectionati grupurile din care face parte utilizatorul curent. Accesul la resursele aplicatiei va fi restrictionat prin intermediul acestor grupuri.
				</span>
        	</div>
		</div>
		<!-- ./ groups -->
	
        <div class="col-md-12 center"> 
            <input type="submit" name="btn_submit" class="btn btn-primary btn-lg button-width" value="Salveaza" />
            <a href="{{ URL::to('admin/users/list') }}">
                <input type="button" id="back" class="btn btn-warning btn-lg button-width" value="Inapoi" />
            </a>                         
        </div>
	</form>
	</div>
</div>
@stop
