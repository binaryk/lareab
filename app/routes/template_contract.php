<?php

Route::group(array('after' => 'auth'), function () 
{
    /*Date template contract - tree system*/
    Route::get('/date_template_contract', array('as' => 'date_template_contract', 'uses' => 'DateTemplateContractController@getDateTemplateContract'));

    /*Date template contract - tree system*/
    Route::post('/date_template_contract/{table}/edit', array('as' => 'date_template_contract_edit', 'uses' => 'DateTemplateContractController@postEditDateTemplateContract'));

    /*Template contract - tree system*/
    Route::get('/template_contract', array('as' => 'template_contract', 'uses' => 'TemplateContractController@getTemplateContract'));
    //Delete
    Route::post('/tip_contract_delete', array('as' => 'tip_contract_delete', 'uses' => 'DateTemplateContractController@postDeleteTipContract'));
    Route::post('/tip_activitate_delete', array('as' => 'tip_activitate_delete', 'uses' => 'DateTemplateContractController@postDeleteTipActivitate'));
    Route::post('/tip_activitate_tipizata_delete', array('as' => 'tip_activitate_tipizata_delete', 'uses' => 'DateTemplateContractController@postDeleteTipActivitateTipizata'));
    Route::post('/tip_livrabile_delete', array('as' => 'tip_livrabile_delete', 'uses' => 'DateTemplateContractController@postDeleteTipLivrabile'));
    Route::post('/tip_obligatii_sarcini_delete', array('as' => 'tip_obligatii_sarcini_delete', 'uses' => 'DateTemplateContractController@postDeleteTipObligatiiSarcini'));
    Route::post('/responsabilitate_act_tip_delete', array('as' => 'responsabilitate_act_tip_delete', 'uses' => 'DateTemplateContractController@postDeleteResponsabilitateActTip'));
  
    //Edit/save dropdown
    Route::post('/tip_responsabil_obligatie/{id}/edit', array('as' => 'tip_responsabil_obligatie_edit', 'uses' => 'DateTemplateContractController@postEditTipResponsabilObligatie'));

    //Add
    Route::post('/tip_contract_add', array('as' => 'tip_contract_add', 'uses' => 'DateTemplateContractController@postAddTipContract'));
    Route::post('/tip_activitate_add', array('as' => 'tip_activitate_add', 'uses' => 'DateTemplateContractController@postAddTipActivitate'));
    Route::post('/tip_activitate_tipizata_add', array('as' => 'tip_activitate_tipizata_add', 'uses' => 'DateTemplateContractController@postAddTipActivitateTipizata'));
    Route::post('/tip_livrabile_add',array('as' => 'tip_livrabile_add', 'uses' => 'DateTemplateContractController@postAddTipLivrabile'));
    Route::post('/tip_obligatii_sarcini_add', array('as' => 'tip_obligatii_sarcini_add', 'uses' => 'DateTemplateContractController@postAddTipObligatiiSarcini'));
    Route::post('/responsabilitate_act_tip_add', array('as' => 'responsabilitate_act_tip_add', 'uses' => 'DateTemplateContractController@postAddResponsabilitateActTip'));

   	/*Template contract - tree system*/
    Route::post('/template_contract/{table}/edit', array('as' => 'template_contract_edit', 'uses' => 'TemplateContractController@postEditTemplateContract'));
    //Delete
    Route::post('/template_contract_tipizat_master_delete', array('as' => 'template_contract_tipizat_master_delete', 'uses' => 'TemplateContractController@postDeleteTemplateMaster'));
    Route::post('/template_contract_tipizat_detail_delete', array('as' => 'template_contract_tipizat_detail_delete', 'uses' => 'TemplateContractController@postDeleteTemplateDetail'));
    //Add
    Route::post('/template_master_add', array('as' => 'template_master_add', 'uses' => 'TemplateContractController@postAddTemplateMaster'));
    Route::post('/template_detail_add', array('as' => 'template_detail_add', 'uses' => 'TemplateContractController@postAddTemplateDetail'));
    //Edit
    Route::post('/template_detail_edit', array('as' => 'template_detail_edit', 'uses' => 'TemplateContractController@postEditTemplateDetail'));
});     