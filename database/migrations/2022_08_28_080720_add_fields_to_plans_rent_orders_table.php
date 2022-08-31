<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToPlansRentOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans_rent_orders', function (Blueprint $table) {
             $table->string('choose_payment_type')->after('payment_mode')->default('purchase_property');
              $table->integer('payment_percentage')->after('choose_payment_type')->default(100);
             $table->integer('agreement_price')->after('plan_price')->nullable();
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans_rent_orders', function (Blueprint $table) {
            //
        });
    }
}
