@extends('layouts.master')

@section('head_scripts')
    <!-- DataTables CSS -->
    {{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}
    {{ HTML::style('assets/css/tabs.css') }}
@stop

@section('title')
    <p>
    	Date template contract    	
        <a href="#" data-toggle="modal" data-target="#myModalTipContract" class="btn btn-primary add-level" title="Adauga tip contract">Adauga tip contract</a> <!-- Adauga tip contract -->
    </p>
@stop

@section('content')
	<!-- Mevoro edit -->
	<style>
        .panel {
            border-width:0;
            margin-bottom:5px;
            box-shadow:none;
        }
        
        .panel-warning {
            border-width:0;
            margin:0 0 3px 15px;
            box-shadow:none;
        }
        
        .panel-info {
            border-width:0;
            margin:0 0 1px 30px;
            box-shadow:none;
        }
        
        .panel-body {
            padding:10px 0;
        }
        
        .min_width {
            width:1%;
        }
        
        .mev_hiden {
            display:none;	
        }
        
        .mev_pointer {
            cursor:pointer;
        }
		
		.mev_current_box {
			border:2px solid #D9EDF7;
			border-top:0;
			border-bottom-width:4px;
			margin-bottom:5px;
		}
    </style>
    <!-- Mevoro edit -->
	<div class="row-expander">
    	<!-- Tipuri contract -->
    	@foreach($tip_contract as $tip_ctr)
        	<!-- Tip contract -->
    		<div class="panel panel-success" id="tip_ctr_{{ $tip_ctr->id }}" data-id="{{ $tip_ctr->id }}" data-table="tip_contract">
                <div class="panel-heading">
                    <span class="mev_pointer" onclick="show_hide_element(this, '.tip_contract_{{ $tip_ctr -> id }}');return false;">
                        <i class="fa fa-plus-square"></i> Tip Contract:
                    </span>
                    
                    <a href="#" id="denumire_tipcontract" class="xedit-denumire_tipcontract" data-name="denumire" data-type="text" data-pk="{{ $tip_ctr->id }}"  data-url="{{ URL::to('/date_template_contract/tip_contract/edit') }}">
                    	{{ $tip_ctr->denumire }}
                    </a>
                    
                    <a class="pull-right" href="#" onclick="DeleteDateTemplate(this.parentNode.parentNode.id,'tip_ctr_{{ $tip_ctr->id }}', '{{ URL::route('tip_contract_delete') }}', 'id');return false;">
                    	<i class="fa fa-trash-o  fa-lg" title="Sterge"></i>
                    </a>
                    
                    <a href="#" onclick="GedIdTipContract('tip_ctr_{{ $tip_ctr->id }}');return false;" data-toggle="modal" data-target="#myModalTipActivitate" class="btn btn-success btn-xs add-level pull-right" title="Adauga tip activitate">Adauga tip activitate</a> <!-- Adauga tip activitate -->
                </div>
            </div>
            <!-- Sfarsit contract -->
            
            <!-- Tipuri activitati -->
            @foreach($tip_activitate as $tip_act)
            	@if($tip_act->id_tip_contract == $tip_ctr->id)	
                     <!-- Tip activitate -->                        
                    <div class="panel panel-warning tip_contract_{{ $tip_ctr -> id }} mev_hiden" id="activitatea_{{$tip_act->id}}">
                        <div class="panel-heading">                            
                            <span class="mev_pointer" onclick="show_hide_element(this, '.tip_activitate_{{ $tip_act -> id}}');return false;">
                                <i class="fa fa-plus-square"></i> Tip activitate:
                            </span>
                            
                            <a href="#" id="denumire_tipactivitate" class="xedit-denumire_tipactivitate" data-name="denumire" data-type="text" data-pk="{{ $tip_act->id }}"  data-url="{{ URL::to('/date_template_contract/tip_activitate/edit') }}">
                            	{{ $tip_act->denumire }}
                            </a>
                            
                            <a class="pull-right" href="#" onclick="DeleteDateTemplate(this.parentNode.parentNode.id,'tip_act_' + {{ $tip_act->id }}, '{{ URL::route('tip_activitate_delete') }}', 'id');return false;">
                            	<i class="fa fa-trash-o  fa-lg" title="Sterge"></i>
                            </a>
                            
                            <a href="#" onclick="GetIdTipActivitate('tip_act_' + {{ $tip_act->id }});return false; "data-toggle="modal" data-target="#myModalTipActivitateTipizata" class="btn btn-warning btn-xs add-level" title="Adauga tip activitate tipizata">Adauga tip activitate tipizata</a> <!-- Adauga tip activitate tipizata -->
                        </div>
                    </div>
                    <!-- Sfarsit tip activitate -->
                    
                    <!-- Tipuri activitati tipizate -->
                    @foreach($tip_activitate_tipizata as $tip_act_tip)
                    	@if($tip_act_tip->id_tip_activitate == $tip_act->id)                        
                        	<!-- Tip activitate tipizata-->
                            <div class="panel panel-info tip_activitate_{{ $tip_act -> id}} mev_hiden" id="tip_activitate_{{ $tip_act_tip -> id}}" style="border-width:1px;">
                                <div class="panel-heading">                          
                                    <span class="mev_pointer" onclick="show_hide_element(this, '.tip_activitate_tipizata_{{ $tip_act_tip->id }}', 1);return false;">
                                        <i class="fa fa-plus-square"></i> Tip activitate tipizata:
                                    </span>                                 
                                    <a href="#" id="denumire_tipactivitatetipizata" class="xedit-denumire_tipactivitatetipizata" data-name="denumire" data-type="text" data-pk="{{ $tip_act_tip->id }}"  data-url="{{ URL::to('/date_template_contract/tip_activitate_tipizata/edit') }}" style="left: 108px;">
                                    	{{ $tip_act_tip->denumire }}
                                    </a>

                                    <a style="float:right" href="#" onclick="DeleteDateTemplate(this.parentNode.parentNode.id,'act_tip_{{ $tip_act_tip->id }}', '{{ URL::route('tip_activitate_tipizata_delete') }}', 'id');return false;">
                                    	<i class="fa fa-trash-o fa-lg" title="Sterge"></i>
                                    </a>
                                </div>
                                <div class="panel-body tip_activitate_tipizata_{{ $tip_act_tip->id }} mev_hiden">
                                	<ul class="nav nav-tabs">
                                    	<li class="active" style="border-left:none;margin-left:-1px;">
                                        	<a data-toggle="tab" href="#livrabile_{{ $tip_act_tip->id }}" aria-expanded="true">Livrabile</a>
                                        </li>
                                    	<li>
                                        	<a data-toggle="tab" href="#obligatii_{{ $tip_act_tip->id }}" aria-expanded="false">Obligatii si sarcini contractuale tipizate</a>
                                        </li>
                                    	<li>
                                        	<a data-toggle="tab" href="#responsabilitati_{{ $tip_act_tip->id }}" aria-expanded="false">Responsabilitati activitate tipizata</a>
                                        </li>
                                    </ul>
                                    
                                    <!-- Livrabile -->
                                    <div class="tab-content">
                                        <div id="livrabile_{{ $tip_act_tip->id }}" class="tab-pane fade active in">
                                             <table class="table table-striped table-hover table-bordered" style="text-align:left;">
                                                <thead>
                                                    <tr class="info">
                                                        <th>
                                                        	Denumire livrabil
                                                            <a href="#" onclick="GetIdTipActivitateTipizata('act_tip_{{ $tip_act_tip->id }}');return false; "data-toggle="modal" data-target="#myModalTipLivrabile" class="btn btn-primary btn-xs" title="Adauga tip livrabil">
                                                            	Adauga
                                                            </a>
                                                        </th>
                                                        <th class="min_width center">Actiuni</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($tip_livrabile as $tip_liv)
                                                        @if($tip_liv->id_tip_activitate_tipizata == $tip_act_tip->id)
                                                        <tr id="tip_liv_{{ $tip_liv->id }}" data-id="{{ $tip_liv->id }}" data-table="tip_livrabile">
                                                            <td>
                                                            	<a href="#" data-pk="{{ $tip_liv->id }}" data-url="{{ URL::to('/date_template_contract/tip_livrabile/edit') }}" data-name="denumire" id="denumire_tiplivrabile" class="xedit-denumire_tiplivrabile" data-type="text">
                                                                	{{ $tip_liv->denumire }}
                                                                </a>
                                                            </td>
                                                            <td>
                                                            	<a href="#" onclick="DeleteDateTemplate(this.parentNode.parentNode.id,'tip_liv_{{ $tip_liv->id }}', '{{ URL::route('tip_livrabile_delete') }}', 'id');return false;">
                                                                	<i class="fa fa-trash-o fa-lg" title="Sterge"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Sfarsit livrabile -->
                                        
                                        <!-- Obligatii -->
                                        <div id="obligatii_{{ $tip_act_tip->id }}" class="tab-pane fade">
                                             <table class="table table-striped table-hover table-bordered" style="text-align:left;">
                                                <thead>
                                                    <tr class="info">
                                                        <th>
                                                        	Denumire
                                                            <a href="#" onclick="GetIdTipActivitateTipizata('act_tip_{{ $tip_act_tip->id }}');return false; "data-toggle="modal" data-target="#myModalTipObligatiiSarcini" class="btn btn-primary btn-xs add-level" title="Adauga tip obligatii sarcini">
                                                            	Adauga
                                                            </a>                                                            
                                                        </th>
                                                        <th>Responsabil</th>
                                                        <th class="min_width center">Actiuni</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                	@foreach($tip_obligatii_sarcini as $tip_ob_sar)
                                                    	@if($tip_ob_sar->id_tip_activitate_tipizata == $tip_act_tip->id)
                                                        <tr id="obl_sar_{{ $tip_ob_sar->id_tip_obligatie_sarcina }}" data-id="{{ $tip_ob_sar->id_tip_obligatie_sarcina }}" data-table="tip_obligatii_sarcini">
                                                        	<td>
                                                            	<a href="#" data-pk="{{ $tip_ob_sar->id_tip_obligatie_sarcina }}" data-url="{{ URL::to('/date_template_contract/tip_obligatii_sarcini/edit') }}" data-name="denumire" id="denumire_tipobligatiisarcini" class="xedit-denumire_tipobligatiisarcini" data-type="text">
                                                                	{{ $tip_ob_sar->denumire }}
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <a href="#" data-pk="{{ $tip_ob_sar->id_tip_obligatie_sarcina }}" data-url="{{ URL::to('/date_template_contract/tip_obligatii_sarcini/edit') }}" data-name="id_tip_responsabil" id="responsabilobligatie" class="xedit-responsabilobligatie" data-type="select">
                                                                	{{ $tip_ob_sar->DenumireResponsabil}}
                                                                </a>
                                                            </td>
                                                            <td>
                                                            	<a href="#" onclick="DeleteDateTemplate(this.parentNode.parentNode.id,'obl_sar_{{ $tip_ob_sar->id_tip_obligatie_sarcina }}', '{{ URL::route('tip_obligatii_sarcini_delete') }}', 'id_tip_obligatie_sarcina');return false;">
                                                                	<i class="fa fa-trash-o fa-lg" title="Sterge"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>                                	
                                        </div>                
                                        <!-- Sfarssit obligatii -->
                                                                
                                        <!-- Responsabilitati -->
                                        <div id="responsabilitati_{{ $tip_act_tip->id }}" class="tab-pane fade">
                                             <table class="table table-striped table-hover table-bordered" style="text-align:left;">
                                                <thead>
                                                    <tr class="info">
                                                        <th>
                                                        	Denumire responsabilitate
                                                            <a href="#" onclick="GetIdTipActivitateTipizata('act_tip_' + {{ $tip_act_tip->id }});return false; "data-toggle="modal" data-target="#myModalResponsabilitateActTip" class="btn btn-primary btn-xs add-level" title="Adauga responsabilitate tipizata">
                                                            	Adauga
                                                            </a>
                                                        </th>
                                                        <th class="min_width center">Actiuni</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($responsabilitate_act_tip as $resp_act_tip)
                                                        @if($resp_act_tip->id_activitate_tipizata == $tip_act_tip->id)
                                                            <tr id="res_act_{{ $resp_act_tip->id_resp_at }}" data-id="{{ $resp_act_tip->id_resp_at }}" data-table="responsabilitate_act_tip">
                                                                <td>
                                                                    <a href="#" data-pk="{{ $resp_act_tip->id_resp_at }}" data-url="{{ URL::to('/date_template_contract/responsabilitate_act_tip/edit') }}" data-name="id_responsabilitate" id="responsabilitatitipizate" class="xedit-responsabilitatitipizate" data-type="select">
                                                                    	{{ $resp_act_tip->Responsabilitate }}
                                                                     </a>
                                                                </td>
                                                                <td>
                                                                    <div align="center">
                                                                        <a href="#" onclick="DeleteDateTemplate(this.parentNode.parentNode.parentNode.id,'res_act_{{ $resp_act_tip->id_resp_at }}', '{{ URL::route('responsabilitate_act_tip_delete') }}', 'id_resp_at');return false;">
                                                                        	<i class="fa fa-trash-o fa-lg" title="Sterge"></i>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>                                	
                                        </div>	
                                    <!-- Sfarsit Responsabilitati -->
                                    </div>
                                </div>        
                            </div>
                        	<!-- Sfarsit tip activitate tipizata -->
                        @endif
    				@endforeach
                    <!-- Sfarsit tipuri activitati tipizate-->
                    
                @endif
    		@endforeach
        	<!-- Sfarsit tipuri activitati -->
            
    	@endforeach
        <!-- Sfarsit tipuri contract -->
    </div>
    
    <div class="row-expander">
        <div class="panel-group">
        </div>

        <select name="responsabili_obligatie_select" id="responsabili_obligatie_select" 
          class="selectpicker form-control hidden" data-live-search="true">
              @foreach ($tip_resp_ob_sar as $resp_sar) 
                  <option value="{{ $resp_sar->id_tip_responsabil }}">{{ $resp_sar->denumire }}</option>
              @endforeach                            
        </select>

        <select name="responsabilitati_tipizate_select" id="responsabilitati_tipizate_select" 
          class="selectpicker form-control hidden" data-live-search="true">
              @foreach ($resp_sub_cat_pers_pr as $resp_pr) 
                  <option value="{{ $resp_pr->id_responsabil_scp }}">{{ $resp_pr->Responsabilitate }}</option>
              @endforeach                            
        </select>

        <div class="modal fade bs-example-modal-lg" id="myModalTipContract" tabindex="-1" role="dialog" aria-labelledby="myModalLabelTipContract" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header modal-info">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabelTipContract">Adauga tip contract</h4>
              </div>
              <div class="modal-body">
                 <form role="form" action="{{ URL::current() }}" method="post">
                    <fieldset>     
                        <div class="form-group col-lg-10                   
                            @if ($errors->has('denumire')) has-error 
                            @elseif(Input::old('denumire')) has-success 
                            @endif">
                            <label>Denumire</label>
                            <input class="form-control" name="denumire" id="DenumireTipContract" type="text" value="{{ Input::old('denumire') }}" 
                            @if ($errors->has('required')) 
                                title="{{ $errors->first('required') }}" 
                            @endif>
                        </div>                                                                                                                                                                                                                                                                                                                                          
                    </fieldset>
                 </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="btn_click('CANCEL');return false;">Renunta</button>
                <input type="submit" name="submit" id="submitTipContract" class="btn btn-primary" value="Salveaza" onclick="btn_click('SAVE');return false;"/>
                {{ Form::token() }}
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade bs-example-modal-lg" id="myModalTipActivitate" tabindex="-1" role="dialog" aria-labelledby="myModalLabelTipActivitate" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header modal-info">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabelTipActivitate">Adauga tip activitate</h4>
              </div>
              <div class="modal-body">
                 <form role="form" action="{{ URL::current() }}" method="post">
                    <fieldset>     
                        <div class="form-group col-lg-10                   
                            @if ($errors->has('denumire')) has-error 
                            @elseif(Input::old('denumire')) has-success 
                            @endif">
                            <label>Denumire</label>
                            <input class="form-control" name="denumire" id="DenumireTipActivitate" type="text" value="{{ Input::old('denumire') }}" 
                            @if ($errors->has('required')) 
                                title="{{ $errors->first('required') }}" 
                            @endif>
                        </div>                                                                                                                                                                                                                                                                                                                                          
                    </fieldset>
                 </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="btn_click('CANCEL');return false;">Renunta</button>
                <input type="submit" name="submit" id="submitTipActivitate" class="btn btn-primary" value="Salveaza" onclick="btn_click('SAVE');return false;"/>
                {{ Form::token() }}
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade bs-example-modal-lg" id="myModalTipActivitateTipizata" tabindex="-1" role="dialog" aria-labelledby="myModalLabelTipActivitateTipizata" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header modal-info">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabelTipActivitateTipizata">Adauga tip activitate tipizata</h4>
              </div>
              <div class="modal-body">
                 <form role="form" action="{{ URL::current() }}" method="post">
                    <fieldset>     
                        <div class="form-group col-lg-10                   
                            @if ($errors->has('denumire')) has-error 
                            @elseif(Input::old('denumire')) has-success 
                            @endif">
                            <label>Denumire</label>
                            <input class="form-control" name="denumire" id="DenumireTipActivitateTipizata" type="text" value="{{ Input::old('denumire') }}" 
                            @if ($errors->has('required')) 
                                title="{{ $errors->first('required') }}" 
                            @endif>
                        </div>                                                                                                                                                                                                                                                                                                                                          
                    </fieldset>
                 </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="btn_click('CANCEL');return false;">Renunta</button>
                <input type="submit" name="submit" id="submitTipActivitateTipizata" class="btn btn-primary" value="Salveaza" onclick="btn_click('SAVE');return false;"/>
                {{ Form::token() }}
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade bs-example-modal-lg" id="myModalTipLivrabile" tabindex="-1" role="dialog" aria-labelledby="myModalLabelTipLivrabile" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header modal-info">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabelTipLivrabile">Adauga tip livrabile</h4>
              </div>
              <div class="modal-body">
                 <form role="form" action="{{ URL::current() }}" method="post">
                    <fieldset>     
                        <div class="form-group col-lg-10                   
                            @if ($errors->has('denumire')) has-error 
                            @elseif(Input::old('denumire')) has-success 
                            @endif">
                            <label>Denumire livrabil</label>
                            <input class="form-control" name="denumire" id="DenumireTipLivrabile" type="text" value="{{ Input::old('denumire') }}" 
                            @if ($errors->has('required')) 
                                title="{{ $errors->first('required') }}" 
                            @endif>
                        </div>                                                                                                                                                                                                                                                                                                                                          
                    </fieldset>
                 </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="btn_click('CANCEL');return false;">Renunta</button>
                <input type="submit" name="submit" id="submitTipLivrabile" class="btn btn-primary" value="Salveaza" onclick="btn_click('SAVE');return false;"/>
                {{ Form::token() }}
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade bs-example-modal-lg" id="myModalTipObligatiiSarcini" tabindex="-1" role="dialog" aria-labelledby="myModalLabelTipObligatiiSarcini" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header modal-info">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabelTipObligatiiSarcini">Adauga obligatie sarcini contractuale tipizate</h4>
              </div>
              <div class="modal-body">
                 <form role="form" action="{{ URL::current() }}" method="post">
                    <fieldset>     
                        <div class="form-group col-lg-10                   
                            @if ($errors->has('denumire')) has-error 
                            @elseif(Input::old('denumire')) has-success 
                            @endif">
                            <label>Denumire</label>
                            <input class="form-control" name="denumire" id="DenumireTipObligatiiSarcini" type="text" value="{{ Input::old('denumire') }}" 
                            @if ($errors->has('required')) 
                                title="{{ $errors->first('required') }}" 
                            @endif>
                        </div>
                        <div class="form-group col-lg-10
                            @if($errors->has('resp_sar')) has-error 
                            @elseif(Input::old('resp_sar')) has-success 
                            @endif ">
                            <label for = "">Responsabil</label>
                            <select name="resp_sar" id="resp_sar" 
                            class="selectpicker form-control" data-live-search="true">
                                @foreach ($tip_resp_ob_sar as $resp_sar) 
                                    <option value="{{ $resp_sar->id_tip_responsabil }}">{{ $resp_sar->denumire }}
                                    </option>
                                @endforeach                            
                            </select>
                        </div>                                                                                                                                                                                                                                                                                                                                          
                    </fieldset>
                 </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="btn_click('CANCEL');return false;">Renunta</button>
                <input type="submit" name="submit" id="submitTipObligatiiSarcini" class="btn btn-primary" value="Salveaza" onclick="btn_click('SAVE');return false;"/>
                {{ Form::token() }}
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade bs-example-modal-lg" id="myModalResponsabilitateActTip" tabindex="-1" role="dialog" aria-labelledby="myModalLabelResponsabilitateActTip" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header modal-info">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabelResponsabilitateActTip">Adauga responsabilitate activitate tipizata</h4>
              </div>
              <div class="modal-body">
                 <form role="form" action="{{ URL::current() }}" method="post">
                    <fieldset>
                        <div class="form-group col-lg-10
                            @if($errors->has('resp_pr')) has-error 
                            @elseif(Input::old('resp_pr')) has-success 
                            @endif ">
                            <label for = "">Denumire responsabilitate</label>
                            <select name="resp_pr" id="resp_pr" 
                            class="selectpicker form-control" data-live-search="true">
                                @foreach ($resp_sub_cat_pers_pr as $resp_pr) 
                                    <option value="{{ $resp_pr->id_responsabil_scp }}">{{ $resp_pr->Responsabilitate }}
                                    </option>
                                @endforeach                            
                            </select>
                        </div>                                                                                                                                                                                                                                                                                                                                          
                    </fieldset>
                 </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="btn_click('CANCEL');return false;">Renunta</button>
                <input type="submit" name="submit" id="submitResponsabilitateActTip" class="btn btn-primary" value="Salveaza" onclick="btn_click('SAVE');return false;"/>
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

            $('a.xedit-denumire_tipcontract').css('cursor','pointer').editable('option', 'validate', function(v) {              
                if(!v) return 'Camp obligatoriu!';
            });

            $('a.xedit-denumire_tipactivitate').css('cursor','pointer').editable('option', 'validate', function(v) {              
                if(!v) return 'Camp obligatoriu!';
            });

            $('a.xedit-denumire_tipactivitatetipizata').css('cursor','pointer').editable('option', 'validate', function(v) {              
                if(!v) return 'Camp obligatoriu!';
            });

            $('a.xedit-denumire_tiplivrabile').css('cursor','pointer').editable('option', 'validate', function(v) {              
                if(!v) return 'Camp obligatoriu!';
            });

            $('a.xedit-denumire_tipobligatiisarcini').css('cursor','pointer').editable('option', 'validate', function(v) {              
                if(!v) return 'Camp obligatoriu!';
            });

            // Parcurge dropdown-ul hidden cu responsabili obligatie si ii incarca intr-un array
            var responsabili_obligatie = [];            
            $('#responsabili_obligatie_select option').each(function(k,v) { 
                var obj = {};               
                obj.value = v.value;
                obj.text = v.text;
                responsabili_obligatie.push(obj);
            });

            //console.log(responsabili_obligatie);
            $('a.xedit-responsabilobligatie').css('cursor','pointer').editable({
                type: 'select',
                title: 'Responsabil obligatie',
                placement: 'right',
                source: responsabili_obligatie
            });

            // Parcurge dropdown-ul hidden cu responsabilitatile tipizate si le incarca intr-un array
            var responsabilitati_tipizate = [];            
            $('#responsabilitati_tipizate_select option').each(function(k,v) { 
                var obj = {};               
                obj.value = v.value;
                obj.text = v.text;
                responsabilitati_tipizate.push(obj);
            });

            //console.log(responsabilitati_tipizate);
            $('a.xedit-responsabilitatitipizate').css('cursor','pointer').editable({
                type: 'select',
                title: 'Responsabilitate tipizata',
                placement: 'right',
                source: responsabilitati_tipizate
            });

            var deps = [];
            
            function init_editable() {

                parent = '.row-expander';
                $('.editable, .description, .score', parent).editable();

                $('.parent', parent).editable({
                    source: deps,
                    select2: {
                        width: 300,
                        firstItem: 'none'
                    }
                });

            }
            init_editable();
            
            // Initializare taburi din ultimul nivel
            $('.tabs .tab-links a').on('click', function(e)  {
                    var currentAttrValue = $(this).attr('href');
             
                    // Show/Hide Tabs
                    $('.tabs ' + currentAttrValue).fadeIn(800).siblings().hide();
             
                    // Change/remove current tab to active
                    $(this).parent('li').addClass('active').siblings().removeClass('active');
             
                    e.preventDefault();
            });

        });
        
        // Stergerea oricarui camp
        function DeleteDateTemplate(that,id, url_delete, id_name) {
            var el = that;
            var id_str = id.substring(8);
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
                                DeleteCascade(el);
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
        
        $("#submitTipContract").click(function() {
          $("#myModalTipContract").modal("hide");  
        });

        $("#submitTipActivitate").click(function() {
          $("#myModalTipActivitate").modal("hide");  
        });

        $("#submitTipActivitateTipizata").click(function() {
          $("#myModalTipActivitateTipizata").modal("hide");  
        });

        $("#submitTipLivrabile").click(function() {
          $("#myModalTipLivrabile").modal("hide");  
        });

        $("#submitTipObligatiiSarcini").click(function() {
          $("#myModalTipObligatiiSarcini").modal("hide");  
        });

        $("#submitResponsabilitateActTip").click(function() {
          $("#myModalResponsabilitateActTip").modal("hide");  
        });

        //Functii pentru preluarea id-urilor principale
        function GedIdTipContract(id) {
            id_str_ctr = id.substring(8);
            id_tip_contract = parseInt(id_str_ctr);
        }

        function GetIdTipActivitate(id) {
            

            id_str_act = id.substring(8);
            id_tip_activitate = parseInt(id_str_act);

        }

        function GetIdTipActivitateTipizata(id) {
            

            id_str_act_tip = id.substring(8);
            id_tip_activitate_tipizata = parseInt(id_str_act_tip);

        }


        //jQuery pentru activarea si folosirea pop-urilor modal pentru adaugare inregistrari noi
        $("#myModalTipContract").on('hide.bs.modal', function(e) {
            
            console.error(e.target);
            console.error("MDL" + btnModal);
            if (btnModal === 'SAVE')
            {
                
                var denumire = $('#DenumireTipContract').val();   
                var url_add = "{{ URL::route('tip_contract_add') }}";

                var parametrii = [];
                parametrii.push(denumire);


                var stringed = JSON.stringify(parametrii);
                //var id = $(this).closest('tr').data('id');
                //console.error(stringed);
                $.ajax({
                    url: url_add,
                    type: 'POST',
                    data : { 
                        "parametrii": stringed
                    },
                    success: function(data){
                      if (typeof data === 'object') {
                          if (data.status === "OK") {
                              var ruta = "{{ URL::route('date_template_contract') }}";
                              MessageBox("SUCCESS", "Tip contract", data.message);
                              var divToAdd = $('#tip_ctr_{{ $tip_ctr->id }}');
                              divToAdd.hide();
                              $('div:last-child').after(divToAdd);
                              divToAdd.fadeIn(800);

                              TipContractView(denumire);
                          }
                          else
                              MessageBox("ERROR", "Tip contract", data.message);
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
        
        $("#myModalTipActivitate").on('hide.bs.modal', function(e) {

            console.error(e.target);
            console.error("MDL" + btnModal);
            if (btnModal === 'SAVE')
            {
                
                var denumire = $('#DenumireTipActivitate').val();   
                var url_add = "{{ URL::route('tip_activitate_add') }}";

                var parametrii = [];
                parametrii.push(denumire);
                parametrii.push(id_tip_contract);

                var stringed = JSON.stringify(parametrii);
                //var id = $(this).closest('tr').data('id');
                //console.error(stringed);
                $.ajax({
                    url: url_add,
                    type: 'POST',
                    data : { 
                        "parametrii": stringed
                    },
                    success: function(data){
                      if (typeof data === 'object') {
                          if (data.status === "OK") {
                              var ruta = "{{ URL::route('date_template_contract', '_idct_') }}";
                              ruta = ruta.replace("'_idct_'", parseInt(id_tip_contract));
                              MessageBox("SUCCESS", "Tip activitate", data.message);
                              TipActivitateView(parametrii, data['new_id'], denumire);
                              //window.setTimeout(function(){location.reload()},2000);
                          }
                          else
                              MessageBox("ERROR", "Tip activitate", data.message);
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

        $("#myModalTipActivitateTipizata").on('hide.bs.modal', function(e) {


            console.error(e.target);
            console.error("MDL" + btnModal);
            if (btnModal === 'SAVE')
            {
                
                var denumire = $('#DenumireTipActivitateTipizata').val();   
                var url_add = "{{ URL::route('tip_activitate_tipizata_add') }}";

                var parametrii = [];
                parametrii.push(denumire);
                parametrii.push(id_tip_activitate);


                var stringed = JSON.stringify(parametrii);
                //var id = $(this).closest('tr').data('id');
                //console.error(stringed);
                $.ajax({
                    url: url_add,
                    type: 'POST',
                    data : { 
                        "parametrii": stringed
                    },
                    success: function(data){
                      if (typeof data === 'object') {
                          if (data.status === "OK") {
                              var ruta = "{{ URL::route('date_template_contract', '_idact_') }}";
                              ruta = ruta.replace("'_idact_'", parseInt(id_tip_activitate));
                              MessageBox("SUCCESS", "Tip activitate tipizata", data.message);
                              TipActivitateTipizataView(denumire, parametrii, data);
                              //window.setTimeout(function(){location.reload()},2000);
                          }
                          else
                              MessageBox("ERROR", "Tip activitate tipizata", data.message);
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

        $("#myModalTipLivrabile").on('hide.bs.modal', function(e) {

            if (btnModal === 'SAVE')
            {
                var denumire = $('#DenumireTipLivrabile').val();   
                var url_add = "{{ URL::route('tip_livrabile_add') }}";

                var parametrii = [];
                parametrii.push(denumire);
                parametrii.push(id_tip_activitate_tipizata);

                var stringed = JSON.stringify(parametrii);
                //var id = $(this).closest('tr').data('id');
                //console.error(stringed);
                $.ajax({
                    url: url_add,
                    type: 'POST',
                    data : { 
                        "parametrii": stringed
                    },
                    success: function(data){
                      if (typeof data === 'object') {
                          if (data.status === "OK") {
                              var ruta = "{{ URL::route('date_template_contract', '_idactt_') }}";
                              ruta = ruta.replace("'_idactt_'", parseInt(id_tip_activitate_tipizata));
                              MessageBox("SUCCESS", "Tip livrabile", data.message);
                              LivrabileView(data, denumire, parametrii);
                              //window.setTimeout(function(){location.reload()},2000);
                          }
                          else
                              MessageBox("ERROR", "Tip livrabile", data.message);
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

        $("#myModalTipObligatiiSarcini").on('hide.bs.modal', function(e) {
            if (btnModal === 'SAVE')
            {
                var denumire = $('#DenumireTipObligatiiSarcini').val();   
                var url_add = "{{ URL::route('tip_obligatii_sarcini_add') }}";
                var resp_sar = $('#resp_sar').val();

                var parametrii = [];
                parametrii.push(denumire);
                parametrii.push(id_tip_activitate_tipizata);
                parametrii.push(resp_sar);


                var stringed = JSON.stringify(parametrii);
                //var id = $(this).closest('tr').data('id');
                //console.error(stringed);
                $.ajax({
                    url: url_add,
                    type: 'POST',
                    data : { 
                        "parametrii": stringed
                    },
                    success: function(data){
                      if (typeof data === 'object') {
                          if (data.status === "OK") {
                              var ruta = "{{ URL::route('date_template_contract', '_idactt_') }}";
                              ruta = ruta.replace("'_idactt_'", parseInt(id_tip_activitate_tipizata));
                              MessageBox("SUCCESS", "Tip obligatii sarcini", data.message);
                              ObligatiiView(data, parametrii, denumire);
                              //window.setTimeout(function(){location.reload()},2000);
                          }
                          else
                              MessageBox("ERROR", "Tip obligatii sarcini", data.message);
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

        $("#myModalResponsabilitateActTip").on('hide.bs.modal', function(e) {


            console.error(e.target);
            console.error("MDL" + btnModal);
            if (btnModal === 'SAVE')
            {
                 
                var resp_pr = $('#resp_pr').val();
                var url_add = "{{ URL::route('responsabilitate_act_tip_add') }}";
                console.log(url_add);
                

                var parametrii = [];
                parametrii.push(id_tip_activitate_tipizata);
                parametrii.push(resp_pr);


                var stringed = JSON.stringify(parametrii);
                //var id = $(this).closest('tr').data('id');
                console.error(stringed);
                $.ajax({
                    url: url_add,
                    type: 'POST',
                    data : { 
                        "parametrii": stringed
                    },
                    success: function(data){
                      if (typeof data === 'object') {
                          if (data.status === "OK") {
                              var ruta = "{{ URL::route('date_template_contract', '_idactt_') }}";
                              ruta = ruta.replace("'_idactt_'", parseInt(id_tip_activitate_tipizata));
                              MessageBox("SUCCESS", "Responsabilitate activitate tipizata", data.message);
                              ResponsabilitatiView(resp_pr,parametrii,data);
                              //window.setTimeout(function(){location.reload()},2000);
                          }
                          else
                              MessageBox("ERROR", "Responsabilitate activitate tipizata", data.message);
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

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
        });
        $('[title]:not([data-placement])').tooltip({'placement': 'top'});

    </script>
	
    <script>
		<!-- Mevoro functions -->		
		var mev_global_url = '{{ url::to('/') }}';
		
		function show_hide_element(clicked_element, to_be_showed, last) {
			if(last == undefined) {
				last = 0;
			}
			var i = $(clicked_element).find('i');
			var to_be_showed = $(to_be_showed);
			if(to_be_showed.hasClass('mev_hiden')) {
				i.removeClass('fa-plus-square').addClass('fa-minus-square');
				to_be_showed.removeClass('mev_hiden');
			
				if(last != 0) {
					to_be_showed.addClass('mev_current_box');
					//to_be_showed.attr('style', 'border-bottom:3px solid #D9EDF7; margin-bottom:5px;');
				}
			}
			else{
				i.removeClass('fa-minus-square').addClass('fa-plus-square');
				to_be_showed.addClass('mev_hiden');
			
				if(last != 0) {
					to_be_showed.removeClass('mev_current_box');
					//to_be_showed.attr('style', 'border-bottom:none; margin-bottom:0;');
				}
			}
		}

        function TipContractView(name, that){
            var cop = $(".panel-success").last(); // Copy last element
            var new_id = parseInt(cop.attr('id').split('_').pop()) + 1; //increase id
            cop.appendTo(".row-expander").css({opacity: '1'}); // show new element

            var new_el = $(".panel-success").last(); // select last element
            new_el.attr('id', 'tip_ctr_'+new_id).attr('data-id', new_id); // change id
            new_el.find('.panel.panel-warning').remove(); // remove all tip activitate for element (clean element)
            new_el.find('.mev_pointer').attr('onclick', "show_hide_element(this, '.tip_contract_"+new_id+"');return false;")//change onclick event
            new_el.find('#denumire_tipcontract').html(name); //change name for new element
            new_el.find('a[data-target="#myModalTipActivitate"]').attr('onclick', 'GedIdTipContract("tip_ctr_'+new_id+'");return false;');
            new_el.find('a[data-target="#myModalTipActivitate"]').attr('onclick', 'GedIdTipContract("tip_ctr_'+new_id+'");return false;');
        }

        function TipActivitateView(param, activitate_id, name)
        {
            hide_class = $("#tip_ctr_"+param[1]).find('.mev_pointer i').attr('class');
            if(hide_class == 'fa fa-plus-square')
                var str = '<div class="panel panel-warning mev_hiden tip_contract_'+param[1]+'" id="activitatea_'+activitate_id+'"><div class="panel-heading"><span class="mev_pointer" onclick="show_hide_element(this, \'.tip_activitate_'+activitate_id+'\');return false;"><i class="fa fa-plus-square"></i> Tip activitate:</span><a href="#" id="denumire_tipactivitate" class="xedit-denumire_tipactivitate editable editable-click" data-name="denumire" data-type="text" data-pk="1" data-url="' + mev_global_url + '/date_template_contract/tip_activitate/edit" style="cursor: pointer;">'+name+'</a><a class="pull-right" href="#" onclick="DeleteDateTemplate(this.parentNode.parentNode.id,\'tip_act_' + activitate_id+'\', \'' + mev_global_url + '/tip_activitate_delete\', \'id\');return false;"><i class="fa fa-trash-o  fa-lg" title="Sterge"></i></a><a href="#" onclick="GetIdTipActivitate(\'tip_act_'+activitate_id+'\');return false; " data-toggle="modal" data-target="#myModalTipActivitateTipizata" class="btn btn-warning btn-xs add-level" title="Adauga tip activitate tipizata">Adauga tip activitate tipizata</a> <!-- Adauga tip activitate tipizata --></div></div>';
            else
                var str = '<div class="panel panel-warning tip_contract_'+param[1]+'" id="activitatea_'+activitate_id+'"><div class="panel-heading"><span class="mev_pointer" onclick="show_hide_element(this, \'.tip_activitate_'+activitate_id+'\');return false;"><i class="fa fa-plus-square"></i> Tip activitate:</span><a href="#" id="denumire_tipactivitate" class="xedit-denumire_tipactivitate editable editable-click" data-name="denumire" data-type="text" data-pk="1" data-url="' + mev_global_url + '/date_template_contract/tip_activitate/edit" style="cursor: pointer;">'+name+'</a><a class="pull-right" href="#" onclick="DeleteDateTemplate(this.parentNode.parentNode.id,\'tip_act_' + activitate_id+'\', \'' + mev_global_url + '/tip_activitate_delete\', \'id\');return false;"><i class="fa fa-trash-o  fa-lg" title="Sterge"></i></a><a href="#" onclick="GetIdTipActivitate(\'tip_act_'+activitate_id+'\');return false; " data-toggle="modal" data-target="#myModalTipActivitateTipizata" class="btn btn-warning btn-xs add-level" title="Adauga tip activitate tipizata">Adauga tip activitate tipizata</a> <!-- Adauga tip activitate tipizata --></div></div>';

            $("#tip_ctr_"+param[1]).append(str);
        }

        function TipActivitateTipizataView(denumire, parametrii, data){
            hide_class = $("#activitatea_"+parametrii[1]).find('.mev_pointer i').attr('class');
            if(hide_class == 'fa fa-plus-square')
                var str = '<div class="panel panel-info mev_hiden tip_activitate_'+parametrii[1]+'" id="tip_activitate_tipizata_'+data['new_id']+'" style="border-width:1px;"><div class="panel-heading"><span class="mev_pointer" onclick="show_hide_element(this, \'.tip_activitate_tipizata_26\', '+data['new_id']+');return false;"><i class="fa fa-plus-square"></i> Tip activitate tipizata:</span><a href="#" id="denumire_tipactivitatetipizata" class="xedit-denumire_tipactivitatetipizata editable editable-click" data-name="denumire" data-type="text" data-pk="26" data-url="' + mev_global_url + '/date_template_contract/tip_activitate_tipizata/edit" style="left: 108px; cursor: pointer;">'+denumire+'</a><a style="float:right" href="#" onclick="DeleteDateTemplate(this.parentNode.parentNode.id,\'act_tip_' + data['new_id']+'\', \'' + mev_global_url + '/tip_activitate_tipizata_delete\', \'id\');return false;"><i class="fa fa-trash-o fa-lg" title="Sterge"></i></a></div><div class="panel-body tip_activitate_tipizata_26 mev_hiden"><ul class="nav nav-tabs"><li class="active" style="border-left:none;margin-left:-1px;"><a data-toggle="tab" href="#livrabile_26" aria-expanded="true">Livrabile</a></li><li><a data-toggle="tab" href="#obligatii_'+data['new_id']+'" aria-expanded="false">Obligatii si sarcini contractuale tipizate</a></li><li><a data-toggle="tab" href="#responsabilitati_'+data['new_id']+'" aria-expanded="false">Responsabilitati activitate tipizata</a></li></ul><!-- Livrabile --><div class="tab-content"><div id="livrabile_'+data['new_id']+'" class="tab-pane fade active in"><table class="table table-striped table-hover table-bordered" style="text-align:left;"><thead><tr class="info"><th>Denumire livrabil<a href="#" onclick="GetIdTipActivitateTipizata(\'act_tip_'+data['new_id']+'\');return false; " data-toggle="modal" data-target="#myModalTipLivrabile" class="btn btn-primary btn-xs" title="Adauga tip livrabil">Adauga </a> </th> <th class="min_width center">Actiuni</th> </tr></thead> <tbody> </tbody> </table> </div><div id="obligatii_'+data['new_id']+'" class="tab-pane fade"><table class="table table-striped table-hover table-bordered" style="text-align:left;"> <thead> <tr class="info"> <th> Denumire<a href="#" onclick="GetIdTipActivitateTipizata(\'act_tip_'+data['new_id']+'\');return false; " data-toggle="modal" data-target="#myModalTipObligatiiSarcini" class="btn btn-primary btn-xs add-level" title="Adauga tip obligatii sarcini">Adauga</a> </th> <th>Responsabil</th> <th class="min_width center">Actiuni</th> </tr></thead> <tbody> </tbody> </table> </div><div id="responsabilitati_'+data['new_id']+'" class="tab-pane fade"><table class="table table-striped table-hover table-bordered" style="text-align:left;"><thead> <tr class="info"> <th> Denumire responsabilitate<a href="#" onclick="GetIdTipActivitateTipizata(\'act_tip_'+data['new_id']+'\');return false; " data-toggle="modal" data-target="#myModalResponsabilitateActTip" class="btn btn-primary btn-xs add-level" title="Adauga responsabilitate tipizata">Adauga </a> </th> <th class="min_width center">Actiuni</th> </tr></thead> <tbody> </tbody> </table> </div></div></div></div>';
            else
                var str = '<div class="panel panel-info tip_activitate_'+parametrii[1]+'" id="tip_activitate_tipizata_'+data['new_id']+'" style="border-width:1px;"><div class="panel-heading"><span class="mev_pointer" onclick="show_hide_element(this, \'.tip_activitate_tipizata_26\', '+data['new_id']+');return false;"><i class="fa fa-plus-square"></i> Tip activitate tipizata:</span><a href="#" id="denumire_tipactivitatetipizata" class="xedit-denumire_tipactivitatetipizata editable editable-click" data-name="denumire" data-type="text" data-pk="26" data-url="' + mev_global_url + '/date_template_contract/tip_activitate_tipizata/edit" style="left: 108px; cursor: pointer;">'+denumire+'</a><a style="float:right" href="#" onclick="DeleteDateTemplate(this.parentNode.parentNode.id,\'act_tip_' + data['new_id']+'\', \'' + mev_global_url + '/tip_activitate_tipizata_delete\', \'id\');return false;"><i class="fa fa-trash-o fa-lg" title="Sterge"></i></a></div><div class="panel-body tip_activitate_tipizata_26 mev_hiden"><ul class="nav nav-tabs"><li class="active" style="border-left:none;margin-left:-1px;"><a data-toggle="tab" href="#livrabile_26" aria-expanded="true">Livrabile</a></li><li><a data-toggle="tab" href="#obligatii_'+data['new_id']+'" aria-expanded="false">Obligatii si sarcini contractuale tipizate</a></li><li><a data-toggle="tab" href="#responsabilitati_'+data['new_id']+'" aria-expanded="false">Responsabilitati activitate tipizata</a></li></ul><!-- Livrabile --><div class="tab-content"><div id="livrabile_'+data['new_id']+'" class="tab-pane fade active in"><table class="table table-striped table-hover table-bordered" style="text-align:left;"><thead><tr class="info"><th>Denumire livrabil<a href="#" onclick="GetIdTipActivitateTipizata(\'act_tip_'+data['new_id']+'\');return false; " data-toggle="modal" data-target="#myModalTipLivrabile" class="btn btn-primary btn-xs" title="Adauga tip livrabil">Adauga </a> </th> <th class="min_width center">Actiuni</th> </tr></thead> <tbody> </tbody> </table> </div><div id="obligatii_'+data['new_id']+'" class="tab-pane fade"><table class="table table-striped table-hover table-bordered" style="text-align:left;"> <thead> <tr class="info"> <th> Denumire<a href="#" onclick="GetIdTipActivitateTipizata(\'act_tip_'+data['new_id']+'\');return false; " data-toggle="modal" data-target="#myModalTipObligatiiSarcini" class="btn btn-primary btn-xs add-level" title="Adauga tip obligatii sarcini">Adauga</a> </th> <th>Responsabil</th> <th class="min_width center">Actiuni</th> </tr></thead> <tbody> </tbody> </table> </div><div id="responsabilitati_'+data['new_id']+'" class="tab-pane fade"><table class="table table-striped table-hover table-bordered" style="text-align:left;"><thead> <tr class="info"> <th> Denumire responsabilitate<a href="#" onclick="GetIdTipActivitateTipizata(\'act_tip_'+data['new_id']+'\');return false; " data-toggle="modal" data-target="#myModalResponsabilitateActTip" class="btn btn-primary btn-xs add-level" title="Adauga responsabilitate tipizata">Adauga </a> </th> <th class="min_width center">Actiuni</th> </tr></thead> <tbody> </tbody> </table> </div></div></div></div>';
            $("#activitatea_"+parametrii[1]).append(str);
        }

        function DeleteCascade(el)
        {
            var arr = el.split('_');
            var number = el.split('_').pop();
            var name = '';
            for(var i = 0; i < arr.length - 1; i++){
                name += arr[i]+"_";
            }
            name = name.slice(0,-1);
            if(name == 'tip_ctr')
            {
                var activitate_id = $(".tip_contract_" + number).first().attr('id');
                if(typeof activitate_id !== "undefined"){
                    activitate_id = parseInt(activitate_id.slice(12));
                    $(".tip_activitate_"+activitate_id).remove();
                }
                $(".tip_contract_"+number).remove();
            }else if(name == 'activitatea'){
                $(".tip_activitate_"+number).remove();
            }else if(name == 'res_act'){

            }
            $("#"+el).remove();
        }

        function LivrabileView(data, denumire, parametrii){
            var a = '<tr id="tip_liv_'+data['new_id']+'" data-id="'+data['new_id']+'" data-table="tip_livrabile"><td><a href="#" data-pk="'+data['new_id']+'" data-url="' + mev_global_url + '/date_template_contract/tip_livrabile/edit" data-name="denumire" id="denumire_tiplivrabile" class="xedit-denumire_tiplivrabile editable editable-click" data-type="text" style="cursor: pointer;">'+denumire+'</td><td><a href="#" onclick="DeleteDateTemplate(this.parentNode.parentNode.id,\'tip_liv_' + data['new_id']+'\', \'' + mev_global_url + '/tip_livrabile_delete\', \'id\');return false;"><i class="fa fa-trash-o fa-lg" title="Sterge"></i></a></td></tr>';
            $("#livrabile_" + parametrii[1]).find("table tbody").append(a);
        }

        function ObligatiiView(data, parametrii, denumire){
            if(parametrii[2] == '1')
                var c = 'CONTRACTANT';
            else
                var c = 'CONTRACTOR';
            var a = '<tr id="obl_sar_'+data['new_id']+'" data-id="'+data['new_id']+'" data-table="tip_obligatii_sarcini"><td><a href="#" data-pk="'+data['new_id']+'" data-url="' + mev_global_url + '/date_template_contract/tip_obligatii_sarcini/edit" data-name="denumire" id="denumire_tipobligatiisarcini" class="xedit-denumire_tipobligatiisarcini editable editable-click" data-type="text" style="cursor: pointer;">'+denumire+'</a></td><td><a href="#" data-pk="'+data['new_id']+'" data-url="' + mev_global_url + '/date_template_contract/tip_obligatii_sarcini/edit" data-name="id_tip_responsabil" id="responsabilobligatie" class="xedit-responsabilobligatie editable editable-click" data-type="select" style="cursor: pointer;">'+c+'</a></td><td><a href="#" onclick="DeleteDateTemplate(this.parentNode.parentNode.id,\'obl_sar_'+data['new_id']+'\', \'' + mev_global_url + '/tip_obligatii_sarcini_delete\', \'id_tip_obligatie_sarcina\');return false;"> <i class="fa fa-trash-o fa-lg" title="Sterge"></i></a></td></tr>';

            $("#obligatii_"+parametrii[1]).find("table tbody").append(a);
        }

        function ResponsabilitatiView(denumire_nr,parametrii,data)
        {
            var denumire = '';
            switch(denumire_nr){
                case '1' : denumire = 'Manager general  (Personal de coordonare - Manageri, Manager general pe contract)'; break;
                case '2' : denumire = 'Proiectare arhitectura  (Personal de executie - Specialisti, Specialist tehnic)'; break;
                case '3' : denumire = 'Proiectare rezistenta  (Personal de executie - Specialisti, Specialist tehnic)'; break;
                case '4' : denumire = 'Realizare CPE  (Personal de executie - Specialisti, Specialist tehnic)'; break;
                case '5' : denumire = 'Proiectare instalatii  (Personal de executie - Specialisti, Specialist tehnic)'; break;
                case '6' : denumire = 'Verificare documentatii  (Personal logistica - Specialisti, Specialist logistica)'; break;
                case '7' : denumire = 'Listare documentatii  (Personal logistica - Specialisti, Specialist logistica)'; break;
                defaut: denumire = ''; break;
            }
            var a = '<tr id="res_act_'+data['new_id']+'" data-id="'+data['new_id']+'" data-table="responsabilitate_act_tip"><td><a href="#" data-pk="'+data['new_id']+'" data-url="' + mev_global_url + '/date_template_contract/responsabilitate_act_tip/edit" data-name="id_responsabilitate" id="responsabilitatitipizate" class="xedit-responsabilitatitipizate editable editable-click" data-type="select" style="cursor: pointer;">'+denumire+'</a></td><td><div align="center"><a href="#" onclick="DeleteDateTemplate(this.parentNode.parentNode.parentNode.id,\'res_act_' + data['new_id'] + '\', \'' + mev_global_url + '/responsabilitate_act_tip_delete\', \'id_resp_at\');return false;"><i class="fa fa-trash-o fa-lg" title="Sterge"></i></a></div></td></tr>';
            $("#responsabilitati_"+parametrii[0]).find("table tbody").append(a);
        }
		<!-- End of Mevoro functions -->
	</script>
@stop
