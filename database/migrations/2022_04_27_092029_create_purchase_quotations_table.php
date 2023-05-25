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
        Schema::create('purchase_quotations', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id');
            $table->string('vendor_name');
            $table->string('purchase_requisition');
            $table->date('receipt_date');
            $table->string('vendor_reference');
            $table->string('confirmation')->nullable();
            $table->json('products');
            $table->string('note')->nullable();
            $table->string('untaxted_amount');
            $table->string('GST')->nullable();
            $table->string('gstpercentage')->nullable();
            $table->boolean("tax_inclusive");
            $table->string('total');
            $table->string('order_status')->nullable();
            $table->string('display')->nullable();
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
        Schema::dropIfExists('purchase_quotations');
    }
};
