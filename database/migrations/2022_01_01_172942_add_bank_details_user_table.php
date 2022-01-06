<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBankDetailsUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('account_holder')->after('profile_pic')->nullable();
            $table->string('bank_acount_no')->after('account_holder')->nullable();
            $table->string('ifsc_code')->after('bank_acount_no')->nullable();
            $table-> enum('account_status', ['0', '1'])->default('0')->after('ifsc_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
