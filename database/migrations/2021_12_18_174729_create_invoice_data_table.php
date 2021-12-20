<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_data', function (Blueprint $table) {
            $table->id();
            $table->string('gstin')->nullable();
            $table->string('pan_no')->nullable();
            $table->unsignedBigInteger('mobile_no')->nullable();
            $table->string('email')->nullable();
            $table->string('website_address')->nullable();
            $table->text('address')->nullable();
            $table->string('cin')->nullable();
            $table->string('sac')->nullable();
            $table->integer('sgst')->nullable();
            $table->integer('cgst')->nullable();
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
        Schema::dropIfExists('invoice_data');
    }
}
