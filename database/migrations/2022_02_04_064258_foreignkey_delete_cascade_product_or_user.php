<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ForeignkeyDeleteCascadeProductOrUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_product_counts', function (Blueprint $table) {
             $table->dropForeign(['user_id']);
             $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
             $table->dropForeign(['product_id']);
             $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_product_counts', function (Blueprint $table) {
            //
        });
    }
}
