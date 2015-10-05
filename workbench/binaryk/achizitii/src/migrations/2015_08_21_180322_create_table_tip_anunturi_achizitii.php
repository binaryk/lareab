<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTipAnunturiAchizitii extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		 Schema::create('ach_tip_anunturi', function(Blueprint $t){
			$t->increments('id');
			$t->timestamps();
			$t->softdeletes();
			$t->text('nume',50); 
			$t->integer('id_tip_procedura'); 

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ach_tip_anunturi'); 
	}

}
