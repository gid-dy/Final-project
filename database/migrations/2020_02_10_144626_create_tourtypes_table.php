<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTourtypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tourtypes', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->string('TourTypeName', 25);
			$table->biginteger('TourTypeSize');
			$table->string('SKU', 25)->nullable();
			$table->decimal('PackagePrice', 20, 2);
			$table->unsignedBiginteger('Package_id')->index('RefTourPackages28');
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
		Schema::drop('tourtypes');
	}

}
