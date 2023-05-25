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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('consolidate_order_no');
            $table->string('order_no')->nullable();
            $table->integer('address_id');
            $table->string('postcode');
            $table->string('payment_mode');
            $table->integer('user_id');
            $table->string('end_date')->nullable();
            $table->string('delivery_date')->nullable();
            $table->string('remark')->nullable();
            $table->string('status')->default('Ongoing')->comment('Canceled|Ongoing');
            $table->timestamp('delivered_date_time')->nullable();
            $table->string('delivered_payment_method')->nullable();
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
        Schema::dropIfExists('notifications');
    }
};
