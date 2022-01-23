<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsDaysORproioty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_plan_features', function (Blueprint $table) {
            $table->integer('client_visit_priority')->after('discount_percentage')->nullable();
             $table->integer('product_plans_days')->after('client_visit_priority')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_plan_features', function (Blueprint $table) {
            //
        });
    }
}
