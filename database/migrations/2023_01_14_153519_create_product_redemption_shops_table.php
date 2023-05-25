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
        Schema::create('product_redemption_shops', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->integer('product_id')->nullable();
            $table->string('product_category');
            $table->string('product_variant');
            $table->string('vendor_id')->nullable();;
            $table->string('sku_code')->nullable();;
            $table->string('uom');
            $table->string('points');
            $table->integer('quantity');
            $table->json('images');
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
        Schema::dropIfExists('product_redemption_shops');
    }
};
