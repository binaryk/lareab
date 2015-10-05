@extends('layouts.master')

@section('title')
    <p>Adauga investitie</p>
@stop

@section('content')
<style type="text/css">
    .ko{ 
        background-color:red !important;
    }
    .ok{
        background-color:green !important;   
    }
</style>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary" id="div_grid_imobile">
                <div class="panel-heading">Lista imobile disponibile (Click pentru expandare)
                    <a href="#" class="pull-right btn-primary" id="btn_show_hide_imobil" title="Afiseaza / Ascunde zona de cautare">
                        <i class="fa fa-list"></i>
                    </a> 
                </div>                
                <div id="div_imobile" class="panel-body" style="display:none">
                    <div class="panel panel-default">
                       <div class="panel-heading">
                            Lista imobile
                            <div class="pull-right">                      
                                <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                      
                                <a href="{{ URL::route('imobil_add') }}"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>                      
                            </div>
                       </div>
                       <div class="panel-body">
                           <div class="table-responsive">
                              <table class="table table-striped table-bordered table-hover" id="dataTables-imobil">
                                <thead>
                                  <tr>                                   
                                    <th class="text-center">Adresa</th>                      
                                    <th class="text-center">Regiune</th>
                                    <th class="text-center">Judet</th>
                                    <th class="text-center">Localitate</th>
                                    <th class="text-center">Nr apartamente</th>
                                    <th class="text-center">Actiuni</th>
                                  </tr>
                                </thead>
                                <tfoot>
                                  <tr>                                                               
                                    <th class="text-center">Adresa</th>                      
                                    <th class="text-center">Regiune</th>
                                    <th class="text-center">Judet</th>
                                    <th class="text-center">Localitate</th>
                                    <th class="text-center">Nr apartamente</th>                          
                                    <th class="text-center">Actiuni</th>
                                  </tr>
                                </tfoot>
                                <tbody>                             
                                  @foreach ($imobile as $imobil)
                                    <tr data-id="{{ $imobil->id }}">                              
                                      <td class="text-left">{{ $imobil->adresa }}</td>
                                      <td class="text-center">{{ $imobil->regiune }}</td>
                                      <td class="text-center">{{ $imobil->judet }}</td>
                                      <td class="text-center">{{ $imobil->localitate }}</td>
                                      <td class="text-center">{{ $imobil->numar_apartamente }}</td>
                                      <td class="center action-buttons">           
                                        <a href="#"><i class="fa fa-hand-o-down" title="Selectioneaza"></i></a>
                                      </td>                                  
                                    </tr>
                                  @endforeach                              
                                </tbody>
                              </table>
                           </div>
                       </div>               
                    </div>
                </div> 
            </div>     
            <div class="panel panel-info">
                <div class="panel-heading">Tipuri de cheltuieli pe surse de finantare (Click pentru expandare)
                    <a href="#" class="pull-right" id="btn_show_hide_cheltuieli">
                        <i class="fa fa-list"></i>
                    </a>
                </div>                
                <div id="div_tip_cheltuieli" class="panel-body" style="display:none">                    
                   <div class="panel-body">
                       <div class="table-responsive">
                          <table class="table table-striped table-bordered table-hover" id="dataTables-imobil">
                            <thead>
                              <tr>                                                                                 
                                <th class="text-center">Denumire</th>                      
                                <th class="text-center">Eligibil pentru spatii de locuit</th>
                                <th class="text-center">Neeligibil pentru spatii de locuit</th>
                                <th class="text-center">Neeligibil pentru spatii cu alta destinatie</th>
                                <th class="text-center">Eligibil pentru spatii cu alta destinatie</th>
                              </tr>
                            </thead>
                            <tfoot>
                              <tr>                                                               
                                <th class="text-center">Denumire</th>                      
                                <th class="text-center">Eligibil pentru spatii de locuit</th>
                                <th class="text-center">Neeligibil pentru spatii de locuit</th>
                                <th class="text-center">Neeligibil pentru spatii cu alta destinatie</th>
                                <th class="text-center">Eligibil pentru spatii cu alta destinatie</th>
                              </tr>
                            </tfoot>
                            <tbody>                             
                              @foreach ($cheltuieli as $cheltuiala)
                                <tr data-id="{{ $cheltuiala->id }}">                              
                                  <td class="text-left">{{ $cheltuiala->denumire }}</td>
                                  <td class="text-center">{{ $cheltuiala->eligibil_spatii_locuit?'DA':'NU' }}</td>
                                  <td class="text-center">{{ $cheltuiala->neeligibil_spatii_locuit?'DA':'NU' }}</td>
                                  <td class="text-center">{{ $cheltuiala->neeligibil_spatii_alta_destinatie?'DA':'NU' }}</td>
                                  <td class="text-center">{{ $cheltuiala->eligibil_spatii_alta_destinatie?'DA':'NU' }}</td>                                  
                                </tr>
                              @endforeach                              
                            </tbody>
                          </table>
                       </div>
                   </div>               
                </div> 
            </div>     
            <div class="text-center">
                <h3 class=""><u>Date generale investitie</u></h3>
            </div> 
            <form role="form" action="{{ URL::current() }}" method="post">
                <fieldset>
                    @if(Session::has('message'))
                        <p class="alert @if($errors->isEmpty()) alert-success @else alert-danger @endif">{{ Session::get('message')  }}</p>
                    @endif                     
                    <div class="hidden">                    
                        {{ Form::textField('ID Imobil', 'id_imobil') }}                                 
                    </div>

                    <div class="col-md-4">
                        {{ Form::textField('Imobil', 'imobil', Input::get('imobil'), ['readonly']) }}                    
                    </div>                
                                                                                                        
                    <div class="col-md-4">
                        {{ Form::textField('Judet', 'judet', Input::get('judet'), ['readonly']) }}                    
                    </div>

                    <div class="col-md-4">
                        {{ Form::textField('Localitate', 'localitate', Input::get('localitate'), ['readonly']) }}
                    </div> 

                    <div class="col-md-12">
                        {{ Form::selectField('Al carui departament este investitia?', 'departament', $departamente) }}                    
                    </div> 

                    <div class="col-md-8">
                        {{ Form::textField('Denumire investitie', 'denumire') }}
                    </div>

                    <div class="col-md-4">
                        {{ Form::selectField('Cota TVA', 'cota_tva', $tva) }}                    
                    </div> 

                    <div class="col-md-4">
                        {{ Form::textNumericField('1) Cota indiviza spatii de locuit (%)', 'cota_indiviza_spatii_locuit') }}
                    </div>       

                    <div class="col-md-4">
                        {{ Form::textNumericField('2) Cota indiviza spatii alta destinatie (%)', 'cota_indiviza_spatii_alta_destinatie') }}
                    </div>       

                    <div class="col-md-4">
                        {{ Form::textNumericField('3) Total cota indiviza (%)', 'total_cota_indiviza', null, [],'<i id="ci_error" class="fa fa-exclamation-circle"></i>') }}
                    </div>       

                    <div class="col-md-4">
                        {{ Form::textNumericField('4) Finantare nerambursabila POR (%)', 'finantare_nerambursabila_por', $finantare_nerambursabila_por, ['readonly']) }}                    
                    </div>       

                    <div class="col-md-4">
                        {{ Form::textNumericField('5) Cofinantare AP cheltuieli eligibile (%)', 'cofinantare_ap_eligibil') }}                    
                    </div>

                    <div class="col-md-4">
                        {{ Form::textNumericField('6) Cofinantare UAT cheltuieli eligibile (%)', 'cofinantare_uat_eligibil', 0, ['readonly']) }}                    
                    </div>

                    <div class="col-md-4">
                        {{ Form::textNumericField('7) Cofinantare AP cheltuieli neeligibile (spatii alta destinatie) (%)', 'cofinantare_ap_neeligibil_ad', $cofinantare_ap_neeligibil_ad, ['readonly']) }}                        
                    </div>       
                    
                    <div class="col-md-4">
                        {{ Form::textNumericField('8) Cofinantare UAT cheltuieli neeligibile (%)', 'cofinantare_uat_neeligibil') }}                    
                    </div>       

                    <div class="col-md-4">
                        {{ Form::textNumericField('9) Cofinantare AP cheltuieli neeligibile (spatiil de locuit) (%)', 'cofinantare_ap_neeligibil_sl', 0, ['readonly']) }}                        
                    </div>                   
                             
                    <div class="col-md-12 center"> 
                        <input type="submit" name="btn_submit" class="btn btn-primary btn-lg button-width" value="Salveaza" onclick="this.value='Se salveaza ..';this.disabled='disabled'; this.form.submit();" />
                        <a href="{{ URL::route('investitie_por_axa12_list') }}">
                            <input type="button" id="back" class="btn btn-warning btn-lg button-width" value="Inapoi" />
                        </a>                         
                    </div>
                    {{ Form::token() }}                                                    
                </fieldset>
            </form>
            <div class ='alert alert-info alert-dismissable top24'>
                {{ Form::label('', '1) Cota parte indiviza aferenta spatiilor de locuit')}}<br>
                {{ Form::label('', '2) Cota parte indiviza aferenta spatiilor cu alta destinatie decat cea de locuit')}}<br>
                {{ Form::label('', '3) Total cota indiviza. Aceasta valoare este o valoare calculata si reprezinta 1) + 2). Pentru corectitudinea calculelor valoarea ei trebuie sa fie 100%')}}<br>
                {{ Form::label('', '4) Finantare nerambursabila POR Axa 1.2 pentru lucrarile cu cheltuieli eligibile')}}<br>
                {{ Form::label('', '5) Cofinantare Asociatia de Proprietari pentru lucrarile cu cheltuieli eligibile (%)')}}<br>
                {{ Form::label('', '6) Cofinantare UAT pentru lucrarile cu cheltuieli eligibile (%)')}}<br>                
                {{ Form::label('', '7) Cofinantare Asociatia de Proprietari pentru lucrarile cu cheltuieli neeligibile datorate spatiilor cu alta destinatie decat cea de locuinte (contributia spatiilor cu alta destinatie decat cea de locuinta)')}}<br>                
                {{ Form::label('', '8) Cofinantare UAT pentru lucrarile cu cheltuieli neeligibile datorate lucrarilor care nu se incadreaza in ordinul de cheltuieli eligibile')}}<br>
                {{ Form::label('', '9) Cofinantare Asociatia de Proprietari pentru lucrarile cu cheltuieli neeligibile datorate lucrarilor care nu se incadreaza in ordinul de cheltuieli eligibile (contributia spatiilor de locuit)')}}<br>
            </div>
        </div>
    </div>
