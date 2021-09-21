<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_features', function (Blueprint $table) {
            $table->id();
            $table->string('feature_id');
            $table->string('feature_name');
            $table->string('plan_id');
            $table->foreign('plan_id')->references('plan_ID')->on('rent_plans');
            $table->text('feature_details');
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
        Schema::dropIfExists('rent_features');
    }
}
