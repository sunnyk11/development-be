<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBankInfoToUserBankDetailsHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_bank_details_histories', function (Blueprint $table) {
            $table->string('bank_type')->after('mobile_no')->nullable();
            $table->string('upi_name')->after('bank_type')->nullable();
            $table->string('upi_id')->after('upi_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_bank_details_histories', function (Blueprint $table) {
            //
        });
    }
}
