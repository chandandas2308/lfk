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
        Schema::create('track_stock_deduct_details', function (Blueprint $table) {
            $table->id('track_stock_deduct_details_id');
            $table->string('consolidate_order_no');
            $table->string('order_no');
            $table->integer('warehouse_id')->nullable();
            $table->string('warehouse_name');
            $table->integer('user_id');
            $table->integer('product_id');
            $table->integer('deduct_quantity');
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
        Schema::dropIfExists('track_stock_deduct_details');
    }
};
