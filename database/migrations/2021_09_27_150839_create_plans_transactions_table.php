<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('MID');
            $table->string('transaction_id');
            $table->string('transaction_amount');
            $table->string('transaction_date')->nullable();
            $table->string('transaction_status');
            $table->integer('respcode');
            $table->longText('resp_message');
            $table->string('gatewayname')->nullable();
            $table->string('bank_txn_id')->nullable();
            $table->string('bank_name')->nullable();
            $table->longText('checksumhash');
            $table->string('paymentmode')->nullable();
            $table->string('currency');
            $table->string('retryAllowed')->nullable();
            $table->longText('errorMessage')->nullable();
            $table->integer('errorCode')->nullable();
            $table->enum('status', ['0', '1'])->default('1');
            $table->foreign('order_id')->references('order_id')->on('plans_orders')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('plans_transactions');
    }
}
