<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_districts', function (Blueprint $table) {
            $table->id('district_id');
            $table->string('district');
            $table->unsignedBigInteger('state_id');
            $table->enum('status', ['0', '1'])->default('1');
            $table->foreign('state_id')->references('state_id')->on('area_states')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('area_districts');
    }
}
