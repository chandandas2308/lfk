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
        Schema::create('pos__orders', function (Blueprint $table) {
            $table->id();
            $table->string("order_no");
            $table->string("user_id");
            $table->string("product_id");
            $table->string("unit_price");
            $table->string("quantity");
            $table->string("discount")->nullable();
            $table->string("total");
            $table->string("customer_name")->nullable();
            $table->string("customer_id")->nullable();
            $table->integer("status")->default(0);
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
        Schema::dropIfExists('pos__orders');
    }
};
