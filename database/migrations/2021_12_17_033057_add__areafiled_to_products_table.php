<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAreafiledToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('address_details')->after('view_counter')->nullable();
            $table->unsignedBigInteger('state_id')->after('address')->nullable();
            $table->foreign('state_id')->references('state_id')->on('area_states')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('district_id')->after('state_id')->nullable();
            $table->foreign('district_id')->references('district_id')->on('area_districts')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('locality_id')->after('district_id')->nullable();
            $table->foreign('locality_id')->references('locality_id')->on('area_localities')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('sub_locality_id')->after('locality_id')->nullable();
            $table->foreign('sub_locality_id')->references('sub_locality_id')->on('area_sub_localities')->onDelete('cascade')->onUpdate('cascade');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
}
