<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings_packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('Booking_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('Package_id');
            $table->string('PackageName', 150);
            $table->string('PackageCode', 20);
            $table->BigInteger('Travellers');
            $table->string('TourTypeName', 25);
			$table->decimal('PackagePrice', 20, 2);
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
        Schema::dropIfExists('bookings_packages');
    }
}
