@extends('layouts.master')

@section('title')
    <p>Modifica date asociatie proprietari 
        @if(isset($asociatie_proprietari->denumire)) {{ $asociatie_proprietari->denumire }} @endif
    </p>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form role="form" action="{{ URL::current() }}" method="post">
                <fieldset>
                    @if(Session::has('message'))
                        <p class="alert @if($errors->isEmpty()) alert-success @else alert-danger @endif">{{ Session::get('message')  }}</p>
                    @endif    
                                                   
                    <div class="form-group col-lg-10                    
                        @if ($errors->has('denumire')) has-error 
                        @elseif(Input::old('denumire')) has-success 
                        @endif">
                        <label>Denumire</label>
                        <input class="form-control" name="denumire" type="text"
                        @if(Input::old('denumire')) 
                            value="{{ Input::old('denumire') }}" 
                        @else 
                            value="{{ $asociatie_proprietari->denumire }}" 
                        @endif
                        @if ($errors->has('denumire')) 
                            title="{{ $errors->first('denumire') }}" 
                        @endif>
                    </div>                                                                   
                    <div class="form-group col-lg-2                   
                        @if ($errors->has('cif')) has-error 
                        @elseif(Input::old('cif')) has-success 
                        @endif">
                        <label>CIF</label>
                        <input class="form-control text-uppercase" name="cif" type="text"
                        @if(Input::old('cif')) 
                            value="{{ Input::old('cif') }}" 
                        @else 
                            value="{{ $asociatie_proprietari->cif }}" 
                        @endif                        
                        @if ($errors->has('cif')) 
                            title="{{ $errors->first('cif') }}" 
                        @endif>
                    </div>

                    <div class="form-group col-lg-8                   
                        @if ($errors->has('strada')) has-error 
                        @elseif(Input::old('strada')) has-success 
                        @endif">
                        <label>Strada</label>
                        <input class="form-control" name="strada" type="text" id="strada"
                        @if(Input::old('strada')) 
                            value="{{ Input::old('strada') }}" 
                        @else 
                            value="{{ $asociatie_proprietari->strada }}" 
                        @endif 
                        @if ($errors->has('strada')) 
                            title="{{ $errors->first('strada') }}" 
                        @endif>
                    </div>                                                                 
                    <div class="form-group col-lg-1                  
                        @if ($errors->has('numar')) has-error 
                        @elseif(Input::old('numar')) has-success 
                        @endif">
                        <label>Numar</label>
                        <input class="form-control" name="numar" type="text" id="numar"
                        @if(Input::old('numar')) 
                            value="{{ Input::old('numar') }}" 
                        @else 
                            value="{{ $asociatie_proprietari->numar }}" 
                        @endif 
                        @if ($errors->has('numar')) 
                            title="{{ $errors->first('numar') }}" 
                        @endif>
                    </div>
                    <div class="form-group col-lg-1                  
                        @if ($errors->has('bloc')) has-error 
                        @elseif(Input::old('bloc')) has-success 
                        @endif">
                        <label>Bloc</label>
                        <input class="form-control" name="bloc" type="text" id="bloc"
                        @if(Input::old('bloc')) 
                            value="{{ Input::old('bloc') }}" 
                        @else 
                            value="{{ $asociatie_proprietari->bloc }}" 
                        @endif 
                        @if ($errors->has('bloc')) 
                            title="{{ $errors->first('bloc') }}" 
                        @endif>
                    </div>                    
                    <div class="form-group col-lg-1                 
                        @if ($errors->has('scara')) has-error 
                        @elseif(Input::old('scara')) has-success 
                        @endif">
                        <label>Scara</label>
                        <input class="form-control" name="scara" type="text" id="scara"
                        @if(Input::old('scara')) 
                            value="{{ Input::old('scara') }}" 
                        @else 
                            value="{{ $asociatie_proprietari->scara }}" 
                        @endif 
                        @if ($errors->has('scara')) 
                            title="{{ $errors->first('scara') }}" 
                        @endif>
                    </div> 
                    <div class="form-group col-lg-1                 
                        @if ($errors->has('apartament')) has-error 
                        @elseif(Input::old('apartament')) has-success 
                        @endif">
                        <label>Apartament</label>
                        <input class="form-control" name="apartament" type="text" id="apartament"
                        @if(Input::old('apartament')) 
                            value="{{ Input::old('apartament') }}" 
                        @else 
                            value="{{ $asociatie_proprietari->apartament }}" 
                        @endif 
                        @if ($errors->has('apartament')) 
                            title="{{ $errors->first('apartament') }}" 
                        @endif>
                    </div>
                    <div class="form-group col-lg-4                   
                        @if ($errors->has('telefon1')) has-error 
                        @elseif(Input::old('telefon1')) has-success 
                        @endif">
                        <label>Telefon 1</label>
                        <input class="form-control" name="telefon1" type="text" id="telefon1"
                        @if(Input::old('telefon1')) 
                            value="{{ Input::old('telefon1') }}" 
                        @else 
                            value="{{ $asociatie_proprietari->telefon1 }}" 
                        @endif 
                        @if ($errors->has('telefon1')) 
                            title="{{ $errors->first('telefon1') }}" 
                        @endif>
                    </div>   
                    <div class="form-group col-lg-4                   
                        @if ($errors->has('fax1')) has-error 
                        @elseif(Input::old('fax1')) has-success 
                        @endif">
                        <label>Fax 1</label>
                        <input class="form-control" name="fax1" type="text" id="fax1"
                        @if(Input::old('fax1')) 
                            value="{{ Input::old('fax1') }}" 
                        @else 
                            value="{{ $asociatie_proprietari->fax1 }}" 
                        @endif 
                        @if ($errors->has('fax1')) 
                            title="{{ $errors->first('fax1') }}" 
                        @endif>
                    </div>                 
                    <div class="form-group col-lg-4                   
                        @if ($errors->has('email1')) has-error 
                        @elseif(Input::old('email1')) has-success 
                        @endif">
                        <label>Email 1</label>
                        <input class="form-control" name="email1" type="text" id="email1"
                        @if(Input::old('email1')) 
                            value="{{ Input::old('email1') }}" 
                        @else 
                            value="{{ $asociatie_proprietari->email1 }}" 
                        @endif 
                        @if ($errors->has('email1')) 
                            title="{{ $errors->first('email1') }}" 
                        @endif>
                    </div>
                    <div class="form-group col-lg-4                   
                        @if ($errors->has('telefon2')) has-error 
                        @elseif(Input::old('telefon2')) has-success 
                        @endif">
                        <label>Telefon 2</label>
                        <input class="form-control" name="telefon2" type="text" id="telefon2"
                        @if(Input::old('telefon2')) 
                            value="{{ Input::old('telefon2') }}" 
                        @else 
                            value="{{ $asociatie_proprietari->telefon2 }}" 
                        @endif 
                        @if ($errors->has('telefon2')) 
                            title="{{ $errors->first('telefon2') }}" 
                        @endif>
                    </div>   
                    <div class="form-group col-lg-4                   
                        @if ($errors->has('fax2')) has-error 
                        @elseif(Input::old('fax2')) has-success 
                        @endif">
                        <label>Fax 2</label>
                        <input class="form-control" name="fax2" type="text" id="fax2"
                        @if(Input::old('fax2')) 
                            value="{{ Input::old('fax2') }}" 
                        @else 
                            value="{{ $asociatie_proprietari->fax2 }}" 
                        @endif 
                        @if ($errors->has('fax2')) 
                            title="{{ $errors->first('fax2') }}" 
                        @endif>
                    </div>                 
                    <div class="form-group col-lg-4                   
                        @if ($errors->has('email2')) has-error 
                        @elseif(Input::old('email2')) has-success 
                        @endif">
                        <label>Email 2</label>
                        <input class="form-control" name="email2" type="text" id="email2"
                        @if(Input::old('email2')) 
                            value="{{ Input::old('email2') }}" 
                        @else 
                            value="{{ $asociatie_proprietari->email2 }}" 
                        @endif 
                        @if ($errors->has('email2')) 
                            title="{{ $errors->first('email2') }}" 
                        @endif>
                    </div>
                    <div class="form-group col-lg-4
                        @if($errors->has('tara')) has-error 
                        @elseif(Input::old('tara')) has-success 
                        @endif ">
                        <label>Tara</label>
                        <select 
                            id="tara" 
                            class="selectpicker form-control" 
                            name="tara" 
                            data-live-search="true">
                            <option   
                            @if(Input::old('tara')) 
                                value="{{ Input::old('tara') }}"                                   
                            @else 
                                value="{{ $asociatie_proprietari->id_tara }}" 
                            @endif>{{ $asociatie_proprietari->tara }}
                            </option>                            
                        </select>
                    </div>
                    <div class="form-group col-lg-4
                        @if($errors->has('regiune')) has-error 
                        @elseif(Input::old('regiune')) has-success 
                        @endif ">
                        <label>Regiune</label>
                        <select 
                            name="regiune" 
                            id="regiune" 
                            class="selectpicker form-control" 
                            data-live-search="true">                                         
                            <option   
                            @if(Input::old('regiune')) 
                                value="{{ Input::old('regiune') }}"                                   
                            @else 
                                value="{{ $asociatie_proprietari->id_regiune }}" 
                            @endif>{{ $asociatie_proprietari->regiune }}
                            </option>                                    
                        </select>        
                    </div>

                    <div class="form-group judet col-lg-4
                        @if($errors->has('judet')) has-error 
                        @elseif(Input::old('judet')) has-success 
                        @endif ">
                        <label for = "">Judet</label>
                        <select 
                            name="judet" 
                            id="judet" 
                            class="selectpicker form-control" 
                            data-live-search="true">
                            <option   
                            @if(Input::old('judet')) 
                                value="{{ Input::old('judet') }}"                                   
                            @else 
                                value="{{ $asociatie_proprietari->id_judet }}" 
                            @endif>{{ $asociatie_proprietari->judet }}
                            </option>                                    
                        </select>
                    </div>

                    <div class="form-group col-lg-10
                        @if($errors->has('localitate')) has-error 
                        @elseif(Input::old('localitate')) has-success 
                        @endif ">
                        <label for = "">Localitate</label>
                        <select 
                            name="localitate" 
                            id="localitate" 
                            class="selectpicker form-control" 
                            data-live-search="true"> 
                            <option   
                            @if(Input::old('localitate')) 
                                value="{{ Input::old('localitate') }}"                                   
                            @else 
                                value="{{ $asociatie_proprietari->id_localitate }}" 
                            @endif>{{ $asociatie_proprietari->localitate }}
                            </option>                                              
                        </select>
                    </div>          
                    <div class="form-group col-lg-2                  
                        @if ($errors->has('cod_postal')) has-error 
                        @elseif(Input::old('cod_postal')) has-success 
                        @endif">
                        <label>Cod postal</label>
                        <input class="form-control" name="cod_postal" type="text" id="cod_postal"
                        @if(Input::old('cod_postal')) 
                            value="{{ Input::old('cod_postal') }}" 
                        @else 
                            value="{{ $asociatie_proprietari->cod_postal }}" 
                        @endif 
                        @if ($errors->has('cod_postal')) 
                            title="{{ $errors->first('cod_postal') }}" 
                        @endif>
                    </div>  
                    <div class="form-group col-lg-12 text-center">
                        <input type="submit" name="btn_submit" class="btn btn-primary btn-lg" value="Salveaza" />
                    </div>
                    {{ Form::token() }}
                </fieldset>
            </form>
        </div>
    </div>
