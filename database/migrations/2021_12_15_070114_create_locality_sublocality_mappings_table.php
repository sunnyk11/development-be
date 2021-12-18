<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalitySublocalityMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locality_sublocality_mappings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('locality_id');
            $table->string('user_id');
            $table->string('sub_locality_id');
            $table->enum('status', ['0', '1'])->default('1');
            $table->foreign('locality_id')->references('id')->on('district_locality_mappings')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('user_id')->on('service_userlists')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('locality_sublocality_mappings');
    }
}
