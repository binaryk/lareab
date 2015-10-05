<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAchModalitatiPublicare extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ach_modalitati_publicare', function(Blueprint $t){
			$t->increments('id');
			$t->timestamps();
			$t->softdeletes();
			$t->text('nume',50); 
			$t->integer('id_tip_anunt'); 
			$t->tinyinteger('anunt_anterior');
			$t->tinyinteger('tip_complexitate');
			$t->tinyinteger('zile_dp');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ach_modalitati_publicare');
	}

}
