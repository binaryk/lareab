@extends('achizitii::nomenclator.general_actions.actions')
@section('actions-items')
<li>
<a href="{{ route('nomenclator-tip-anunt', ['id' => 'tip-anunt','id_procedura' => $record->id]) }}" ><i class="fa fa-cicle"></i> <span>Vezi tipurile de anunțuri</span></a></li>
<li class="divider"></li>
@parent
@stop