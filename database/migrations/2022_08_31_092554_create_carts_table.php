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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('product_id');
            $table->string('product_name')->nullable();
            $table->string('product_price')->nullable();
            $table->string('product_cat')->nullable();
            $table->longText('barcode');
            $table->string('use_id');
            $table->string('use_name');
            $table->string('quantity');
            $table->string('total_price')->nullable();

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
        Schema::dropIfExists('carts');
    }
};
