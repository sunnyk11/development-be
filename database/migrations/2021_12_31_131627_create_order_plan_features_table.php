<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPlanFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_plan_features', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->integer('plan_id');
            $table->string('plan_name');
            $table->string('plan_type');
            $table->enum('plan_status', ['enabled', 'disabled']);
            $table->enum('payment_type', ['Advance', 'Post']);
            $table->enum('special_tag', ['yes', 'no']);
            $table->integer('actual_price_days');
            $table->boolean('discount_status');
            $table->integer('discounted_price_days')->nullable();
            $table->decimal('discount_percentage')->nullable();
            $table->dateTime('plan_created_at');
            $table->dateTime('plan_updated_at');
            $table->json('features');
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
        Schema::dropIfExists('order_plan_features');
    }
}
