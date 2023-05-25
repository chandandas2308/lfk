<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('owner_id');
            $table->string('order_by');
            // $table->string('sales_order_id');
            $table->string('quotation_id')->nullable();
            $table->string('order_number')->nullable();
            $table->string('customer_name');
            $table->integer('customer_id');
            $table->date('date');
            $table->string('customer_address')->nullable();
            $table->string('shipping_type')->nullable();
            $table->string('customer_type');
            $table->string('mobile_no');
            $table->string('email_id')->nullable();
            $table->integer("tax");
            $table->json("products_details");
            $table->boolean("tax_inclusive");
            $table->string("untaxted_amount");
            $table->string ("invoice_status")->nullable();
            $table->string("GST")->nullable();
            $table->string("sub_total");
            $table->string("invoicestatus")->nullable();
            $table->string("display")->nullable();
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
        Schema::dropIfExists('orders');
    }
};
