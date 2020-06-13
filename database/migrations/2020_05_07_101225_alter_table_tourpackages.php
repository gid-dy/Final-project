<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTourpackages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tourpackages', function (Blueprint $table) {
            $table->bigInteger('Category_id')->nullable()->unsigned()->change();

            $table->foreign('Category_id','RefTourPackageCategories4')->references('id')->on('tourpackagecategories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tourpackages', function (Blueprint $table) {
            //
        });
    }
}
