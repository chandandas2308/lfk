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
        Schema::create('user_order_payments', function (Blueprint $table) {
            $table->id();
            $table->string('consolidate_order_no');
            $table->integer('user_id');
            $table->string('payment_id')->nullable();
            $table->string('payment_request_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('buyer_name')->nullable();
            $table->string('buyer_phone')->nullable();
            $table->string('buyer_email')->nullable();
            $table->string('amount')->nullable();
            $table->integer('points')->nullable();
            $table->string('currency')->nullable();
            $table->string('status')->nullable();
            $table->string('fees')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('hmac')->nullable();
            $table->dateTime('time')->nullable();
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
        Schema::dropIfExists('user_order_payments');
    }
};