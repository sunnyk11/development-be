<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalareasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('localareas', function (Blueprint $table) {
            $table->id();
            $table->string('loc_area_id')->unique();;
            $table->string('local_area');
            $table->unsignedBigInteger('Area_id');
            $table->enum('status', ['0', '1'])->default('1');
            $table->foreign('Area_id')->references('id')->on('areas')->onDelete('cascade')->onUpdate('cascade');;
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
        Schema::dropIfExists('localareas');
    }
}
