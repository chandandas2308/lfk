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
        Schema::create('user_order_items', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('consolidate_order_no');
            $table->string('order_no');
            $table->integer('product_id');
            $table->string('product_name');
            $table->longText('product_image');
            $table->longText('barcode');
            $table->integer('quantity');
            $table->double('product_price',20,2);
            $table->double('total_price',20,2);
            $table->integer('points')->nullable();
            $table->string('coupon_code')->nullable();
            $table->double('discount_amount',20,2)->nullable();
            $table->double('coupon_amount',20,2)->nullable();
            $table->string('coupon_type')->nullable();
            $table->double('after_discount',20,2)->nullable();
            $table->double('offer_discount_price',20,2)->default(0.00)->nullable();
            $table->double('offer_discount_percentage',20,2)->default(0.00)->nullable();
            $table->string('offer_discount_type')->nullable();
            $table->double('offer_discount_face_value')->nullable()->default(0.00); 
            $table->string('offer_name')->nullable();
            $table->double('final_price_with_coupon_offer');
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
        Schema::dropIfExists('user_order_items');
    }
};