@stop

@section('footer_scripts')
    {{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.js') }}
    {{ HTML::script('assets/js/plugins/dataTables/dataTables.bootstrap.js') }}
    {{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.columnFilter.js') }}
    {{ HTML::script('assets/js/util.js') }}

    <script>
    
        $(document).ready(function(){ 
            $('#dataTables-imobil').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 1 ] }
                ],
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'}
            });

            $("#btn_show_hide_imobil").click(function(){
                $("#div_imobile").toggle();           
            });

            $("#btn_show_hide_cheltuieli").click(function(){
                $("#div_tip_cheltuieli").toggle();           
            });

            $(document).on('click','#dataTables-imobil tbody tr', function () {
                var id = $(this).data('id'); 
                var adresa = $(this).find('td:nth-child(1)').text();
                var judet = $(this).find('td:nth-child(3)').text();
                var localitate = $(this).find('td:nth-child(4)').text();


                $('#id_imobil').val(id);               
                $('#imobil').val(adresa);
                $('#judet').val(judet);
                $('#localitate').val(localitate);
                $("#btn_show_hide").click();
            });

            $('#cota_indiviza_spatii_locuit,#cota_indiviza_spatii_alta_destinatie').bind("change keyup input focus",(function(){
                var ci_sl = text_2_number($('#cota_indiviza_spatii_locuit').val());
                var ci_ad = text_2_number($('#cota_indiviza_spatii_alta_destinatie').val());
                $('#total_cota_indiviza').val(formato_numero(ci_sl + ci_ad, 2, ',', '.') + '%');
                var $group = $('.input-group'),
                    $addon = $group.find('.input-group-addon'),
                    $icon = $("#ci_error");


                if (ci_ad + ci_sl != 100.0)
                {
                    console.log("<>100");
                    console.debug($addon);
                    $addon.removeClass('input-group-addon label-success');
                    $addon.addClass('input-group-addon label-danger');
                    $icon.removeClass('fa fa-check-circle');               
                    $icon.addClass('fa fa-exclamation-circle');
                }
                else
                {
                    console.log("=100");
                    $addon.removeClass('label-danger');
                    $addon.addClass('input-group-addon label-success');
                    $icon.removeClass('fa fa-exclamation-circle');
                    $icon.addClass('fa fa-check-circle');               
                }            
            }));
            $('#finantare_nerambursabila_por,#cofinantare_ap_eligibil').bind("change keyup input focus",(function(){
                var fn_por = text_2_number($('#finantare_nerambursabila_por').val());
                var cf_ape = text_2_number($('#cofinantare_ap_eligibil').val());
                console.log(fn_por + ' --- ' + cf_ape);
                $('#cofinantare_uat_eligibil').val(formato_numero(100 - fn_por - cf_ape, 2, ',', '.') + '%');
            })); 

            $('#cofinantare_uat_neeligibil').bind("change keyup input focus",(function(){
                var cf_ad = text_2_number($('#cofinantare_ap_neeligibil_ad').val());
                var cf_sl = text_2_number($('#cofinantare_uat_neeligibil').val());                
                $('#cofinantare_ap_neeligibil_sl').val(formato_numero(cf_ad - cf_sl, 2, ',', '.') + '%');
            }));             
        });       
    </script>
@stop