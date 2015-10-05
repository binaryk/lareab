@extends('achizitii::nomenclator.general_actions.actions')
@section('actions-items')
<li>
<a href="{{ route('nomenclator-modalitati-publicare', ['id' => 'modalitati-publicare','id_anunt' => $record->id]) }}" ><i class="fa fa-cicle"></i> <span>
Vezi modalitățile de publicare</span></a></li>
<li class="divider"></li>
@parent
@stop