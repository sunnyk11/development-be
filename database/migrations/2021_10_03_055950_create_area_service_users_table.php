<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaServiceUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_service_users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique();
            $table->string('user_name');
            $table->string('contact');
            $table->string('service_id');
            $table->enum('status', ['0', '1'])->default('1');
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
        Schema::dropIfExists('area_service_users');
    }
}
