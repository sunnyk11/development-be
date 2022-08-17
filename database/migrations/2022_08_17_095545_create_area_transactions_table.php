<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('table_name');
            $table->string('old_column')->nullable();
            $table->string('new_column')->nullable();
            $table->string('action')->nullable();
            $table->unsignedBigInteger('updated_user'); 
            $table->enum('status', ['0', '1'])->default('1');
            $table->foreign('updated_user')->references('id')->on('users');
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
        Schema::dropIfExists('area_transactions');
    }
}
