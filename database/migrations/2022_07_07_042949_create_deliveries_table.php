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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->integer('owner_id');
            $table->string('order_no')->nullable();
            $table->bigInteger('mobile_no')->nullable();
            $table->string('customer_name')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('address_id');
            $table->date('date')->nullable();
            $table->string('delivery_address')->nullable();
            $table->string('delivery_man')->nullable();
            $table->integer('delivery_man_id')->nullable();
            $table->integer('delivery_man_user_id')->nullable();
            $table->string('delivery_status')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('warehouse_name')->nullable();
            $table->string('warehouse_id')->nullable();
            $table->string('pickup_address')->nullable();
            $table->string('description')->nullable();
            $table->json('product_details');
            $table->json('remark')->nullable();
            $table->string('signature')->nullable();
            $table->timestamp('delivered_date_time')->nullable();
            $table->string('delivered_payment_method')->nullable();
            $table->longText('delivered_online_payment_image')->nullable();

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
        Schema::dropIfExists('deliveries');
    }
};