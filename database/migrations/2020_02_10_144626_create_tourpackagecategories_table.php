<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTourpackagecategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tourpackagecategories', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->string('CategoryName', 100);
			$table->string('CategoryDescription', 100)->nullable();
			$table->boolean('CategoryStatus')->nullable();
			$table->string('Imageaddress', 4000)->nullable();
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
		Schema::drop('tourpackagecategories');
	}

}
