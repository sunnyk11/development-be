<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans_features', function (Blueprint $table) {
            $table->id();
            $table->string('feature_name');
            $table->string('feature_details');
            $table->integer('feature_value')->nullable();
            $table->string('feature_value_text')->nullable();
            $table->enum('more_info_status', ['0', '1']);
            $table->unsignedBigInteger('more_info_id')->nullable();
            $table->enum('status', ['enabled', 'disabled']);
            $table->foreign('more_info_id')->references('id')->on('more_infos')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('plans_features');
    }
}
