@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
    <p>Modifica date utilizator</p>
@parent
@stop

{{-- Content --}}
@section('content')

<div class="row">
    <div class="col-lg-12">
        <form class="form" method="post" action="{{ URL::to('user/' . $user->id . '/edit') }}"  autocomplete="off">
            <!-- CSRF Token -->
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <!-- ./ csrf token -->
            <!-- General tab -->
             <fieldset>

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


                <!-- ./ password confirm -->
            </fieldset>
            <!-- ./ general tab -->

        <div class="col-md-12 center"> 
            <input type="submit" name="btn_submit" class="btn btn-primary btn-lg button-width" value="Salveaza" />
            <a href="{{ URL::to('/dashboard') }}">
                <input type="button" id="back" class="btn btn-warning btn-lg button-width" value="Inapoi" />
            </a>                         
        </div>
        </form>
    </div>
</div>    
@stop
