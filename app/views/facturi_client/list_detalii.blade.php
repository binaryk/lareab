@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}
@stop

<!-- Acesta este documentul ce va merge la client in concept de factura
     Va fi un grid editabil unde se vor putea introduce articole, cantitati, preturi
     De asemenea se va afisa un aviz daca totatul acestei facturi difera de 
     totalul desfasurastorului (adica a livrabilelor facturate)-->

@section('title')
    <p>Detalii factura
        @if(isset($factura->serie)) {{ $factura->serie . '/' . $factura->numar }} din data {{ $factura->data_facturare }} @endif
    </p>
    <input type="hidden" id="id_factura" name="id_factura" value="{{ $factura->id_factura }}" />   
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
                            <td width="25%">
                                <label class="control-label">Nr.Crt.</label></td>
                            <td width="75%"><p id="_col_nr_crt"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Denumire</label></td>
                            <td width="75%"><p id="_col_denumire"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">UM</label></td>
                            <td width="75%"><p id="_col_um"></p></td>
                        </tr>
                        <tr>
                            <td width="25%">
                                <label class="control-label">Cantitate</label></td>
                            <td width="75%"><p id="_col_cantitate"></p></td>
                        </tr>                     
                        <tr>
                            <td width="25%">
                                <label class="control-label">Pret unitar</label></td>
                            <td width="75%"><p id="_col_pret_unitar"></p></td>
                        </tr>                     
                    </table>
                </div>                        
            </div>        
            <div class="panel panel-default">
               <div class="panel-heading">
                    Detalii factura client
                    <div class="pull-right">                      
                        <a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left fa-fw"></i> Inapoi</a>                      
                        <a href="#" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle fa-fw"></i> Nou</a>
                    </div>
               </div>
               <div class="panel-body">
                   <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-detalii">
                        <thead>
                          <tr>                                   
                            <th class="text-center">Nr.Crt.</th>                      
                            <th class="text-center">Denumire</th>
                            <th class="text-center">UM</th>
                            <th class="text-center">Cantitate</th>
                            <th class="text-center">Pret unitar</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>                                                               
                            <th class="text-center">Nr.Crt.</th>                      
                            <th class="text-center">Denumire</th>
                            <th class="text-center">UM</th>
                            <th class="text-center">Cantitate</th>
                            <th class="text-center">Pret unitar</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Actiuni</th>
                          </tr>
                        </tfoot>
                        <tbody>                             
                          @foreach ($detalii as $detaliu)
                            <tr data-id="{{ $detaliu->id_det_fact }}">                              
                              <td class="text-center">
                                  <span class="xedit-nr_ordine" 
                                      id="nr_ordine"
                                      data-pk="{{ $detaliu->id_det_fact }}"
                                      data-name="nr_ordine"
                                      data-type="text"
                                      data-url="{{ URL::route('factura_client_detaliu_edit') }}">{{ $detaliu->nr_ordine }}
                                  </span>
                              </td>
                              <td class="text-left">
                                  <span class="xedit-denumire_produs"
                                      id="denumire_produs"
                                      data-pk="{{ $detaliu->id_det_fact }}"
                                      data-name="denumire"
                                      data-type="text"
                                      data-url="{{ URL::route('factura_client_detaliu_edit') }}">{{ $detaliu->denumire_produs }}                                      
                                  </span>
                              </td>                                                            
                              <td class="text-center">
                                  <span class="xedit-um"                                                                             
                                      id="um"
                                      data-pk="{{ $detaliu->id_det_fact }}"
                                      data-name="id_um"
                                      
                                      data-url="{{ URL::route('factura_client_detaliu_edit') }}">{{ $detaliu->um }}
                                  </span>
                              </td>
                              <td class="text-right">
                                  <span class="xedit-cantitate" 
                                      data-a-dec="," data-a-sep="."                                      
                                      id="cantitate"
                                      data-pk="{{ $detaliu->id_det_fact }}"
                                      data-name="cantitate"
                                      data-type="text"
                                      data-url="{{ URL::route('factura_client_detaliu_edit') }}">{{ number_format($detaliu->cantitate, 2, ',', '.') }}                                      
                                  </span>
                              </td>                                                            
                              <td class="text-right">
                                  <span class="xedit-pret_unitar" 
                                      data-a-dec="," data-a-sep="."                                      
                                      id="pret_unitar"
                                      data-pk="{{ $detaliu->id_det_fact }}"
                                      data-name="pret_unitar"
                                      data-type="text"
                                      data-url="{{ URL::route('factura_client_detaliu_edit') }}">{{ number_format($detaliu->pret_unitar, 2, ',', '.') }}
                                  </span></td>
                              <td class="text-right">{{ number_format($detaliu->pret_unitar * $detaliu->cantitate, 2, ',', '.') }}</td>
                              <td class="center action-buttons">                             
                                <a href="#"><i class="fa fa-trash-o" title="Sterge"></i></a>                                                             
                              </td>                              
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
                                <h5 style="margin-top:6px;" class="media-heading">(%) Procent TVA:</h5>
                              </td>
                              <td width="10%" align="right"><span class="media-heading" id="procent_tva">{{ number_format($factura->tva, 2, ',', '.') }}</span></td>
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
                              <td width="90%" align="right">
                                <h5 style="font-weight:bold;margin-top:6px;" class="media-heading">Total desfasurator:</h5>
                              </td>
                              <td width="10%" align="right"><span style="font-weight:bold;" class="media-heading" id="valoare_desfasurator">{{ number_format($total_defasurator->valoare, 2, ',', '.') }}</span></td>
                            </tr>                            
                            <tr>
                              <td align="center" colspan="2">
                                <small class="label label-danger" id="diferenta" style="display: inline;"><i class="fa fa-warning"></i> Diferenta intre desfasurator si factura</small>      
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <select name="um_select" id="um_select" 
                          class="selectpicker form-control hidden" data-live-search="true">
                              @foreach ($ums as $um) 
                                  <option value="{{ $um->id_um }}">{{ $um->denumire }}</option>
                              @endforeach                            
                        </select>

                      </div>

                      <div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header modal-info">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title" id="myModalLabel">Adauda linie factura {{$factura->serie . '/' . $factura->numar . ' din data ' . $factura->data_facturare }}</h4>
                            </div>
                            <div class="modal-body">
                               <form role="form" action="{{ URL::current() }}" method="post">
                                  <fieldset> 
                                      <div class="form-group col-lg-4                    
                                          @if ($errors->has('nr_ordine')) has-error 
                                          @elseif(Input::old('nr_ordine')) has-success 
                                          @endif">
                                          <label class="text-center">Numar de ordine</label>
                                          <input class="form-control" name="nr_ordine" id="nr_ordine" type="text" value="{{ Input::old('nr_ordine') }}" 
                                          @if ($errors->has('required')) 
                                              title="{{ $errors->first('required') }}" 
                                          @endif>
                                      </div>     
                                      <div class="form-group col-lg-8                   
                                          @if ($errors->has('denumire')) has-error 
                                          @elseif(Input::old('denumire')) has-success 
                                          @endif">
                                          <label>Denumire</label>
                                          <input class="form-control" name="denumire" id="denumire" type="text" value="{{ Input::old('denumire') }}" 
                                          @if ($errors->has('required')) 
                                              title="{{ $errors->first('required') }}" 
                                          @endif>
                                      </div>                                                                 
                                      <div class="form-group col-lg-4                    
                                          @if ($errors->has('cantitate')) has-error 
                                          @elseif(Input::old('cantitate')) has-success 
                                          @endif">
                                          <label>Cantitate</label>
                                          <input id="cantitate" class="form-control auto text-right" type="text" data-a-dec="," data-a-sep="." value="{{ Input::old('cantitate') }}" 
                                          @if ($errors->has('required')) 
                                              title="{{ $errors->first('required') }}" 
                                          @endif>
                                      </div>       
                                      <div class="form-group col-lg-4
                                          @if($errors->has('um')) has-error 
                                          @elseif(Input::old('um')) has-success 
                                          @endif ">
                                          <label for = "">UM</label>
                                          <select name="um" id="um" 
                                          class="selectpicker form-control" data-live-search="true">
                                              @foreach ($ums as $um) 
                                                  <option value="{{ $um->id_um }}">{{ $um->denumire }}
                                                  </option>
                                              @endforeach                            
                                          </select>
                                      </div>                                                                                                                                                                                                                                                                    
                                      <div class="form-group col-lg-4                    
                                          @if ($errors->has('pret_unitar')) has-error 
                                          @elseif(Input::old('pret_unitar')) has-success 
                                          @endif">
                                          <label>Pret unitar</label>
                                          <input id="pret_unitar" class="form-control auto text-right" type="text" data-a-dec="," data-a-sep="." value="{{ Input::old('pret_unitar') }}"
                                          @if ($errors->has('required')) 
                                              title="{{ $errors->first('required') }}" 
                                          @endif>
                                      </div>                                                                                                                                                                                                                                                                         
                                  </fieldset>
                               </form>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal" onclick="btn_click('CANCEL')">Renunta</button>
                              <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Salveaza" onclick="btn_click('SAVE')"/>
                            </div>
                          </div>
                        </div>
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
    {{ HTML::script('assets/js/plugins/dataTables/dataTables.bootstrap.js') }}
    {{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.columnFilter.js') }}
    {{ HTML::script('assets/js/plugins/bootbox.js') }} 

    <script>
        $(document).ready(function() {  
            $('#dataTables-detalii').dataTable({
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 0, 2 ] }
                ],                                
                "language": {                
                    "url": '{{ URL::to("assets/js/plugins/dataTables/lang_json/romanian.json") }}'},
                "order": [[0,"desc"]]
            });
            $("#btn_show_hide").click(function(){
                $("#div_cautare").toggle();             
            });   
            var table = $('#dataTables-detalii').dataTable().columnFilter({
              aoColumns: [ 
                  { sSelector: "#_col_nr_crt", type: "text" },
                  { sSelector: "#_col_denumire", type: "text" },
                  { sSelector: "#_col_um", type: "text" },             
                  { sSelector: "#_col_cantitate", type: "text" },                                         
                  { sSelector: "#_col_pret_unitar", type: "text" },
                ]
            });                   
            $.fn.editable.defaults.mode = 'inline';
       
            //Parcurge dropdown-ul hidden cu unitatile de masura si le incarca intr-un array
            var unitati_masura = [];            
            $('#um_select option').each(function(k,v) { 
                var obj = {};               
                obj.value = v.value;
                obj.text = v.text;
                unitati_masura.push(obj);
            });

            //console.log(unitati_masura);
            $('span.xedit-um').css('cursor','pointer').editable({
                type: 'select',
                title: 'Unitatea de masura',
                placement: 'right',
                source: unitati_masura
            });

            $('span.xedit-nr_ordine').css('cursor','pointer').editable('option', 'validate', function(v) {
                if (v !== parseInt(v, 10).toString()) return 'Doar valoare intreaga.';
                if(!v) return 'Camp obligatoriu!';
            });
            $('span.xedit-denumire_produs').css('cursor','pointer').editable('option', 'validate', function(v) {              
                if(!v) return 'Camp obligatoriu!';
            });
            $('span.xedit-cantitate').css('cursor','pointer').editable('option', 'validate', function(v) {              
                if(!v) return 'Camp obligatoriu!';
                var error = "";
                try{
                    var tmp = text_2_number(v);
                    if (isNaN(tmp)) error = 'Numar valid 1.234,56';
                }catch(e){                  
                    error = 'Numar valid 1.234,56';
                }
                if (error !== "") return error;
            });

            $('span.xedit-pret_unitar').css('cursor','pointer').editable('option', 'validate', function(v) {              
                if(!v) 
                    return 'Camp obligatoriu!';
                else if (v.startsWith('-'))
                    return 'Doar numere pozitive';
                var error = "";
                try{
                    var tmp = text_2_number(v);
                    if (isNaN(tmp)) error = 'Numar valid 1.234,56';
                }catch(e){                  
                    error = 'Numar valid 1.234,56';
                }
                if (error !== "") return error;
            });

                       
            
            calculeaza_total();
            $('.fa-trash-o').click(function(){
                var id = $(this).closest('tr').data('id'); 
                var url_delete = "{{ URL::route('factura_client_detaliu_delete') }}";               
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
                                    "id_det_fact": id
                                },
                                success : function(data){
                                    $('tr[data-id='+id+']').fadeOut();
                                    MessageBox('SUCCESS', 'Stergere', 'Inregistrare stearsa cu succes!');
                                }
                            });
                        }
                    }
                });
            });
        });

        $("#submit").click(function() {
          $("#myModal").modal("hide");  
        });

        $('#myModal').on('shown.bs.modal', function () {
          $('#nr_ordine').focus()
        })
        $("#myModal").on('hide.bs.modal', function(e) {
            //console.error(e.target);
            //console.error("MDL" + btnModal);
            if (btnModal === 'SAVE')
            {
                var id_factura = $('#id_factura').val(); 
                var denumire = $('#denumire').val();   
                var nr_ordine = $('#nr_ordine').val();
                var cantitate = $('#cantitate').val();
                var pret_unitar = $('#pret_unitar').val(); 
                var um = $('#um').val();
                var url_add = "{{ URL::route('factura_client_detaliu_add') }}";

                var parametri = [];
                parametri.push(id_factura);
                parametri.push(denumire);
                parametri.push(nr_ordine);
                parametri.push(cantitate);
                parametri.push(pret_unitar);
                parametri.push(um);

                var stringed = JSON.stringify(parametri);
                var id = $(this).closest('tr').data('id');
                //console.error(stringed);
                $.ajax({
                    url: url_add,
                    type: 'POST',
                    data : { 
                        "parametri": stringed
                    },
                    success: function(data){
                      if (typeof data === 'object')
                      {
                          if (data.status === "OK")                      
                          {
                              var ruta = "{{ URL::route('detalii_factura_client', '_idf_') }}";
                              ruta = ruta.replace("'_idf_'", parseInt(id_factura));
                              MessageBox("SUCCESS", "Facturare", data.message);
                              $('tr[data-id='+id+']').fadeOut();
                                  //window.location.href = ruta;
                          }
                          else
                              MessageBox("ERROR", "Facturare", data.message);
                      }
                      else
                          MessageBox("ERROR", "Server", "Eroare de server SCS");
                      calculeaza_total();                
                    },
                    error:function(){
                        MessageBox("ERROR", "Server", "Eroare de server ERR");
                    }
                })
            }
        });
                  
        var calculeaza_total = function() {
            var total_fara_tva = 0;
            var valoare_tva_factura = 0;
            var total_cu_tva_factura = 0;
            var procent_tva = text_2_number($("#procent_tva").text());
            var valoare_desfasurator = text_2_number($("#valoare_desfasurator").text()); 
            
            var rows = $("#dataTables-detalii").dataTable().fnGetNodes();
            for(var i = 0; i < rows.length; i++)
            {
                var tmp = $(rows[i]).find("td:eq(5)").html();                
                try{    
                console.log(i+ ':'+tmp);              
                  tmp = text_2_number(tmp);
                  total_fara_tva += tmp;   
                  console.log(i+ ':'+tmp);           
                }
                catch (err){}                
            }            
            valoare_tva_factura = total_fara_tva * procent_tva / 100.0;
            total_cu_tva_factura = total_fara_tva + valoare_tva_factura;

            $('#total_fara_tva_factura').text(formato_numero(total_fara_tva.toString(), 2, ',', '.'));
            $('#valoare_tva_factura').text(formato_numero(valoare_tva_factura.toString(), 2, ',', '.'));
            $('#total_cu_tva_factura').text(formato_numero(total_cu_tva_factura.toString(), 2, ',', '.'));          
            //console.log(total_fara_tva + '>' + typeof total_fara_tva);
            //console.log(valoare_desfasurator + '>' + typeof valoare_desfasurator);
            if (total_fara_tva === valoare_desfasurator)
            {
                $("#diferenta").hide();
            }
            else
            {
                $("#diferenta").show();  
            }
            return total_fara_tva;
        }

        var date_modif = new HashTable();


        $('[title]:not([data-placement])').tooltip({'placement': 'top'});
    </script>
@stop