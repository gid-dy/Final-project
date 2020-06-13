<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTourtransportations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tourtransportations', function (Blueprint $table) {
            $table->bigInteger('Package_id')->nullable()->unsigned()->after('id');

            $table->foreign('Package_id','RefTourPackages20')->references('id')->on('tourpackages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tourtransportations', function (Blueprint $table) {
            //
        });
    }
}
