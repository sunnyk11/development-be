<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLetOutPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('let_out_plans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_name');
            $table->string('plan_ID')->unique();
            $table->string('payment_type');
            $table->integer('plan_price');
            $table->string('status');
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
        Schema::dropIfExists('let_out_plans');
    }
}