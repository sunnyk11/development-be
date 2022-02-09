<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaSubLocalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_sub_localities', function (Blueprint $table) {
            $table->id('sub_locality_id');
            $table->string('sub_locality');
            $table->unsignedBigInteger('locality_id');
            $table->enum('status', ['0', '1'])->default('1');
            $table->foreign('locality_id')->references('locality_id')->on('area_localities')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('area_sub_localities');
    }
}
