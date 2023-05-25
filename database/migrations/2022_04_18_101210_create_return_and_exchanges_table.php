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
        Schema::create('return_and_exchanges', function (Blueprint $table) {
            $table->id();            
            $table->string('owner_id');
            $table->string('type');
            $table->string('invoice_no');
            $table->string('both_sale_pur');
            $table->string('user_id');
            $table->string('user_name');
            $table->date('invoice_date');
            $table->date('date')->nullable();
            $table->string('invoice_amount');
            $table->json('orders');
            $table->json('zeroInvoiceOrders')->nullable();
            $table->timestamps();
        });
    }

    // $table->string('product_id');
    //         $table->string('product_name');
    //         $table->string('product_quantity');
    //         $table->string('rate');
    //         $table->string('total_amount');
    //         $table->string('status');
    //         $table->string('return_exchange_qty');
    //         $table->string('remark')->nullable();

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('return_and_exchanges');
    }
};