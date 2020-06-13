<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetaTitleToTourpackagecategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tourpackagecategories', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('CategoryDescription');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tourpackagecategories', function (Blueprint $table) {
            //
        });
    }
}
