<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubLocalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_localities', function (Blueprint $table) {
            $table->id('sub_locality_id');
            $table->string('sub_locality');
            $table->unsignedBigInteger('locality_id');
            $table->boolean('status')->default(true);
            $table->foreign('locality_id')->references('locality_id')->on('localities')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('sub_localities');
    }
}
