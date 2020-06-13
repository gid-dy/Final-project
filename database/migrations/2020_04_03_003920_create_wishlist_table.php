<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wishlist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBiginteger('Package_id');
            $table->string('PackageName', 150);
            $table->string('PackageCode', 20);
            $table->string('TourTypeName', 25);
            $table->integer('Travellers');
            $table->decimal('PackagePrice',20,2);
            $table->string('TransportName', 50);
            $table->string('UserEmail',100);
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
        Schema::dropIfExists('wishlist');
    }
}
