@extends('layouts.master')
@section('head_scripts')
    <!-- DataTables CSS -->
    <style type="text/css">
      #dataTables-livrabile tbody tr{
        cursor: pointer;
      }
    </style>
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}
    {{ HTML::style('assets/css/plugins/jquery.dataTables.css') }}
@stop

@section('title')
  Lista livrabile nefacturate furnizor
@stop

@section('content')
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
            <td width="20%">
              <label class="control-label">Denumire livrabil</label>
            </td>
            <td width="80%">
              <p id="_col_denumire_livrabil"></p>
            </td>
          </tr>
          <tr>
            <td width="20%">
              <label class="control-label">Contract</label>
            </td>
            <td width="80%">
              <p id="_col_contract"></p>
            </td>
          </tr>
          <tr>
            <td width="20%">
              <label class="control-label">Obiectiv</label>
            </td>
            <td width="80%">
              <p id="_col_obiectiv"></p>
            </td>
          </tr>
          <tr>
            <td width="20%">
              <label class="control-label">Etapa</label>
            </td>
            <td width="80%">
              <p id="_col_etapa"></p>
            </td>
          </tr>
          <tr>
            <td width="20%">
              <label class="control-label">Stadiu</label>
            </td>
            <td width="80%">
              <p id="_col_stadiu"></p>
            </td>
          </tr>
          <tr>
            <td width="20%">
              <label class="control-label">Data limita predare</label>
            </td>
            <td width="80%">
              <p id="_col_data_limita_predare"></p>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        Lista livrabile nefacturate
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <div class="form-group">                        
          </div>
          <table class="table   table-bordered " id="dataTables-livrabile">
            <thead>
              <tr>
                <th>Denumire livrabil</th>
                <th>Contract</th>
                <th>Obiectiv</th>
                <th>Etapa</th>
                <th>Stadiu</th>
                <th>Data limita predare</th>
                <th>Pret fara TVA</th>
                <th class="hidden"></th>
                <th class="hidden"></th>
                <th class="hidden"></th>                
                <th class="hidden"></th>
              </tr>
            </thead>
            <tfoot>
              <tr>                
                <th>Denumire livrabil</th>
                <th>Contract</th>
                <th>Obiectiv</th>
                <th>Etapa</th>
                <th>Stadiu</th>
                <th>Data limita predare</th>
                <th>Pret fara TVA</th>
                <th class="hidden"></th>
                <th class="hidden"></th>
                <th class="hidden"></th>
                <th class="hidden"></th>
              </tr>
            </tfoot>
            <tbody>
              @foreach ($livrabile as $livrabil)
              <tr data-id="{{ $livrabil->id_livrabil_pentru_facturat }}">                
                <td>{{ $livrabil->livrabil }}</td>
                <td>{{ $livrabil->contract }}</td>
                <td><a href="{{ URL::route('obiectiv_single', $livrabil->id_obiectiv) }}">{{ $livrabil->obiectiv }}</a></td>
                <td class="text-center">{{ $livrabil->nr_etapa }}</td>
                <td class="text-center"><a href="{{ URL::to('stadiu_livrabil/'.$livrabil->id_livrabil_pentru_facturat) }}">{{ $livrabil->stadiu }}</td>
                <td class="text-center">{{ $livrabil->data_limita }}</td>
                <td class="text-right">{{ number_format($livrabil->pret_fara_tva, 2, ',', '.') }}</td>
                <td class="hidden">{{ $livrabil->tva }}</td>
                <td class="hidden">{{ $livrabil->id_entitatea_mea }}</td>
                <td class="hidden">{{ $livrabil->id_partener }}</td>
                <td class="hidden">{{ $livrabil->id_contract }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div align="right" class="alert alert-warning">
            <table width="100%">
              <tbody>
                <tr>
                  <td width="90%" align="right">
                    <h5 style="margin-top:6px;" class="media-heading">Total fara TVA:</h5>
                  </td>
                  <td width="10%" align="right"><span class="media-heading" id="total_fara_tva_factura">0,00</span></td>
                </tr>
                <tr>
                  <td width="90%" align="right">
                    <h5 style="margin-top:6px;" class="media-heading">Valoare TVA:</h5>
                  </td>
                  <td width="10%" align="right"><span class="media-heading" id="valoare_tva_factura">0,00</span></td>
                </tr>
                <tr>
                  <td width="90%" align="right">
                    <h5 style="font-weight:bold;margin-top:6px;" class="media-heading">Total cu TVA:</h5>
                  </td>
                  <td width="10%" align="right"><span style="font-weight:bold;" class="media-heading" id="total_cu_tva_factura">0,00</span></td>
                </tr>                
                <tr>
                  <table width="25%">
                    <tr>
                        <h5 style="margin-top:20px" class="media-heading linie-orizontala">Serie si numar factura (se introduc din factura furnizorului)</h5>
                    </tr>
                    <tr>
                      <td align="right">
                        <h5 style="font-weight:bold;margin-top:6px;" class="media-heading">Serie:&nbsp&nbsp</h5>
                      </td>                                          
                      <td width="100px" align="left">                    
                        <input class="form-control text-right text-uppercase" name="serie_facturare" id="serie_facturare"/>
                      </td>
                      <td align="right">
                        <h5 style="font-weight:bold;margin-top:6px;" class="media-heading">Numar:&nbsp&nbsp</h5>
                      </td>                                          
                      <td width="100px" align="left">                    
                        <input class="form-control text-right" name="numar_facturare" id="numar_facturare"/>
                      </td>
                    </tr>                                  
                  </table>   
                </tr>               
              </tbody>
            </table>
          </div>
          <div class="form-group col-lg-12 text-center">               
            <input type="button" name="genereaza_desfasurator" id="genereaza_desfasurator" class="btn btn-primary btn-lg disabled" value="Genereaza desfasurator" />              
            {{ Form::token() }}                    
          </div>           
        </div>
        <!-- /.table-responsive -->
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
{{ HTML::script('assets/js/plugins/dataTables/dataTables.tableTools.js') }}
{{ HTML::script('assets/js/plugins/dataTables/dataTables.bootstrap.js') }}
{{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.columnFilter.js') }}
{{ HTML::script('assets/js/plugins/bootbox.js') }}
{{ HTML::script('assets/serii_facturare.js') }}
<script>
  $(document).ready(function() 
  {     
      var selected = [];     
      var total_fara_tva = 0;
      var valoare_tva_factura = 0;
      var total_cu_tva = 0;
      var tva = 0;
      var id_beneficiar = 0;
      var id_furnizor = 0;
      var id_serie_facturare = 0;
      var serie_fac = "";
      var numar_fac = 0;
      var contract = "";
      var id_contract = 0;

      $('#dataTables-livrabile').dataTable({          
          "language": {                
              "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'},
              "oTableTools": {
                "sSwfPath": "../public/swf/copy_csv_xls_pdf.swf",
                "sRowSelect": "multi"
              }
      });

      $(document).on('click','#dataTables-livrabile tbody tr', function () {
          var id = $(this).data('id');                
          var index = $.inArray(id, selected);
          if (index === -1) 
          {
              if ((contract == "") || (contract === $(this).find('td:nth-child(2)').text()))
              {
                  $(this).addClass('selected');
                  selected.push( id );
                  total_fara_tva += parseFloat($(this).find('td:nth-child(7)').text().replace('.', '').replace(',','.'));
                  valoare_tva_factura += parseFloat($(this).find('td:nth-child(8)').text());
                  if (contract === "")
                  {
                      tva = $(this).find('td:nth-child(8)').text().replace('.', '').replace(',','.');
                      id_beneficiar = $(this).find('td:nth-child(9)').text();
                      id_furnizor = $(this).find('td:nth-child(10)').text();
                      id_contract = $(this).find('td:nth-child(11)').text();

                      contract = $(this).find('td:nth-child(2)').text();
                      //$(this).loadSerii(1);
                  }
              }
              else 
                  MessageBox("WARNING", "Selectie...", "Nu se pot factura livrabile din contracte diferite...");              
            } else { 
              $(this).removeClass('selected');
              selected.splice( index, 1 );
              total_fara_tva -= parseFloat($(this).find('td:nth-child(7)').text().replace('.', '').replace(',','.'));
              valoare_tva_factura -= parseFloat($(this).find('td:nth-child(8)').text());
              
              if (selected.length === 0) 
              {
                  contract = "";
                  id_beneficiar = 0;
                  id_furnizor = 0;
                  tva = 0;
                  id_contract = 0;
              }
          }
          total_cu_tva_factura =  total_fara_tva + valoare_tva_factura;
          $('#total_fara_tva_factura').text(formato_numero(total_fara_tva.toString(), 2, ',', '.'));
          $('#valoare_tva_factura').text(formato_numero(valoare_tva_factura.toString(), 2, ',', '.'));
          $('#total_cu_tva_factura').text(formato_numero(total_cu_tva_factura.toString(), 2, ',', '.'));          
          
          if (total_fara_tva > 0)
              $('#genereaza_desfasurator').removeClass("disabled");
          else
              $('#genereaza_desfasurator').addClass("disabled");
      });

      $("#btn_show_hide").click(function()
      {
          $("#div_cautare").toggle();          
      });
      var table = $('#dataTables-livrabile').dataTable().columnFilter({
        aoColumns: [ 
            { sSelector: "#_col_denumire_livrabil", type: "text" },             
            { sSelector: "#_col_contract", type: "text" },             
            { sSelector: "#_col_obiectiv", type: "text" },             
            { sSelector: "#_col_etapa", type: "number" },
            { sSelector: "#_col_stadiu", type: "text" },
            { sSelector: "#_col_data_limita_predare", type: "date" },          
          ]
      });        
  
  
      $('#genereaza_desfasurator').click(function(){          
          var url_generare = "{{ URL::route('genereaza_desfasurator_furnizor') }}";
          var date_facturare = [];
          date_facturare.push(selected);
          date_facturare.push(id_beneficiar);
          date_facturare.push(id_furnizor);
          date_facturare.push($('#serie_facturare').val());
          date_facturare.push($('#numar_facturare').val());
          date_facturare.push(tva);  
          date_facturare.push(id_contract);
          
          var stringed = JSON.stringify(date_facturare);
          console.error(stringed);
                    
          bootbox.confirm({
              title: "Desfasurator ...",
              message: "Doriti sa generati desfasuratorul facturii?",
              buttons: {
                  'confirm': {
                      label: "Da, genereaza!",
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
                          url : url_generare,
                          data : {
                              "_token": $(this).find('input[name=_token]').val(),
                              "date_facturare": stringed
                          },
                          success : function(data){
                              console.log(data);
                              if (typeof data === 'object')
                              {
                                  if (data.status === "OK")
                                  {
                                      MessageBox("SUCCESS", "Facturare", data.message);                        
                                      window.location.href = "{{ URL::route('livrabile_nefacturate_furnizor') }}";
                                  }
                                  else
                                      MessageBox("ERROR", "Facturare", data.message);
                              }
                              else
                                  MessageBox("ERROR", "Server", "Eroare de server");
                          },
                          error: function(par1, par2, par3){
                              console.log('Error: ');
                              console.log(par1);
                              console.log('Error: ');
                              console.log(par2);
                              console.log('Error: ');
                              console.log(par3);
                          },
                          fail: function(data){
                              console.log('fail');
                              console.log(data);
                          }                            
                      });
                  }
              }
          });
      });

      $(function() {
          $.ajaxSetup({
              headers: {
                  'X-CSRF-Token': $('meta[name="_token"]').attr('content')
              }
          });
      });
  });

</script>
@stop