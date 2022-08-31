<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaGroupPivotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_group_pivots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id'); 
            $table->integer('sub_locality_id'); 
            $table->foreign('group_id')->references('id')->on('area_groups')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('area_group_pivots');
    }
}
