<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansRentOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans_rent_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('user_email')->nullable();
            $table->string('order_id')->unique();
            $table->string('plan_type');
            $table->string('plan_name');
            $table->string('plan_id');
            $table->string('payment_type');
            $table->bigInteger('expected_rent');
            $table->integer('plan_price');
            $table->decimal('gst_amount')->nullable();
            $table->integer('maintenance_charge')->nullable();
            $table->bigInteger('security_deposit')->nullable();
            $table->decimal('total_amount')->nullable();
            $table->string('payment_status')->nullable();
            $table->bigInteger('amount_paid')->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('transaction_status')->nullable();
            $table->string('invoice_no')->unique()->nullable();
            $table->string('property_name')->nullable();
            $table->integer('property_id');
            $table->string('property_uid')->nullable();
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
        Schema::dropIfExists('plans_rent_orders');
    }
}
