<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTourlocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tourlocations', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->string('LocationName', 255);
			$table->string('Longitude', 255)->nullable();
			$table->string('Latitude', 255)->nullable();
			$table->string('Weather')->nullable();
			$table->string('WeatherDetails')->nullable();
			$table->unsignedBiginteger('Package_id')->index();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tourlocations');
	}

}
