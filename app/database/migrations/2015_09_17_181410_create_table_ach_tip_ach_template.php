<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAchTipAchTemplate extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ach_tip_achzitii_template', function(Blueprint $t){
			$t->increments('id');
			$t->integer('id_tip_achizitie');
			$t->integer('id_template');
			$t->softdeletes();
			$t->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ach_tip_achzitii_template');
	}

}