@stop

@section('footer_scripts')
    {{ HTML::script('assets/js/segmentare.js') }}
    <script>              
        $(document).ready(function(){       
            var tari = getTari();
            //console.log(tari);
            tari = JSON.parse(tari);
            //console.log(tari);
            var valoare_anterioara = $('#tara').val();
            $("#tara").empty().append('<option value="0">Selecteaza o tara</option>');                
            for (var key in tari) {
                if (tari.hasOwnProperty(key)) {
                    if (tari[key].id_tara.toString() === valoare_anterioara)
                    {
                        $("#tara").append('<option selected value="' + 
                            tari[key].id_tara+'">' + 
                            tari[key].denumire + '</option>');  
                    }   
                    else
                    {                                
                        $("#tara").append('<option value="' + 
                            tari[key].id_tara+'">' + 
                            tari[key].denumire + '</option>');  
                    }                    
                }            
            }
        })
          
        $('#tara').change(function(){
            //var regiuni = getRegiuni($(this).val());
            var functie = 'getRegiuni_tara_' + $(this).val().toString();
            console.log(functie);
            var fn = window[functie];
            var regiuni = null;
            if (typeof fn === "function") 
                regiuni = fn();            
            
            //console.log(regiuni);            
            regiuni = JSON.parse(regiuni);
            //console.log(regiuni);
            $("#regiune").empty().append('<option value="0">Selecteaza o regiune</option>');                
            for (var key in regiuni) {
                if (regiuni.hasOwnProperty(key)) {                
                    $("#regiune").append('<option value="' + 
                        regiuni[key].id_regiune+'">' + 
                        regiuni[key].denumire + '</option>');                
                }            
            }
        });   

        $('#regiune').change(function(){
            var functie = 'getJudete_regiune_' + $(this).val().toString();
            console.log(functie);
            var fn = window[functie];
            var judete = null;
            if (typeof fn === "function") 
                judete = fn();            
   
            judete = JSON.parse(judete);
            $("#judet").empty().append('<option value="0">Selecteaza un judet</option>');                
            for (var key in judete) {
                if (judete.hasOwnProperty(key)) {                
                    $("#judet").append('<option value="' + 
                        judete[key].id_judet+'">' + 
                        judete[key].denumire + '</option>');                
                }            
            }
        });   

        $('#judet').change(function(){
            var functie = 'getLocalitati_judet_' + $(this).val().toString();
            console.log(functie);
            var fn = window[functie];
            var localitati = null;
            if (typeof fn === "function") 
                localitati = fn();            

            localitati = JSON.parse(localitati);
            $("#localitate").empty().append('<option value="0">Selecteaza o localitate</option>');                
            for (var key in localitati) {
                if (localitati.hasOwnProperty(key)) {                
                    $("#localitate").append('<option value="' + 
                        localitati[key].id_localitate+'">' + 
                        localitati[key].denumire + '</option>');                
                }            
            }
        });

        $('#localitate').change(function(){
            var functie = 'getcod_postal_localitate_' + $(this).val().toString();
            console.log(functie);
            var fn = window[functie];
            var cod_postal = null;
            if (typeof fn === "function") 
                cod_postal = fn();                        
            $("#cod_postal").val(cod_postal);
        });

    </script>
@stop