<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserServiceMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_service_mappings', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('service_id');
            $table->enum('status', ['0', '1'])->default('1');
            $table->foreign('user_id')->references('user_id')->on('service_userlists')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('service_id')->references('service_id')->on('area_services')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('user_service_mappings');
    }
}
