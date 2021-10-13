<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique();
            $table->string('plan_name');
            $table->string('plan_id');
            $table->string('plan_type');
            $table->string('payment_type');
            $table->string('order_id')->unique();
            $table->bigInteger('expected_rent');
            $table->integer('plan_price');
            $table->string('payment_status');
            $table->bigInteger('amount_paid')->nullable();
            $table->string('transaction_status')->nullable();
            $table->string('user_email');
            $table->integer('user_id');
            $table->dateTime('invoice_generated_date');
            $table->dateTime('invoice_paid_date')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
