<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableBookingsPackages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings_packages', function (Blueprint $table) {

            $table->bigInteger('Booking_id')->nullable()->unsigned()->after('id');

            $table->foreign('Booking_id')->references('id')->on('bookings');

            $table->bigInteger('user_id')->nullable()->unsigned()->after('Booking_id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('Package_id')->nullable()->unsigned()->after('user_id');

            $table->foreign('Package_id')->references('id')->on('tourpackages');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings_packages', function (Blueprint $table) {
            //
        });
    }
}
