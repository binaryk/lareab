<?php 
namespace Migrations;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TipProceduriAchizitii extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ach_tip_achizitii', function(Blueprint $t){
			$t->increments('id');
			$t->timestamps();
			$t->softdeletes();
			$t->text('nume',30);

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
	}

}
