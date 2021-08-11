<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('usertype');
            $table->string('profile_pic')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_url')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('other_mobile_number');
            $table->string('landline_number')->nullable();
            $table->longText('company_profile')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('aadhar_number')->nullable();
            $table->string('provided_service')->nullable();
            $table->string('place_of_practice')->nullable();
            $table->string('price_for_service')->nullable();
            $table->string('law_firm_number')->nullable();
            $table->string('practice_number')->nullable();
            $table->boolean('blocked')->default(0);
            $table->boolean('phone_number_verification_status')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
