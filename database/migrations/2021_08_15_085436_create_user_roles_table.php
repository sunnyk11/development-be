<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->string('role');
            $table->string('role_id');
            $table->string('access_all_users');
            $table->string('access_properties');
            //$table->string('access_requirements');
            $table->string('access_reviews');
            $table->string('access_lawyer_services');
            $table->string('access_loan_control');
            $table->string('access_user_creator');
            $table->string('access_manage_blog');
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
        Schema::dropIfExists('user_roles');
    }
}
