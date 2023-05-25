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
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
            $table->integer('address_id')->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('loyalty_points')->nullable();
            $table->decimal('sub_total',20,2)->nullable();
            $table->decimal('shipping_charge',20,2)->nullable();
            $table->decimal('final_price',20,2)->nullable();
            $table->decimal('discount_value',20,2)->default(0)->nullable();
            $table->decimal('total_offer_discount',20,2)->default(0)->nullable();
            $table->string('coupon')->nullable();
            $table->string('delivery_date')->nullable();
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('sessions');
    }
};
