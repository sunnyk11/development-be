<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_logs', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('system_ip');
            $table->string('device_info');
            $table->string('browser_info');
            $table->string('type');
            $table->string('user_email')->nullable();
            $table->longText('input_info')->nullable();
            $table->longText('user_cart')->nullable();
            $table->enum('status', ['0', '1'])->default('1');
             $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade');
            $table->foreign('user_email')->references('email')->on('users')->onUpdate('cascade');
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
        Schema::dropIfExists('user_logs');
    }
}
