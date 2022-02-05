<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUnnessaryTablesFinalVersion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('service_user_reviews');
        Schema::dropIfExists('area_service_users');
        Schema::dropIfExists('localareas');
        Schema::dropIfExists('areas');
        Schema::dropIfExists('favourites');
        Schema::dropIfExists('last_searched_properties');
        Schema::dropIfExists('savedsearches');
        Schema::dropIfExists('user_feedbacks');
        Schema::dropIfExists('user_service_providers');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
