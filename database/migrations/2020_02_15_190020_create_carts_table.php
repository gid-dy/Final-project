<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBiginteger('Package_id')->index('RefTourPackages5');
            $table->string('PackageName', 150)->index('RefTourPackages51');
            $table->string('PackageCode', 20)->index('RefTourPackages21');
            $table->string('TourTypeName', 25);
            $table->integer('Travellers');
            $table->decimal('PackagePrice',20,2);
            $table->string('TransportName', 50);
            $table->string('UserEmail',100);
            $table->string('Session_id', 255);
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
        Schema::dropIfExists('carts');
    }
}
