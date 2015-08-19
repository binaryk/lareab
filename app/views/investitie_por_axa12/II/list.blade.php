@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}  
    {{ HTML::style('assets/css/plugins/jquery.dataTables.css') }}  
@stop


@section('title')
  Centralizatorul valorilor pe lucrari din etapele: DALI, PT, ACHIZITIE
@stop

@section('content')
    <style>
      .subtotal { vertical-align:middle; }
    </style>
    <span class="hidden">
      {{ 
      $total_sf = 0; $total_pt = 0; $total_ach = 0; $proc_pt_sf = 0; $proc_sf_ach = 0;       
      }}
    </span>
    <div class="row">
        <div class="col-lg-12">
           <div class="panel panel-primary">
                <div class="panel-heading">Zona de cautare
                    <a href="#" class="pull-right btn-primary" id="btn_show_hide_articol" title="Afiseaza / Ascunde zona de cautare">
                        <i class="fa fa-list"></i>
                    </a>  
                </div>
                                                                        
                <div id="div_cautare_articol" class="panel-body" style="display:none">
                    <table width="100%">
                        <tr>
                            <td width="25%">
                                <label class="control-label">Denumire</label></td>
                            <td width="75%"><p id="_col_denumire"></p></td>
                        </tr>
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
              <div class="panel-heading">
                  Lista articole de deviz          
                  <div class="pull-right">                      
                      <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                  
                  </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-articol">
                        <thead>
                          <tr>
                            <th class="text-center" rowspan="2">Denumire</th>
                            <th class="text-center" colspan="6">Valoare deviz fara TVA</th>
                          </tr>
                          <tr>                                                               
                            <th class="text-center">Etapa SF</th>
                            <th class="text-center">Etapa PT</th>
                            <th class="text-center">%PT-SF</th>
                            <th class="text-center">Etapa Achizitii</th>
                            <th class="text-center">%SF-ACH</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>

                        <tbody>                             
                          @foreach ($articole as $key => $articol)
                              @if ($articol->tip == RowType::titlu) 
                                  <tr data-id="{{ $articol->id_obiect }}">  
                                      <td class="hidden">{{$key}}</td>
                                      <td class="text-left"><h4>{{ Form::label('', $articol->obiect, ['class' => 'label label-success']) }}</h4></td>
                                      <td class="hidden"></td>
                                      <td class="hidden"></td>
                                      <td class="hidden"></td>
                                      <td class="hidden"></td>
                                      <td class="hidden"></td>
                                      <td class="hidden"></td>
                                  </tr>
                              @elseif ($articol->tip == RowType::detaliu)
                                  <tr data-id="{{ $articol->id }}">  
                                      <td class="hidden">{{$key}}</td>       
                                      <td class="text-right">{{ $articol->articol }}</td>
                                      <td class="text-right" style="width:10%">{{ number_format($articol->valoare_ftva_1, 2, ',', '.') }}</td>                                
                                      <td class="text-right" style="width:10%">{{ number_format($articol->valoare_ftva_2, 2, ',', '.') }}</td>
                                      <td class="text-right" style="width:10%" title="RAPORTUL DINTRE VALOAREA DIN PROIECTUL TEHNIC SI STUDIU DE FEZABILITATE">@if($articol->valoare_ftva_1 != 0) {{ number_format(($articol->valoare_ftva_2/$articol->valoare_ftva_1) * 100, 2, ',', '.') }}% @endif</td>                                
                                      <td class="text-right" style="width:10%">{{ number_format($articol->valoare_ftva_3, 2, ',', '.') }}</td>                                
                                      <td class="text-right" style="width:10%" title="RAPORTUL DINTRE VALOAREA DIN CONTRACTUL DE ACHIZITII LUCRARI SI PROIECTUL TEHNIC">@if($articol->valoare_ftva_2 != 0) {{ number_format(($articol->valoare_ftva_3/$articol->valoare_ftva_2) * 100, 2, ',', '.') }}% @endif</td>
                                      <td class="center action-buttons">
                                        <a href="{{ URL::route('investitie_por_axa12_articol_valori_create_edit', [$id_investitie, $articol->id]) }}"><i class="fa fa-pencil-square-o" title="Editeaza"></i></a>                                  
                                      </td>                             
                                  </tr>
                              @elseif ($articol->tip == RowType::sub_total)
                                  <tr> 
                                      <td class="hidden">{{$key}}</td>  
                                      <td class="text-left"><h4>{{ Form::label('', 'Subtotal obiect', ['class' => 'label label-info']) }}</h4></td>
                                      <th class="text-right"><h4>{{ Form::label('', number_format($articol->valoare_ftva_1, 2, ',', '.'), ['class' => 'label label-info']) }}</h4></th>
                                      <th class="text-right"><h4>{{ Form::label('', number_format($articol->valoare_ftva_2, 2, ',', '.'), ['class' => 'label label-info']) }}</h4></th>
                                      <th class="text-right"><h4>{{ Form::label('', number_format($articol->p1, 2, ',', '.') . '%', ['class' => 'label label-info']) }}</h4></th>
                                      <th class="text-right"><h4>{{ Form::label('', number_format($articol->valoare_ftva_3, 2, ',', '.'), ['class' => 'label label-info']) }}</h4></th>
                                      <th class="text-right"><h4>{{ Form::label('', number_format($articol->p2, 2, ',', '.') . '%', ['class' => 'label label-info']) }}</h4></th>
                                      <td class="text-center"></td>
                                  </tr>
                              @elseif ($articol->tip == RowType::total)
                                  <tr> 
                                      <td class="hidden">{{$key}}</td>  
                                      <td class="text-left"><h4>{{ Form::label('', 'Total general', ['class' => 'label label-warning']) }}</h4></td>
                                      <th class="text-right"><h4>{{ Form::label('', number_format($articol->valoare_ftva_1, 2, ',', '.'), ['class' => 'label label-warning']) }}</h4></th>
                                      <th class="text-right"><h4>{{ Form::label('', number_format($articol->valoare_ftva_2, 2, ',', '.'), ['class' => 'label label-warning']) }}</h4></th>
                                      <th class="text-right"><h4>{{ Form::label('', number_format($articol->p1, 2, ',', '.') . '%', ['class' => 'label label-warning']) }}</h4></th>
                                      <th class="text-right"><h4>{{ Form::label('', number_format($articol->valoare_ftva_3, 2, ',', '.'), ['class' => 'label label-warning']) }}</h4></th>
                                      <th class="text-right"><h4>{{ Form::label('', number_format($articol->p2, 2, ',', '.') . '%', ['class' => 'label label-warning']) }}</h4></th>
                                      <td class="text-center"></td>
                                  </tr>
                                  <span class="hidden">
                                    {{ $total_sf = $articol->valoare_ftva_1 }}
                                    {{ $total_pt = $articol->valoare_ftva_2 }}
                                    {{ $total_ach = $articol->valoare_ftva_3 }}
                                    {{ $proc_pt_sf = $articol->p1 }}
                                    {{ $proc_sf_ach = $articol->p1 }}
                                  </span>
                              @endif
                          @endforeach                             
                        </tbody>
                        <!--tfoot>
                          <tr>                                   
                            <td class="text-left"><h4>{{ Form::label('', 'Total general', ['class' => 'label label-warning']) }}</h4></td>
                            <th class="text-right"><h4>{{ Form::label('', number_format($total_sf, 2, ',', '.'), ['class' => 'label label-warning']) }}</h4></th>
                            <th class="text-right"><h4>{{ Form::label('', number_format($total_pt, 2, ',', '.'), ['class' => 'label label-warning']) }}</h4></th>
                            <th class="text-right"><h4>{{ Form::label('', number_format($proc_pt_sf, 2, ',', '.') . '%', ['class' => 'label label-warning']) }}</h4></th>
                            <th class="text-right"><h4>{{ Form::label('', number_format($total_ach, 2, ',', '.'), ['class' => 'label label-warning']) }}</h4></th>
                            <th class="text-right"><h4>{{ Form::label('', number_format($proc_sf_ach, 2, ',', '.') . '%', ['class' => 'label label-warning']) }}</h4></th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </tfoot-->                        
                      </table>
                   </div>
                   <!-- /.table-responsive -->
               </div>
               <!-- /.panel-body -->
           </div>
        </div>        
    </div>
    <!-- /.row --> 
  @stop

@section('footer_scripts')
    <!-- DataTables JavaScript -->
    {{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.js') }}
    {{ HTML::script('assets/js/plugins/dataTables/dataTables.bootstrap.js') }}
    {{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.columnFilter.js') }}
    {{ HTML::script('assets/js/plugins/bootbox.js') }} 

    <script>
        $(document).ready(function() {          
            $('#dataTables-articol').dataTable({
               "columns": [
                  { "orderable": false },
                  null,
                  null,
                  null,
                  null,
                  null,
                  null,
                  null
                ],               
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'}
            });
            $("#btn_show_hide_articol").click(function(){
                $("#div_cautare_articol").toggle();             
            });   
            var table = $('#dataTables-articol').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_denumire", type: "text" }         
                ]
            });             

            $('.fa-trash-o').click(function(){
                var id = $(this).closest('tr').data('id');
                var url_delete = "{{ URL::route('aplicatie_delete') }}";
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
    </script>
@stop