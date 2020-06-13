<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('UserEmail', 100);
            $table->string('SurName', 150);
            $table->string('OtherNames', 150);
            $table->string('Address');
            $table->string('City');
            $table->string('State');
            $table->string('Country');
            $table->string('Mobile', 15);
            $table->string('OtherContact', 15);
            $table->string('CouponCode', 20);
			$table->decimal('Amount', 20, 2);
            $table->string('Status', 25);
            $table->string('Payment_method', 255);
			$table->float('Grand_total', 20);
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
        Schema::dropIfExists('bookings');
    }
}
