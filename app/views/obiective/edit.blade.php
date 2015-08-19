@extends('layouts.master')

@section('title') 
    <p>Modifica obiectiv
        @if(isset($obiectiv->numar)) {{ $obiectiv->numar }} din data {{ $obiectiv->data_semnare_obiectiv }} @endif
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

                    <div class="col-md-6">
                        {{ Form::selectField('Al carui departament este obiectivul?', 'departament', $departamente, $obiectiv->id_departament) }}                    
                    </div>                     
                    
                    <div class="col-md-2">
                        {{ Form::textField('Numar inregistrare proiect', 'nr_reg_proiect', $obiectiv->nr_reg_proiect, ['title'=>'Numarul de inregistrare dat proiectului in registrul de proiecte']) }}                    
                    </div> 
                    
                    <div class="col-md-2">  
                        {{ Form::textField('Numar obiectiv','numar', $obiectiv->numar) }}
                    </div>
                    
                    <div class="col-md-2">
                        {{ Form::textField('Data semnarii', 'data_semnare', $obiectiv->data_semnare_obiectiv, ['class'=>'form-control date1'], '<i class="fa fa-calendar"></i>') }}                    
                    </div>

                    <div class="col-md-8">  
                        {{ Form::textField('Denumire','denumire_obj', $obiectiv->denumire_obj) }}
                    </div>                                             
                    
                    <div class="col-md-4">
                        {{ Form::selectField('Stadiu obiectiv', 'stadiu_obiectiv', ['' => 'Selectioneaza stadiul'] + $stadii_obiectiv, $obiectiv->id_stadiu) }}                    
                    </div>

                    <div class="col-md-12">
                        {{ Form::selectField('Tempate', 'template', 
                        ['' => 'Selectioneaza template-ul pe baza caruia se creeaza obiectivul'] + $templates, 
                        $obiectiv->id_template) }}                    
                    </div>                                                                                                    
                     
                    <div class="col-md-12">
                        {{ Form::selectField('Contractul de care apatine acest obiectiv', 'contract', 
                        ['' => 'Selectioneaza contractul de care apartine acest obiectiv'] + $contracte, 
                        $obiectiv->id_contract) }}                    
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
                                value="{{ $obiectiv->id_tara }}" 
                            @endif>{{ $obiectiv->tara }}
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
                                value="{{ $obiectiv->id_regiune }}" 
                            @endif>{{ $obiectiv->regiune }}
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
                                value="{{ $obiectiv->id_judet }}" 
                            @endif>{{ $obiectiv->judet }}
                            </option>                                    
                        </select>
                    </div>

                    <div class="form-group col-lg-12
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
                                value="{{ $obiectiv->id_localitate }}" 
                            @endif>{{ $obiectiv->localitate }}
                            </option>                                              
                        </select>
                    </div>

                    <div class="col-md-12">
                        {{ Form::textField('Adresa', 'adresa', $obiectiv->adresa) }}                    
                    </div>

                    <div class="col-md-4">
                        {{ Form::textField('Cod postal', 'cod_postal', $obiectiv->cod_postal) }}                    
                    </div> 
                    
                    @if (Entrust::can('manage_finance'))
                        <div class="col-md-4">
                            {{ Form::textNumericField('Valoare fara TVA', 'valoare_obiectiv', $obiectiv->valoare) }}                    
                        </div>

                        <div class="col-md-4">
                            {{ Form::textNumericField('Procent TVA(%)', 'procent_tva', $obiectiv->tva) }}                    
                        </div>              
                    @endif                                                                  
                    
                    <div class="col-md-12 center"> 
                        <input type="submit" name="btn_submit" class="btn btn-primary btn-lg button-width" value="Salveaza" onclick="this.value='Se salveaza ..';this.disabled='disabled'; this.form.submit();" />
                        <a href="{{ URL::route('obiectiv_list_contract', $obiectiv->id_contract) }}">
                            <input type="button" id="back" class="btn btn-warning btn-lg button-width" value="Inapoi" />
                        </a>                         
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
            console.log(tari);
            var valoare_anterioara = $('#tara').val();
            $("#tara").empty().append('<option value="0">Selecteaza o tarisoara</option>');                
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
            $("#tara").change();
        })
          
        $('#tara').change(function(){            
            var functie = 'getRegiuni_tara_' + $(this).val().toString();
            //console.log(functie);
            var fn = window[functie];
            var regiuni = null;
            if (typeof fn === "function") 
                regiuni = fn();            
            
            //console.log(regiuni);            
            regiuni = JSON.parse(regiuni);
            //console.log(regiuni);
            var id_regiune = $("#regiune").val(); 
            //alert(id_regiune);
            $("#regiune").empty().append('<option value="0">Selecteaza o regiune</option>');                
            for (var key in regiuni) {
                if (regiuni.hasOwnProperty(key)) {                
                    /*$("#regiune").append('<option value="' + 
                        regiuni[key].id_regiune+'">' + 
                        regiuni[key].denumire + '</option>'); */               
                    if (regiuni[key].id_regiune.toString() == id_regiune)
                    {                
                        $("#regiune").append('<option selected value="' + 
                            regiuni[key].id_regiune+'">' + 
                            regiuni[key].denumire + '</option>');                
                    }
                    else
                        $("#regiune").append('<option value="' + 
                            regiuni[key].id_regiune+'">' + 
                            regiuni[key].denumire + '</option>');                            
                }            
            }
            $('#regiune').change();
        });   

        $('#regiune').change(function(){
            var functie = 'getJudete_regiune_' + $(this).val().toString();
            //console.log(functie);
            var fn = window[functie];
            var judete = null;
            if (typeof fn === "function") 
                judete = fn();            
   
            judete = JSON.parse(judete);
            var id_judet = $("#judet").val();
            $("#judet").empty().append('<option value="0">Selecteaza un judet</option>');                
            for (var key in judete) {
                if (judete.hasOwnProperty(key)) {                
                    /*$("#judet").append('<option value="' + 
                        judete[key].id_judet+'">' + 
                        judete[key].denumire + '</option>');*/
                    if (judete[key].id_judet.toString() == id_judet)
                    {                
                        $("#judet").append('<option selected value="' + 
                            judete[key].id_judet+'">' + 
                            judete[key].denumire + '</option>');                
                    }
                    else
                        $("#judet").append('<option value="' + 
                            judete[key].id_judet+'">' + 
                            judete[key].denumire + '</option>');                                      
                }            
            }
            $('#judet').change();
        });   

        $('#judet').change(function(){
            var functie = 'getLocalitati_judet_' + $(this).val().toString();
            //console.log(functie);
            var fn = window[functie];
            var localitati = null;
            if (typeof fn === "function") 
                localitati = fn();            

            localitati = JSON.parse(localitati);
            var id_localitate = $("#localitate").val();
            $("#localitate").empty().append('<option value="0">Selecteaza o localitate</option>');                
            for (var key in localitati) {
                if (localitati.hasOwnProperty(key)) {                
                    /*$("#localitate").append('<option value="' + 
                        localitati[key].id_localitate + '">' + 
                        localitati[key].denumire + '</option>'); */
                    if (localitati[key].id_localitate.toString() == id_localitate)
                    {                
                        $("#localitate").append('<option selected value="' + 
                            localitati[key].id_localitate+'">' + 
                            localitati[key].denumire + '</option>');                
                    }
                    else
                        $("#localitate").append('<option value="' + 
                            localitati[key].id_localitate+'">' + 
                            localitati[key].denumire + '</option>');                                           
                }            
            }
        });

        $(function() {
            $(".date1").datepicker({ minDate: new Date(2010, 1, 1), dateFormat: "dd-mm-yy" });         
        });
    </script>
@stop