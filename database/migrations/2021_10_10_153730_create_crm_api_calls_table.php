<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmApiCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_api_calls', function (Blueprint $table) {
            $table->id();
            $table->string('response_body');
            $table->boolean('response_client_error');
            $table->boolean('response_fail');
            $table->boolean('response_server_error');
            $table->string('response_status');
            $table->boolean('response_success');
            $table->dateTime('request_time');
            $table->dateTime('response_time');
            $table->string('user_email');
            $table->string('user_phone');
            $table->string('user_name');
            $table->string('source');
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
        Schema::dropIfExists('crm_api_calls');
    }
}
