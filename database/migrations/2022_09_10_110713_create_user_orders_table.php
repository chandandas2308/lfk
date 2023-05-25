<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('payment_id');
            $table->string('payment_reference_id');
            $table->string('order_no');
            $table->string('consolidate_order_no');            
            $table->double('total_product_price',20,2);
            $table->integer('points')->nullable();
            $table->double('ship_charge',20,2);
            $table->string('coupon_code')->nullable();
            $table->string('voucher_code')->nullable();
            $table->double('discount_amount',20,2)->nullable()->default(0.00);
            $table->double('coupon_amount',20,2)->nullable()->default(0.00);
            $table->string('coupon_type')->nullable();
            $table->double('final_price',20,2);
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('mobile_no');
            $table->integer('address_id');
            $table->string('address');
            $table->string('city');
            $table->string('postcode');
            $table->string('unit');
            $table->string('country');
            $table->string('state');
            $table->integer('status');
            $table->dateTime('end_date')->nullable();
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
        Schema::dropIfExists('user_orders');
    }
};