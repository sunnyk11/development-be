<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('bedroom')->nullable()->change();
            $table->integer('bathroom')->nullable()->change();
            $table->integer('balconies')->nullable()->change();
            $table->integer('duration_of_rent_aggreement')->nullable()->change();
            $table->integer('area_unit')->nullable()->change();
            $table->integer('willing_to_rent_out_to')->nullable()->change();
            $table->integer('agreement_type')->nullable()->change();
            $table->integer('maintenance_charge_condition')->nullable()->change();
            
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
