<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageimagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packageimages', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('Image', 4000);
			$table->string('PackageImageName', 50)->nullable();
			$table->unsignedBiginteger('Package_id')->index('RefTourPackages3');
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
        Schema::dropIfExists('packageimages');
    }
}
