<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_groups', function (Blueprint $table) {
            $table->id(); 
            $table->string('group_name');
            $table->unsignedBigInteger('created_user'); 
            $table->enum('status', ['0', '1'])->default('1');
            $table->foreign('created_user')->references('id')->on('users');
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
        Schema::dropIfExists('area_groups');
    }
}
