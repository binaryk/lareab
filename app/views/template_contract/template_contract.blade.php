@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}
@stop

@section('title')
    <p>Template contract</p>
@stop

@section('content')

    <div class="row-expander">
        <div class="panel-group">
            @foreach($template_contract_tipizat_master as $tctm)
                <div class="panel panel-default" id="tctm_{{ $tctm->id_template }}" data-id="{{ $tctm->id_template }}" data-table="template_contract_tipizat_master">

                    <div class="panel-heading">
                        <span class="panel-title">
                            <a data-toggle="collapse" class="collapsed" style="text-decoration:none">
                                <i class="fa fa-plus-square"></i> Template:
                            </a>
                        </span>
                        
                        <a href="#" class="editable panel-title-editable" data-name="denumire" data-type="text" data-pk="{{ $tctm->id_template }}"  data-url="{{ URL::to('/template_contract/template_contract_tipizat_master/edit') }}">{{ $tctm->denumire }}</a>
                        <a style="float:right" href="#" onclick="DeleteTemplate('tctm_' + {{ $tctm->id_template }}, '{{ URL::route('template_contract_tipizat_master_delete') }}', 'id_template')"><i class="fa fa-trash-o fa-lg" title="Sterge"></i></a>

                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center"><i class="fa fa-comment"></i> Observatii</th>
                                            <th style="text-align:center"><i class=""></i> Categoria investitie</th>
                                            <th style="text-align:center"><i class=""></i> Tip contract</th>
                                        </tr>    
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><a href="#" id="observatie" class="xedit-observatii" data-placeholder="Introduceti observatii..." data-title="Observatii" data-name="observatii" data-type="textarea" data-pk="{{ $tctm->id_template }}"  data-url="{{ URL::to('/template_contract/template_contract_tipizat_master/edit') }}">{{ $tctm->observatii }}</a></td>
                                            <td><a href="#" id="categoriainvestitie" class="xedit-categoriainvestitie" data-name="id_categoria_investitie" data-type="select" data-pk="{{ $tctm->id_template }}" data-url="{{ URL::to('/template_contract/template_contract_tipizat_master/edit') }}">{{ $tctm->Categorie }}</a></td>
                                            <td><a href="#" id="tipcontract" class="xedit-tipcontract" data-name="id_tip_contract" data-type="select" data-pk="{{ $tctm->id_template }}" data-url="{{ URL::to('/template_contract/template_contract_tipizat_master/edit') }}">{{ $tctm->TipContract }}</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color:#E2E2E2">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" style="text-decoration:none">Detalii template</a>
                                            <a href="#" onclick="GetIdTemplateMaster('tctm_' + {{ $tctm->id_template }})" data-toggle="modal" data-target="#myModalTemplateDetailAdd" class="btn btn-primary btn-xs add-level" title="Adauga detalii template">Adauga</a> <!-- Adauga template detail -->
                                        </h4>
                                    </div>
                                    <div class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align:center">Activitate</th>
                                                            <th style="text-align:center">Activitate tipizata</th>
                                                            <th style="text-align:center">Livrabil</th>
                                                            <th style="text-align:center">Obligatie</th>
                                                            <th style="text-align:center">Actiuni</th>
                                                        </tr>
                                                    </thead>
                                                        <tbody>
                                                            @foreach($template_contract_tipizat_detail as $tctd)
                                                                @if($tctd->id_template_contract_tipizat_master == $tctm->id_template)
                                                                    <tr id="tctd_{{ $tctd->id_template_contract_tipizat_detail }}" data-id="{{ $tctd->id_template_contract_tipizat_detail }}" data-table="template_contract_tipizat_detail">
                                                                        <td>
                                                                            <span data-pk="{{ $tctd->id_template_contract_tipizat_detail }}" data-url="{{ URL::to('/template_contract/tip_activitate/edit') }}" data-name="denumire" class="" data-type="text">{{ $tctd->Activitate }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <span data-pk="{{ $tctd->id_template_contract_tipizat_detail }}" data-url="{{ URL::to('/template_contract/tip_activitate_tipizata/edit') }}" data-name="denumire" class="" data-type="text">{{ $tctd->ActivitateTipizata }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <span data-pk="{{ $tctd->id_template_contract_tipizat_detail }}" data-url="{{ URL::to('/template_contract/tip_livrabile/edit') }}" data-name="denumire" class="" data-type="text">{{ $tctd->Livrabil }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <span data-pk="{{ $tctd->id_template_contract_tipizat_detail }}" data-url="{{ URL::to('/template_contract/tip_obligatii_sarcini/edit') }}" data-name="denumire" class="" data-type="text">{{ $tctd->Obligatie }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <div align="center">
                                                                                <a href="#" onclick="DeleteTemplate('tctd_' + {{ $tctd->id_template_contract_tipizat_detail }}, '{{ URL::route('template_contract_tipizat_detail_delete') }}', 'id_template_contract_tipizat_detail')"><i class="fa fa-trash-o fa-lg" title="Sterge"></i></a>
                                                                                <a href="#" onclick="GetIdTemplateDetail('tctd_' + {{ $tctd->id_template_contract_tipizat_detail }})" data-toggle="modal" data-target="#myModalTemplateDetailEdit"><i class="fa fa-pencil-square-o fa-lg" title="Editeaza detalii"></i></a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach <!-- end of template detalii -->
                                                        </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
        <a href="#" data-toggle="modal" data-target="#myModalTemplateMaster" class="btn btn-primary btn-lg add-level" title="Adauga template">Adauga</a> <!-- Adauga template master -->

        <select name="categoria_investitie_select" id="categoria_investitie_select" 
          class="selectpicker form-control hidden" data-live-search="true">
              @foreach ($categoria_investitie as $cat_inv) 
                  <option value="{{ $cat_inv->id_categoria_investitie }}">{{ $cat_inv->denumire }}</option>
              @endforeach                            
        </select>

        <select name="tip_contract_select" id="tip_contract_select" 
          class="selectpicker form-control hidden" data-live-search="true">
              @foreach ($tip_contract as $tip_ctr) 
                  <option value="{{ $tip_ctr->id_tip_contract }}">{{ $tip_ctr->denumire }}</option>
              @endforeach                            
        </select>

        <div class="modal fade bs-example-modal-lg" id="myModalTemplateMaster" tabindex="-1" role="dialog" aria-labelledby="myModalLabelTemplateMaster" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header modal-info">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabelTemplateMaster">Adauga template nou</h4>
              </div>
              <div class="modal-body">
                 <form role="form" action="{{ URL::current() }}" method="post">
                    <fieldset>     
                        <div class="form-group col-lg-10                   
                            @if ($errors->has('denumire')) has-error 
                            @elseif(Input::old('denumire')) has-success 
                            @endif">
                            <label>Denumire</label>
                            <input class="form-control" name="denumire" id="DenumireTemplateMaster" type="text" value="{{ Input::old('denumire') }}" 
                            @if ($errors->has('required')) 
                                title="{{ $errors->first('required') }}" 
                            @endif>
                        </div>
                        <div class="form-group col-lg-10                   
                            @if ($errors->has('observatii')) has-error 
                            @elseif(Input::old('observatii')) has-success 
                            @endif">
                            <label>Observatii</label>
                            <input class="form-control" name="observatii" id="ObservatiiTemplateMaster" type="text" value="{{ Input::old('observatii') }}" 
                            @if ($errors->has('required')) 
                                title="{{ $errors->first('required') }}" 
                            @endif>
                        </div>
                        <div class="form-group col-lg-5
                            @if($errors->has('cat_inv')) has-error 
                            @elseif(Input::old('cat_inv')) has-success 
                            @endif ">
                            <label for = "">Categoria investitie</label>
                            <select name="cat_inv" id="cat_inv" 
                            class="selectpicker form-control" data-live-search="true">
                                @foreach ($categoria_investitie as $cat_inv) 
                                    <option value="{{ $cat_inv->id_categoria_investitie }}">{{ $cat_inv->denumire }}
                                    </option>
                                @endforeach                            
                            </select>
                        </div>
                        <div class="form-group col-lg-5
                            @if($errors->has('tip_ctr')) has-error 
                            @elseif(Input::old('tip_ctr')) has-success 
                            @endif ">
                            <label for = "">Tip contract</label>
                            <select name="tip_ctr" id="tip_ctr" 
                            class="selectpicker form-control" data-live-search="true">
                                @foreach ($tip_contract as $tip_ctr) 
                                    <option value="{{ $tip_ctr->id_tip_contract }}">{{ $tip_ctr->denumire }}
                                    </option>
                                @endforeach                            
                            </select>
                        </div>                                                                                                                                                                                                                                                                                                                                            
                    </fieldset>
                 </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="btn_click('CANCEL')">Renunta</button>
                <input type="submit" name="submit" id="submitTemplateMaster" class="btn btn-primary" value="Salveaza" onclick="btn_click('SAVE')"/>
                {{ Form::token() }}
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade bs-example-modal-lg" id="myModalTemplateDetailAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabelTemplateDetailAdd" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header modal-info">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabelTemplateDetailAdd">Adauga detalii template</h4>
              </div>
              <div class="modal-body">
                <form role="form" action="{{ URL::current() }}" method="post">
                    <fieldset>     
                        <div class="form-group col-lg-5
                            @if($errors->has('tip_act_add')) has-error 
                            @elseif(Input::old('tip_act_add')) has-success 
                            @endif ">
                            <label for = "">Activitate</label>
                            <select name="tip_act_add" id="tip_act_add" 
                            class="selectpicker form-control" data-live-search="true">
                                <option value="0">Selectioneaza activitatea...</option>
                                    @foreach ($tip_activitate as $tip_act_add)
                                        <option value="{{ $tip_act_add->id_tip_activitate }}" 
                                            @if (Input::old('tip_act_add')) selected @endif>{{ $tip_act_add->denumire }}
                                        </option> 
                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-5
                            @if($errors->has('tip_act_tip_add')) has-error 
                            @elseif(Input::old('tip_act_tip_add')) has-success 
                            @endif ">
                            <label for = "">Activitate tipizata</label>
                            <select name="tip_act_tip_add" id="tip_act_tip_add" 
                            class="selectpicker form-control" data-live-search="true">
                                <option value="0">Selectioneaza activitatea tipizata...</option>
                                    @foreach ($tip_activitate_tipizata as $tip_act_tip_add)
                                        <option value="{{ $tip_act_tip_add->id_tip_activitate_tipizata }}" 
                                            @if (Input::old('tip_act_tip_add')) selected @endif>{{ $tip_act_tip_add->denumire }}
                                        </option> 
                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-5
                            @if($errors->has('tip_liv_add')) has-error 
                            @elseif(Input::old('tip_liv_add')) has-success 
                            @endif ">
                            <label for = "">Livrabil</label>
                            <select name="tip_liv_add" id="tip_liv_add" 
                            class="selectpicker form-control" data-live-search="true">
                                <option value="0">Selectioneaza livrabilul...</option>
                                    @foreach ($tip_livrabile as $tip_liv_add)
                                        <option value="{{ $tip_liv_add->id_tip_livrabile }}" 
                                            @if (Input::old('tip_liv_add')) selected @endif>{{ $tip_liv_add->denumire }}
                                        </option> 
                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-5
                            @if($errors->has('tip_ob_sar_add')) has-error 
                            @elseif(Input::old('tip_ob_sar_add')) has-success 
                            @endif ">
                            <label for = "">Obligatie</label>
                            <select name="tip_ob_sar_add" id="tip_ob_sar_add" 
                            class="selectpicker form-control" data-live-search="true">
                                <option value="0">Selectioneaza obligatia...</option>
                                    @foreach ($tip_obligatii_sarcini as $tip_ob_sar_add)
                                        <option value="{{ $tip_ob_sar_add->id_tip_obligatie_sarcina }}" 
                                            @if (Input::old('tip_ob_sar_add')) selected @endif>{{ $tip_ob_sar_add->denumire }}
                                        </option> 
                                    @endforeach
                            </select>
                        </div>                                                                                                                                                                                                                                                                                                                                            
                    </fieldset>
                 </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="btn_click('CANCEL')">Renunta</button>
                <input type="submit" name="submit" id="submitTemplateDetailAdd" class="btn btn-primary" value="Salveaza" onclick="btn_click('SAVE')"/>
                {{ Form::token() }}
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade bs-example-modal-lg" id="myModalTemplateDetailEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabelTemplateDetailEdit" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header modal-info">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabelTemplateDetailEdit">Editeaza detalii template</h4>
              </div>
              <div class="modal-body">
                <form role="form" action="{{ URL::current() }}" method="post">
                    <fieldset>     
                        <div class="form-group col-lg-5
                            @if($errors->has('tip_act_edit')) has-error 
                            @elseif(Input::old('tip_act_edit')) has-success 
                            @endif ">
                            <label for = "">Activitate</label>
                            <select name="tip_act_edit" id="tip_act_edit" 
                            class="selectpicker form-control" data-live-search="true">
                                <option value="0">Selectioneaza activitatea...</option>
                                    @foreach ($tip_activitate as $tip_act_edit)
                                        <option value="{{ $tip_act_edit->id_tip_activitate }}" 
                                            @if (Input::old('tip_act_edit')) selected @endif>{{ $tip_act_edit->denumire }}
                                        </option> 
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-5
                            @if($errors->has('tip_act_tip_edit')) has-error 
                            @elseif(Input::old('tip_act_tip_edit')) has-success 
                            @endif ">
                            <label for = "">Activitate tipizata</label>
                            <select name="tip_act_tip_edit" id="tip_act_tip_edit" 
                            class="selectpicker form-control" data-live-search="true">
                                <option value="0">Selectioneaza activitatea tipizata...</option>
                                    @foreach ($tip_activitate_tipizata as $tip_act_tip_edit)
                                        <option value="{{ $tip_act_tip_edit->id_tip_activitate_tipizata }}" 
                                            @if (Input::old('tip_act_tip_edit')) selected @endif>{{ $tip_act_tip_edit->denumire }}
                                        </option> 
                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-5
                            @if($errors->has('tip_liv_edit')) has-error 
                            @elseif(Input::old('tip_liv_edit')) has-success 
                            @endif ">
                            <label for = "">Livrabil</label>
                            <select name="tip_liv_edit" id="tip_liv_edit" 
                            class="selectpicker form-control" data-live-search="true">
                                <option value="0">Selectioneaza livrabilul...</option>
                                    @foreach ($tip_livrabile as $tip_liv_edit)
                                        <option value="{{ $tip_liv_edit->id_tip_livrabile }}" 
                                            @if (Input::old('tip_liv_edit')) selected @endif>{{ $tip_liv_edit->denumire }}
                                        </option> 
                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-5
                            @if($errors->has('tip_ob_sar_edit')) has-error 
                            @elseif(Input::old('tip_ob_sar_edit')) has-success 
                            @endif ">
                            <label for = "">Obligatie</label>
                            <select name="tip_ob_sar_edit" id="tip_ob_sar_edit" 
                            class="selectpicker form-control" data-live-search="true">
                                <option value="0">Selectioneaza obligatia...</option>
                                    @foreach ($tip_obligatii_sarcini as $tip_ob_sar_edit)
                                        <option value="{{ $tip_ob_sar_edit->id_tip_obligatie_sarcina }}" 
                                            @if (Input::old('tip_ob_sar_edit')) selected @endif>{{ $tip_ob_sar_edit->denumire }}
                                        </option> 
                                    @endforeach
                            </select>
                        </div>                                                                                                                                                                                                                                                                                                                                            
                    </fieldset>
                 </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="btn_click('CANCEL')">Renunta</button>
                <input type="submit" name="submit" id="submitTemplateDetailEdit" class="btn btn-primary" value="Salveaza" onclick="btn_click('SAVE')"/>
                {{ Form::token() }}
              </div>
            </div>
          </div>
        </div>

    </div>
   
@stop

@section('footer_scripts')

    {{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.js') }}
    {{ HTML::script('assets/js/plugins/dataTables/dataTables.bootstrap.js') }}
    {{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.columnFilter.js') }}
    {{ HTML::script('assets/js/plugins/bootbox.js') }}

    <script>

        $(document).ready(function() {

            // Functie care face update la id-urile nivelurlior noi create pe toggle la row-expander
            function update_accordion() {
                
                var i = 0;
                $('.row-expander .panel-title a').each(function() {
                    $(this).closest('.panel-heading').next().attr('id', 'collapse_'+(++i));
                    $(this).attr('href', '#collapse_'+(i));
                });
            }
            
            update_accordion();

            // Schimba plus cu minus pe iconita de toggle
            $("body").on('click', ".panel-title a", function() {
                
                $(this).find('i').toggleClass('fa-plus-square fa-minus-square');
            });

            // Initializarea plugin-ului x-editable
            $.fn.editable.defaults.mode = 'inline';

            $('a.xedit-observatii').css('cursor','pointer').editable('option', 'validate', function(v) {              
                if(!v) return 'Camp obligatoriu!';
            });

            // Parcurge dropdown-ul hidden cu categoriile de investitie si le incarca intr-un array
            var categoria_investitie = [];            
            $('#categoria_investitie_select option').each(function(k,v) { 
                var obj = {};               
                obj.value = v.value;
                obj.text = v.text;
                categoria_investitie.push(obj);
            });

            //console.log(categoria_investitie);
            $('a.xedit-categoriainvestitie').css('cursor','pointer').editable({
                type: 'select',
                title: 'Categoria investitie',
                placement: 'right',
                source: categoria_investitie
            });

            // Parcurge dropdown-ul hidden cu tipurile de contract si le incarca intr-un array
            var tip_contract = [];            
            $('#tip_contract_select option').each(function(k,v) { 
                var obj = {};               
                obj.value = v.value;
                obj.text = v.text;
                tip_contract.push(obj);
            });

            //console.log(tip_contract);
            $('a.xedit-tipcontract').css('cursor','pointer').editable({
                type: 'select',
                title: 'Tip contract',
                placement: 'right',
                source: tip_contract
            });

            var deps = [];
            
            function init_editable() {

                parent = '.row-expander';
                $('.editable, .description, .score', parent).editable();

                $('.xedit-observatii').editable({
                    showbuttons: 'bottom'
                });

                $('.parent', parent).editable({
                    source: deps,
                    select2: {
                        width: 300,
                        firstItem: 'none'
                    }
                });

            }
            init_editable();

        });
        
        // Stergerea oricarui camp
        function DeleteTemplate(id, url_delete, id_name) {             
            
            var id_str = id.substring(5);
            var id_nr = parseInt(id_str);

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
                
                callback: function(result) {
                    if(result) {
                        $.ajax({
                            type: "POST",
                            url : url_delete,
                            data : {
                                "_token": $(this).find('input[name=_token]').val(),
                                id_name : id_nr
                            },
                            success : function(data){
                                $('#'+id).fadeOut();
                            }
                        });
                    }
                }

            });
        }

        // Initializare pop-up modal
        var btnModal; 
        function btn_click(msg) {
            btnModal = msg;
        }
        
        $("#submitTemplateMaster").click(function() {
          $("#myModalTemplateMaster").modal("hide");  
        });

        $("#submitTemplateDetailAdd").click(function() {
          $("#myModalTemplateDetailAdd").modal("hide");  
        });

        $("#submitTemplateDetailEdit").click(function() {
          $("#myModalTemplateDetailEdit").modal("hide");  
        });

        //Functii pentru preluarea id-urilor principale
        function GetIdTemplateMaster(id) {

            id_str_tctm = id.substring(5);
            id_template_master = parseInt(id_str_tctm);
        }

        function GetIdTemplateDetail(id) {

            id_str_tctd = id.substring(5);
            id_template_detail = parseInt(id_str_tctd);
        }

        //jQuery pentru activarea si folosirea pop-urilor modal pentru adaugare inregistrari noi
        $("#myModalTemplateMaster").on('hide.bs.modal', function(e) {
            
            console.error(e.target);
            console.error("MDL" + btnModal);
            if (btnModal === 'SAVE') {
                
                var denumire = $('#DenumireTemplateMaster').val();
                var observatii = $('#ObservatiiTemplateMaster').val();
                var cat_inv = $('#cat_inv').val();
                var tip_ctr = $('#tip_ctr').val();   
                var url_add = "{{ URL::route('template_master_add') }}";

                var parametrii = [];
                parametrii.push(denumire);
                parametrii.push(observatii);
                parametrii.push(cat_inv);
                parametrii.push(tip_ctr);


                var stringed = JSON.stringify(parametrii);
                //var id = $(this).closest('tr').data('id');
                //console.error(stringed);
                $.ajax({
                    url: url_add,
                    type: 'POST',
                    data : { 
                        "parametrii": stringed
                    },
                    success: function(data) {
                      
                      if (typeof data === 'object') {
                          
                          if (data.status === "OK") {
                              
                              var ruta = "{{ URL::route('template_contract') }}";
                              MessageBox("SUCCESS", "Template", data.message);
                              window.setTimeout(function(){location.reload()},2000);
                          }
                          else
                              MessageBox("ERROR", "Template", data.message);
                      }
                      else
                          MessageBox("ERROR", "Server", "Eroare de server SCS");               
                    },
                    error:function(){
                        MessageBox("ERROR", "Server", "Eroare de server ERR");
                    }
                })
            }
        });

        $("#myModalTemplateDetailAdd").on('hide.bs.modal', function(e) {
            
            console.error(e.target);
            console.error("MDL" + btnModal);
            if (btnModal === 'SAVE') {
                
                var act = $('#tip_act_add').val();
                var act_tip = $('#tip_act_tip_add').val();
                var liv = $('#tip_liv_add').val();
                var obl = $('#tip_ob_sar_add').val();   
                var url_add = "{{ URL::route('template_detail_add') }}";

                var parametrii = [];
                parametrii.push(act);
                parametrii.push(act_tip);
                parametrii.push(liv);
                parametrii.push(obl);

                parametrii.push(id_template_master);


                var stringed = JSON.stringify(parametrii);
                //var id = $(this).closest('tr').data('id');
                //console.error(stringed);
                $.ajax({
                    url: url_add,
                    type: 'POST',
                    data : { 
                        "parametrii": stringed
                    },
                    success: function(data) {
                      
                      if (typeof data === 'object') {
                          
                          if (data.status === "OK") {
                              
                              var ruta = "{{ URL::route('template_contract', '_idtm_') }}";
                              ruta = ruta.replace("'_idtm_'", parseInt(id_template_master));
                              MessageBox("SUCCESS", "Detalii template", data.message);
                              window.setTimeout(function(){location.reload()},2000);
                          }
                          else
                              MessageBox("ERROR", "Detalii template", data.message);
                      }
                      else
                          MessageBox("ERROR", "Server", "Eroare de server SCS");               
                    },
                    error:function(){
                        MessageBox("ERROR", "Server", "Eroare de server ERR");
                    }
                })
            }
        });

        $("#myModalTemplateDetailEdit").on('hide.bs.modal', function(e) {
            
            console.error(e.target);
            console.error("MDL" + btnModal);
            if (btnModal === 'SAVE') {
                
                var act = $('#tip_act_edit').val();
                var act_tip = $('#tip_act_tip_edit').val();
                var liv = $('#tip_liv_edit').val();
                var obl = $('#tip_ob_sar_edit').val();   
                var url_edit = "{{ URL::route('template_detail_edit') }}";

                var parametrii = [];
                parametrii.push(act);
                parametrii.push(act_tip);
                parametrii.push(liv);
                parametrii.push(obl);

                parametrii.push(id_template_detail);


                var stringed = JSON.stringify(parametrii);
                //var id = $(this).closest('tr').data('id');
                //console.error(stringed);
                $.ajax({
                    url: url_edit,
                    type: 'POST',
                    data : { 
                        "parametrii": stringed
                    },
                    success: function(data) {
                      
                      if (typeof data === 'object') {
                          
                          if (data.status === "OK") {
                              
                              var ruta = "{{ URL::route('template_contract') }}";
                              MessageBox("SUCCESS", "Editare detalii template", data.message);
                              window.setTimeout(function(){location.reload()},2000);
                          }
                          else
                              MessageBox("ERROR", "Editare detalii template", data.message);
                      }
                      else
                          MessageBox("ERROR", "Server", "Eroare de server SCS");               
                    },
                    error:function(){
                        MessageBox("ERROR", "Server", "Eroare de server ERR");
                    }
                })
            }
        });

    </script>
    
@stop