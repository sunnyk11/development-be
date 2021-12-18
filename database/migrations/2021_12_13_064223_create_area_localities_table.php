<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaLocalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_localities', function (Blueprint $table) {
            $table->id('locality_id');
            $table->string('locality');
            $table->unsignedBigInteger('district_id');
            $table->enum('status', ['0', '1'])->default('1');
            $table->foreign('district_id')->references('district_id')->on('area_districts')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('area_localities');
    }
}
