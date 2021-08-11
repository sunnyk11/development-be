<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('view_counter')->default('0');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('rent_cond')->nullable();
            $table->string('rent_availability')->nullable();
            $table->string('sale_availability')->nullable();
            $table->string('possession_by')->nullable();
            $table->string('locality')->nullable();
            $table->boolean('display_address')->nullable();
            $table->string('ownership')->nullable();
            $table->string('expected_pricing')->nullable();
            $table->longText('inclusive_pricing_details')->nullable();
            $table->boolean('tax_govt_charge')->nullable();
            $table->boolean('price_negotiable')->nullable();
            $table->boolean('maintenance_charge_status')->nullable();
            $table->string('maintenance_charge')->nullable();
            $table->string('maintenance_charge_condition')->nullable();
            $table->string('deposit')->nullable();
            $table->string('available_for')->nullable();
            $table->string('brokerage_charges')->nullable();
            $table->string('type')->nullable();
            $table->string('product_image1')->nullable();
            $table->string('product_image2')->nullable();
            $table->string('product_image3')->nullable();
            $table->string('product_image4')->nullable();
            $table->string('product_image5')->nullable();
            $table->string('bedroom')->nullable();
            $table->string('bathroom')->nullable();
            $table->string('balconies')->nullable();
            $table->string('additional_rooms')->nullable();
            $table->string('furnishing_status')->nullable();
            $table->json('furnishings')->nullable();
            $table->string('total_floors')->nullable();
            $table->string('property_on_floor')->nullable();
            $table->string('rera_registration_status')->nullable();
            $table->json('amenities')->nullable();
            $table->string('facing_towards')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('additional_parking_status')->nullable();
            $table->integer('parking_covered_count')->nullable();
            $table->integer('parking_open_count')->nullable();
            $table->string('availability_condition')->nullable();
            $table->string('buildyear')->nullable();
            $table->string('age_of_property')->nullable();
            $table->string('expected_rent')->nullable();
            $table->boolean('inc_electricity_and_water_bill')->nullable();
            $table->string('security_deposit')->nullable();
            $table->string('duration_of_rent_aggreement')->nullable();
            $table->string('month_of_notice')->nullable();
            $table->string('equipment')->nullable();
            $table->string('features')->nullable();
            $table->string('nearby_places')->nullable();
            $table->string('area')->nullable();
            $table->string('area_unit')->nullable();
            $table->string('carpet_area')->nullable();
            $table->longText('property_detail')->nullable();
            $table->string('build_name')->nullable();
            $table->string('willing_to_rent_out_to')->nullable();
            $table->string('agreement_type')->nullable();
            $table->string('nearest_landmark')->nullable();
            $table->string('map_latitude')->nullable();
            $table->string('map_longitude')->nullable();
            $table->boolean('delete_flag')->default(0);
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
        Schema::dropIfExists('products');
    }
}
