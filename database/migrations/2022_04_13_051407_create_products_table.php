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
        Schema::create('products', function (Blueprint $table) {
            $table->id()->unique();
            $table->bigInteger('owner_id');
            $table->string('productId')->nullable();
            $table->string('product_name');
            $table->string('chinese_product_name');
            $table->longText('barcode');
            $table->longText('description')->nullable();
            $table->string('product_varient');
            $table->boolean('featured_product');
            $table->string('product_category');
            $table->integer('category_id')->nullable();
            $table->string('img_path')->nullable();
            $table->json('images')->nullable();
            $table->string('uom');
            $table->string('barcode_id')->nullable();
            $table->string('sku_code')->nullable();
            $table->string('batch_code')->nullable();
            $table->string('min_sale_price');
            $table->integer('tax')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->string('supplier_code')->nullable();
            $table->string('discount_price')->nullable();
            $table->string('discount_name')->nullable();
            $table->string('discount_type')->nullable();
            $table->string('discount_face_value')->nullable();
            $table->string('discount_start_date')->nullable();
            $table->string('discount_end_date')->nullable();
            $table->string('discount_percentage')->nullable();
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
        Schema::dropIfExists('products');
    }
};
