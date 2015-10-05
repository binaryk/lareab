<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAchTipProceduriAchizitii extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ach_tip_proceduri_achizitii', function(Blueprint $t){
			$t->increments('id');
			$t->timestamps();
			$t->softdeletes();
			$t->text('nume'); 
			$t->tinyinteger('tip_achizitor'); 

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ach_tip_proceduri_achizitii'); 
	}

}
