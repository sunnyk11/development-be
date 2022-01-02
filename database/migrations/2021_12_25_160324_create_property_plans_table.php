<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_plans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_name');
            $table->string('plan_type');
            $table->enum('payment_type', ['Advance', 'Post']);
            $table->integer('actual_price_days');
            $table->boolean('discount');
            $table->integer('discounted_price_days')->nullable();
            $table->unsignedDecimal('discount_percentage')->nullable();
            $table->enum('special_tag', ['yes', 'no']);
            $table->enum('plan_status', ['enabled', 'disabled']);
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
        Schema::dropIfExists('property_plans');
    }
}
