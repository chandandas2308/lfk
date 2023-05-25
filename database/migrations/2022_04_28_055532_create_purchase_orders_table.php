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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('quotation_no')->nullable();
            $table->string('qut_no')->nullable();
            $table->string('order_no')->nullable();
            $table->string('ord_no')->nullable();
            $table->integer('vendor_id');
            $table->string('vendor_name');
            $table->date('receipt_date');
            $table->string('vendor_reference');
            $table->string('billing_status');
            $table->string('confirmation')->nullable();
            $table->integer('tax')->nullable();
            $table->json('products');
            $table->string('notes')->nullable();
            $table->string('untaxted_amount');
            $table->boolean('tax_inclusive');
            $table->string('GST')->nullable();
            $table->string('total');
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
        Schema::dropIfExists('purchase_orders');
    }
};
