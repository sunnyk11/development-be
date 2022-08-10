<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminPaymentSummeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_payment_summeries', function (Blueprint $table) {
            $table->id();
            $table->longText('transaction_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->string('payment_image')->nullable();
            $table->string('amount')->nullable();
            $table->unsignedBigInteger('created_user');
            $table->string('payment_status')->nullable();
            $table->string('property_owner')->nullable();
            $table->longText('message')->nullable();
            $table->longText('bank_details_json')->nullable();
            $table->enum('status', ['0', '1'])->default('1');

            $table->foreign('created_user')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade');
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
        Schema::dropIfExists('admin_payment_summeries');
    }
}
