@extends('layouts.master')

@section('title')
    <p>Modifica date locatar</p>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form role="form" action="{{ URL::current() }}" method="post">
                <fieldset>
                    @if(Session::has('message'))
                        <p class="alert @if($errors->isEmpty()) alert-success @else alert-danger @endif">{{ Session::get('message')  }}</p>
                    @endif 
					
					<div class="col-md-4">
						{{ Form::textField('Nume proprietar', 'nume', $locatar->nume) }}
					</div>

					<div class="col-md-4">  
						{{ Form::textField('Numar apartament', 'nr_apartament', $locatar->nr_apartament) }}
					</div>

					<div class="col-md-4">
						{{ Form::textField('Etaj', 'etaj', $locatar->etaj) }}
					</div>	
					
					<div class="col-md-2">  
						{{ Form::textNumericField('Suprafata utila (&#13217;)', 'suprafata_utila', $locatar->suprafata_utila) }}
					</div>

					<div class="col-md-2">  
						{{ Form::textNumericField('Cota parte (&#37;)', 'cota_parte', $locatar->cota_parte) }}
					</div>

					<div class="col-md-4">  
						{{ Form::textField('Numar membri familie', 'nr_membri', $locatar->nr_membri_familie) }}
					</div>

					<div class="col-md-4">
						{{ Form::selectField('Destinatie locuinta', 'dest_sp', $dest_sp, $locatar->id_destinatie_spatiu) }}					
					</div>				 
	
					<div class="col-md-4">
						{{ Session::put('callback', URL::route('locatar_add', $id_imobil)) }}					
						{{ Form::selectField('Scara', 'scara', ['' => 'Selectioneaza scara'] + $scari, $locatar->id_scara, [], 'fa fa-plus-circle fa-fw', URL::route('scara_add', $id_imobil)) }}					
					</div>								 

					<div class="col-md-4">
						{{ Form::selectField('Acord locatar *', 'acord_locatar', $acord_locatar, $locatar->id_acord) }}					
					</div>	

					<div class="col-md-4">
						{{ Form::selectField('Venit lunar locatar **', 'venit_lunar_locatar', $venit_lunar_locatar, $locatar->id_venit_lunar) }}					
					</div>	
	                
	                <div class="form-group col-lg-12                   
                        @if ($errors->has('asteapta_verificare')) has-error 
                        @elseif(Input::old('asteapta_verificare')) has-success 
                        @endif">
                        <div class="checkbox checkbox-primary">
                            {{ Form::checkbox('asteapta_verificare', '1', Input::old('asteapta_verificare', $locatar->asteapta_verificare)) }}
                            <label for="asteapta_verificare" class="label_check">Asteapta verificare</label>
                        </div>
                    </div>

                    <div class="col-md-12 center"> 
                        <input type="submit" id="submit" class="btn btn-primary btn-lg button-width" value="Salveaza" onclick="this.value='Se salveaza ..';this.disabled='disabled'; this.form.submit();" disabled="disabled"/>
                        <a href="{{ URL::route('locatari_list_imobil', $id_imobil) }}">
                            <input type="button" id="back" class="btn btn-warning btn-lg button-width" value="Inapoi" />
                        </a>                         
                    </div>
                    {{ Form::token() }}
                </fieldset>
            </form>
			<div class ='alert alert-info alert-dismissable top24'>
				{{ Form::label('', '* Acordul in calitate de proprietar imputernicit legal al acestuia pentru masurile propuse. Acordul e obligatoriu pentru apartamentele cu  alta destinatie decat locuinta sau spatiile comerciale, respectiv pentru apartamentele locuite daca se intervine in interiorul acestora (litera g sectiunea II.1.2 din GS) Exceptie - daca spatiile comerciale se afla la parterul blocului, nu sunt obligatorii interventiile asupra acestora, si se vor mentiona in clar in tabel astfel de situatii.') }}
				{{ Form::label('', '** Venitul mediu lunar net pe membru de familie in anul fiscal anterior depunerii cererii de finantare.') }} 
			</div>
		</div>
	</div>
@stop

@section('footer_scripts')
    <script>
        $(document).ready(function(){
        }); 
        $('input,select').bind("change keyup input",(function(){
        	$("#submit").removeAttr("disabled");
        }));         
    </script>
@stop