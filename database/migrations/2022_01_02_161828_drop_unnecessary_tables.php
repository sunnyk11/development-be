<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUnnecessaryTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('service_provider');
        Schema::dropIfExists('sub_localities');
        Schema::dropIfExists('localities');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('states');
        //Schema::dropIfExists('localareas');
        Schema::dropIfExists('admins');
        //Schema::dropIfExists('areas');
        //Schema::dropIfExists('area_service_users');
        Schema::dropIfExists('lawyers');
        Schema::dropIfExists('let_out_features');
        Schema::dropIfExists('let_out_plans');
        Schema::dropIfExists('let_out_plans_news');
        Schema::dropIfExists('loans');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('product_transactions');
        Schema::dropIfExists('rent_features');
        Schema::dropIfExists('rent_plans');
        Schema::dropIfExists('requirements');
        Schema::dropIfExists('service_img_reviews');
        Schema::dropIfExists('product_orders');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
