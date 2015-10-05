<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAchTemplateAchizitiiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ach_template_achizitii', function(Blueprint $t){
			$t->increments('id');
			$t->text('nume',25);
			$t->text('cod_procedura',25);
			$t->text('descriere_procedura');
			$t->tinyinteger('tip_achizitor');
			$t->tinyinteger('tip_contract');
			$t->tinyinteger('tip_procedura');
			$t->tinyinteger('tip_anunt');
			$t->double('plafon_maxim');
			$t->datetime('data_semnare_cf');
			// $t-> tip achizitie ???
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
		Schema::drop('ach_template_achizitii');
	}

}
