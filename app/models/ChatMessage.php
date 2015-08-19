<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ChatMessage extends Eloquent {

    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];

    protected $guarded = array();

    protected $table = 'chat';

    public function sender()
    {
    	return $this->belongsTo('User', 'sender');
    }

    public function send_to()
    {
    	return $this->belongsTo('User', 'send_to');
    }

}