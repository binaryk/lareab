<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTypesCategory extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ach_tip_categorie', function(Blueprint $t){
			$t->increments('id');
			$t->timestamps();
			$t->softdeletes();
			$t->text('nume',50);//tip achizitor ==> id == 1

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ach_tip_categorie');
	}

}
