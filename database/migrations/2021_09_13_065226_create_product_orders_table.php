<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_orders', function (Blueprint $table) {
            $table->id();
            $table->string('product_id');
            $table->integer('user_id');
            $table->string('user_email');
            $table->string('orderId')->unique();
            $table->string('plans_type')->nullable();
            $table->string('transaction_status')->nullable();
            $table->enum('status', ['0', '1'])->default('1');
            $table->foreign('user_email')->references('email')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_id')->references('product_uid')->on('products')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('product_orders');
    }
}
