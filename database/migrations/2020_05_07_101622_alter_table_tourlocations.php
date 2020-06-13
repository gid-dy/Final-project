<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTourlocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tourlocations', function (Blueprint $table) {
            $table->bigInteger('Package_id')->nullable()->unsigned()->change();

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
        Schema::table('tourlocations', function (Blueprint $table) {
            //
        });
    }
}
