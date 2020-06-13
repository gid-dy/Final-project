<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('SurName', 150);
            $table->string('UserEmail', 100)->unique('UserEmail');
			$table->string('OtherNames', 150);
            $table->string('Mobile', 15);
            $table->string('OtherContact', 150);
            $table->string('Country', 150);
            $table->string('Address', 150);
            $table->string('City', 150);
            $table->string('State', 150);
            $table->string('ZipCode', 150);
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
        Schema::dropIfExists('travel_addresses');
    }
}
