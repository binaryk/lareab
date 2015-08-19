@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}
    {{ HTML::style('assets/css/plugins/jquery.dataTables.css') }}
    {{ HTML::style('assets/css/plugins/morris.css') }}
@stop

@section('title')
    <p>Locatarii imobilului 
        @if(isset($imobil)) {{ $imobil->adresa }}@endif 
    </p> 
@stop

@section('content')
<style>
    .albastru_1 { background-color: #0b62a4; }
    .albastru_2 { background-color: #3980b5; }
    .albastru_3 { background-color: #679dc6; }
    .albastru_4 { background-color: #95bbd7; }
    .albastru_5 { background-color: #b0cce1; }    
</style>
    <div class="row">
        <div class="col-lg-12">
           <div class="panel panel-primary">
                <div class="panel-heading">Zona de cautare
                    <button id="btn_show_hide" class="btn btn-primary" title="Afiseaza / Ascunde zona de cautare">
                        <i class="fa fa-list"></i>
                    </button>  
                </div>
                                                                        
                <div id="div_cautare" class="panel-body" style="display:none">
                    <table width="100%">
                        <tr>
                            <td width="25%">
                                <label class="control-label">Scara</label></td>
                            <td width="75%"><p id="_col_scara"></p></td>
                        </tr>                    
                        <tr>
                            <td width="25%">
                                <label class="control-label">Nr.apartament</label></td>
                            <td width="75%"><p id="_col_nr_ap"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Nume</label></td>
                            <td width="75%"><p id="_col_nume"></p></td>
                        </tr>   
						<tr>
                            <td width="25%">
                                <label class="control-label">Etaj</label></td>
                            <td width="75%"><p id="_col_etaj"></p></td>
                        </tr>                                                          
                        <tr>
                            <td width="25%">
                                <label class="control-label">Suprafata utila (&#13217;)</label></td>
                            <td width="75%"><p id="_col_suprafata_utila"></p></td>
                        </tr>                                                          
                        <tr>
                            <td width="25%">
                                <label class="control-label">%Cota parte</label></td>
                            <td width="75%"><p id="_col_cota_parte"></p></td>
                        </tr>                                                          
                        <tr>
                            <td width="25%">
                                <label class="control-label">Nr.membri familie</label></td>
                            <td width="75%"><p id="_col_nr_membri"></p></td>
                        </tr>                                                          
                        <tr>
                            <td width="25%">
                                <label class="control-label">Destinatie spatiu</label></td>
                            <td width="75%"><p id="_col_destinatie"></p></td>
                        </tr> 
                        <tr>
                            <td width="25%">
                                <label class="control-label">Numar cadastral</label></td>
                            <td width="75%"><p id="_col_nr_cadastral"></p></td>
                        </tr>                                                                                                                                           
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
               <div class="panel-heading">
                    Lista de locatari(proprietari) ai imobilului
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                                              
                        <a href="{{ URL::route('locatar_add', $imobil->id) }}"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>
                    </div>
               </div>
               <div class="hidden">
                   {{ $total_150 = 0; $total_350 = 0; $total_500 = 0; $total_500plus = 0; $total_nedeclarat = 0 }}
                   {{ $cota_parte_calculata = 0; $numar_locuinte = 0; $numar_spatii = 0; $acord_masuri_propuse = 0; }}
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-locatari">
                        <thead>
                          <tr>                                                             
                            <th class="text-center">Scara</th>                             
                            <th class="text-center">Nr.ap.</th>                      
                            <th class="text-center">Nume proprietar</th>
                            <th class="text-center">Etaj</th>
                            <th class="text-center">Suprafata utila</th>
                            <th class="text-center">Cota parte</th>
                            <th class="text-center">Nr.membri</th>
                            <th class="text-center">Destinatie spatiu</th>
                            <th class="text-center">Venit lunar</th>
                            <th class="text-center">Asteapta verificare</th>
                            <th class="text-center">Actiuni</th>
                            <th class="hidden"></th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                                                                        
                            <th class="text-center">Scara</th>
                            <th class="text-center">Nr.ap.</th>                      
                            <th class="text-center">Nume proprietar</th>
                            <th class="text-center">Etaj</th>
                            <th class="text-center">Suprafata utila</th>
                            <th class="text-center">Cota parte</th>
                            <th class="text-center">Nr.membri</th>
                            <th class="text-center">Destinatie spatiu</th>
                            <th class="text-center">Venit lunar</th>
                            <th class="text-center">Asteapta verificare</th>
                            <th class="text-center">Actiuni</th>
                            <th class="hidden"></th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($locatari as $locatar)
                            <tr data-id="{{ $locatar->id }}">                                                            
                              <td class="text-center">{{ $locatar->scara }}</td> 
                              <td class="text-center">{{ $locatar->nr_apartament }}</td>                            
                              <td class="text-left">{{ $locatar->nume }}</td>                            
                              <td class="text-center">{{ $locatar->etaj }}</td>
                              <td class="text-right">{{ number_format($locatar->suprafata_utila, 2, ',', '.') }} &#13217;</td>
                              <td class="text-right">@if($suprafata_utila_imobil > 0) {{ number_format($locatar->suprafata_utila * 100.0 / $suprafata_utila_imobil, 2, ',', '.') }} &#37; @endif</td>
                              <td class="text-center">{{ $locatar->nr_membri_familie }}</td>
                              <td class="text-center">{{ $locatar->destinatie_spatiu }}</td>
                              <td class="text-left">{{ $locatar->venit_lunar }}</td>
                              <td class="text-center">@if($locatar->asteapta_verificare == true) DA @else NU @endif</td>
                              <td class="center action-buttons"> 
                                <a href="{{ URL::route('locatar_edit', [$locatar->id, $imobil->id]) }}">
                                  <i class="fa fa-pencil-square-o" title="Vizualizeaza sau modifica"></i>
                                </a>                                                                                                                   
                                <a href="#"><i class="fa fa-trash-o" title="Sterge"></i></a>                                                             
                              </td>                                  
                              <td class="hidden">
                                @if($suprafata_utila_imobil > 0) {{ $cota_parte_calculata += ($locatar->suprafata_utila * 100.0 / $suprafata_utila_imobil) }} @endif
                                @if($locatar->id_destinatie_spatiu == 1) 
                                    {{ $numar_locuinte++ }}
                                    @if     ($locatar->id_venit_lunar == 1) {{ $total_150++         }} 
                                    @elseif ($locatar->id_venit_lunar == 2) {{ $total_350++         }}
                                    @elseif ($locatar->id_venit_lunar == 3) {{ $total_500++         }}
                                    @elseif ($locatar->id_venit_lunar == 4) {{ $total_500plus++     }}                                    
                                    @elseif ($locatar->id_venit_lunar == 5) {{ $total_nedeclarat++  }} 
                                    @endif                                   
                                @endif
                                @if($locatar->id_destinatie_spatiu == 2) {{ $numar_spatii++ }} @endif
                                @if($locatar->id_acord == 1 ) {{ $acord_masuri_propuse++ }} @endif
                              </td>
                            </tr>
                          @endforeach                             
                        </tbody>
                      </table>
                   </div>
                   <!-- /.table-responsive -->
               </div>
               <div class="hidden">
                   {{ $total_declarat = $total_150 + $total_350 + $total_500 + $total_500plus; }}
                   {{ $tot_gen = $total_declarat + $total_nedeclarat; }}
               </div>
               <div class ='alert alert-info alert-dismissable'>
                    <table class="table">
                        <tr>
                            <td colspan="3" class="text-left"><h4>{{ Form::label('', 'Date imobil, din măsuratorile realizate de firma', ['class' => 'label label-warning']) }}</h4></td>
                        </tr>                                 
                        <tr>
                            <td width="60%">{{ Form::label('', 'Total suprafață utilă măsurata imobil (&#13217;) =') }}</td>
                            <td width="5%" class="text-right">{{ Form::label('', number_format($imobil->suprafata_utila_masurata, 2, ',', '.')) }}</td>                    
                            <td></td>
                        </tr>    
                        <tr>
                            <td>{{ Form::label('', 'Total spații altă destinație + locuințe =') }}</td>
                            <td class="text-right">{{ Form::label('', number_format($imobil->numar_apartamente, 0, ',', '.') . ' ') }}</td>
                            <td class="text-right">
                                @if(($numar_locuinte + $numar_spatii) != $imobil->numar_apartamente) 
                                    <button type="button" class="btn btn-danger dim" id="btn_numar_apartamente_error"><i class="fa fa-warning"></i></button>
                                @endif                            
                            </td>
                        </tr>                                                      
                        <tr>
                            <td colspan="3" class="text-left"><h4>{{ Form::label('', 'Date imobil, din datele furnizate de asociațiile de proprietari', ['class' => 'label label-warning']) }}</h4></td>
                        </tr>                                                                     
                        <tr>
                            <td>{{ Form::label('', 'Total suprafață utilă calculată imobil (&#13217;) =') }}</td>
                            <td class="text-right">{{ Form::label('', number_format($suprafata_utila_imobil, 2, ',', '.')) }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>{{ Form::label('', 'Total cotă parte imobil (&#37;) =') }}</td>
                            <td class="text-right">{{ Form::label('', number_format($cota_parte_calculata, 2, ',', '.')) }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>{{ Form::label('', 'Total locuințe =') }}</td>
                            <td class="text-right">{{ Form::label('', number_format($numar_locuinte, 0, ',', '.') . ' ') }}</td>
                            <td></td>
                            <td rowspan="9">
                                <div id="canvas-holder half">
                                    <canvas id="chart-area" width="350" height="350"/>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ Form::label('', 'Total spații altă destinație =') }}</td>
                            <td class="text-right">{{ Form::label('', number_format($numar_spatii, 0, ',', '.') . ' ') }}</td>
                            <td></td>
                        </tr>  
                                                              
                        <tr>
                            <td colspan="3" class="text-left"><h4>{{ Form::label('', 'Proprietari din bloc, cu un venit mediu lunar net pe membru de familie in anul fiscal anterior depunerii cererii de finantare', ['class' => 'label label-warning']) }}</h4></td>
                        </tr>                                                                      
                        <tr>                        
                            <td>{{ Form::label('', 'Familii cu venituri sub 150&#8364; =') }}</td>
                            <td class="text-right">{{ Form::label('', number_format($total_150, 0, ',', '.') . ' ') }}</td>
                            <td class="text-right">{{ Form::label('', '&#8776; ' . number_format($total_150 / $tot_gen * 100, 2, ',', '.') . ' (&#37;)', ['class' => 'badge albastru_1']) }}</td>
                        </tr>                                                
                        <tr>
                            <td>{{ Form::label('', 'Familii cu venituri intre 150&#8364; si 350&#8364; =') }}</td>
                            <td class="text-right">{{ Form::label('', number_format($total_350, 0, ',', '.') . ' ') }}</td>
                            <td class="text-right">{{ Form::label('', '&#8776; ' . number_format(($total_150+$total_350) / $tot_gen * 100, 2, ',', '.') . ' (&#37;)', ['class' => 'badge albastru_2']) }}</td>
                        </tr>                                                
                        <tr>
                            <td>{{ Form::label('', 'Familii cu venituri intre 350&#8364; si 500&#8364; =') }}</td>
                            <td class="text-right">{{ Form::label('', number_format($total_500, 0, ',', '.') . ' ') }}</td>
                            <td class="text-right">{{ Form::label('', '&#8776; ' . number_format(($total_150+$total_350+$total_500) / $tot_gen * 100, 2, ',', '.') . ' (&#37;)', ['class' => 'badge albastru_3']) }} </td>
                        </tr>                                                
                        <tr>
                            <td>{{ Form::label('', 'Familii cu venituri peste 500&#8364; =') }}</td>
                            <td class="text-right">{{ Form::label('', number_format($total_500plus, 0, ',', '.') . ' ') }}</td>
                            <td class="text-right">{{ Form::label('', '&#8776; ' . number_format(($total_150+$total_350+$total_500+$total_500plus) / $tot_gen * 100, 2, ',', '.') . ' (&#37;)', ['class' => 'badge albastru_4']) }}</td>
                        </tr>  
                        <tr>
                            <td colspan="3" class="text-left"><h4>{{ Form::label('', 'Proprietari din bloc care nu și-au declarat venitul cnf. Model D, în anul fiscal anterior depunerii cererii de finanțare', ['class' => 'label label-warning']) }}</h4></td>
                        </tr>                                                                                   
                        <tr>
                            <td>{{ Form::label('', 'Familii care nu au declarat venitul =') }}</td>
                            <td class="text-right">{{ Form::label('', number_format($total_nedeclarat, 0, ',', '.') . ' ') }}</td>
                            <td class="text-right">{{ Form::label('', '&#8776; ' . number_format($total_nedeclarat / $tot_gen * 100, 2, ',', '.') . ' (&#37;)') }}</td>
                        </tr>                                                
                        <tr>
                            <td colspan="2" class="text-left"><h4>{{ Form::label('', 'Condiții de eligibilitate', ['class' => 'label label-warning']) }}</h4></td>
                            <td class="text-right">
                                @if (($total_declarat/ $tot_gen * 100 > 50.0) && 
                                     ($acord_masuri_propuse / $tot_gen * 100 >= 66.66) &&
                                     (($numar_locuinte + $numar_spatii) == $imobil->numar_apartamente))
                                    <button class="btn btn-success btn-xs" name="eligibil">&nbsp;&nbsp;Eligibil <i class="fa fa-check-circle"></i>&nbsp;</button>
                                @else                                
                                    <button class="btn btn-danger btn-xs" name="neeligibil">&nbsp;&nbsp;Neeligibil <i class="fa fa-exclamation-circle"></i>&nbsp;</button>
                                @endif
                            </td>

                        </tr>                                                                                   
                        <tr>
                            <td>{{ Form::label('', 'Proprietari din bloc care și-au declarat venitul cnf. Model D, în anul fiscal anterior depunerii cererii de finanțare') }}</td>
                            <td class="text-right">{{ Form::label('', number_format($total_declarat, 0, ',', '.') . ' ') }}</td>
                            <td class="text-right">{{ Form::label('', '&#8776; ' . number_format($total_declarat / $tot_gen * 100, 2, ',', '.') . ' (&#37;)') }}</td>
                        </tr>                                                
                        <tr>
                            <td>{{ Form::label('', 'Proprietari din bloc care și-au dat acordul pentru măsurile propuse') }}</td>
                            <td class="text-right">{{ Form::label('', number_format($acord_masuri_propuse, 0, ',', '.') . ' ') }}</td>
                            <td class="text-right">{{ Form::label('', '&#8776; ' . number_format($acord_masuri_propuse / $tot_gen * 100, 2, ',', '.') . ' (&#37;)') }}</td>
                        </tr>                                                
                    </table>
               </div>
               <!-- /.panel-body -->
           </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row --> 
@stop

@section('footer_scripts')
    <!-- DataTables JavaScript -->
    {{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.js') }}
    {{ HTML::script('assets/js/plugins/dataTables/dataTables.bootstrap.js') }}
    {{ HTML::script('assets/js/plugins/dataTables/dataTables.tableTools.js') }}
    {{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.columnFilter.js') }}
    {{ HTML::script('assets/js/plugins/bootbox.js') }}     
    {{ HTML::script('assets/js/plugins/chart-js/Chart.Core.js') }} 
    {{ HTML::script('assets/js/plugins/chart-js/Chart.Doughnut.js') }} 
    {{ HTML::script('assets/js/util.js') }} 

    <script>
        $(document).ready(function() {
            //Obtin valoarea variabilelor php in JS
            var total_150 = {{ json_encode($total_150) }};
            var total_350 = {{ json_encode($total_350) }};
            var total_500 = {{ json_encode($total_500) }};
            var total_500plus = {{ json_encode($total_500plus) }};
            var acord = {{ json_encode($acord_masuri_propuse) }};
            var tot_gen = {{ json_encode($tot_gen) }};

            //Calculez valorile ce voi a reprezenta pe chart
            var t150 = total_150 / tot_gen * 100;
            var t350 = (total_150 + total_350) / tot_gen * 100; 
            var t500 = (total_150 + total_350 + total_500) / tot_gen * 100; 
            var t500plus = (total_150 + total_350 + total_500 + total_500plus) / tot_gen * 100; 

            //alert("#FF5A5E --> " + CalculeazaLuminozitateCuloare("#F7464A", 0.28));

            var covrig = [
                {
                    color: "#0b62a4",
                    highlight: CalculeazaLuminozitateCuloare("#0b62a4", 0.28),
                    value: t150.toFixed(2),
                    label: "% Venituri sub 150€"
                },
                {
                    color: "#3980b5",
                    highlight: CalculeazaLuminozitateCuloare("#3980b5", 0.28),
                    value: t350.toFixed(2),
                    label: "% Venituri intre 150€ si 350€"
                },
                {
                    color: "#679dc6",
                    highlight: CalculeazaLuminozitateCuloare("#679dc6", 0.28),
                    value: t500.toFixed(2),
                    label: "% Venituri intre 350 si 500€"
                },
                {
                    color: "#95bbd7",
                    highlight: CalculeazaLuminozitateCuloare("#95bbd7", 0.28),
                    value: t500plus.toFixed(2),
                    label: "% Venituri peste 500€"
                }
            ];
            var ctx = document.getElementById("chart-area").getContext("2d");
            window.myDoughnut = new Chart(ctx).Doughnut(covrig, {responsive : true});

            $('#btn_numar_apartamente_error').on('click', function(){
                MessageBox("ERROR", "Numarul de apartamente si spatii din imobil nu corespunde cu numarul de inregistrari introduse.");
            });
            $('#dataTables-locatari').dataTable({
               
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 1 ] }
                ],
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'},
                "order": [[0,"desc"]]
            });

            $("#btn_show_hide").click(function(){
                $("#div_cautare").toggle();             
            });
               
            $('#dataTables-locatari').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_scara", type: "text" },
                  { sSelector: "#_col_nr_ap", type: "text" },
                  { sSelector: "#_col_nume", type: "text" },
                  { sSelector: "#_col_etaj", type: "text" },  
                  { sSelector: "#_col_suprafata_utila", type: "text" },
                  { sSelector: "#_col_cota_parte", type: "text" },
                  { sSelector: "#_col_nr_membri", type: "text" },
                  { sSelector: "#_col_destinatie", type: "select" },
                  { sSelector: "#_col_nr_cadastral", type: "text" }
                ]
            }); 

            $('.fa-trash-o').click(function(){
                var id = $(this).closest('tr').data('id'); 
                var url_delete = "{{ URL::route('locatar_delete') }}";               
                bootbox.confirm({
                    title: "Sunteti sigur de stergerea inregistrarii?",
                    message: ' ',
                    buttons: {
                        'confirm': {
                            label: "Da, sterge!",
                            className: "btn-success"
                        },
                        'cancel': {
                            label: "Nu, renunta!",
                            className: "btn-danger"
                        }
                    },
                    callback: function(result){
                        if(result) {
                            $.ajax({
                                type: "POST",
                                url : url_delete,
                                data : {
                                    "_token": '<?= csrf_token() ?>',
                                    "id": id
                                },
                                success : function(data){
                                    $('tr[data-id='+id+']').fadeOut();
                                }
                            });
                        }
                    }
                });
            });
        });
        $('[title]:not([data-placement])').tooltip({'placement': 'top'});
    </script>
@stop