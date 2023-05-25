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
        Schema::create('sales_invoices', function (Blueprint $table) {
            $table->id();
            // $table->string('invoice_no');
            $table->string('quot_no')->nullable();
            $table->string('quotation_no')->nullable();
            $table->string('inv_no')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('customer_name');
            $table->string('customer_id');
            $table->date('invoice_date');
            $table->string('payment_ref');
            $table->date('due_date')->nullable();
            $table->string('status')->nullable();
            $table->integer('tax')->nullable();
            $table->boolean('tax_inclusive');
            $table->json('products');
            $table->float('untaxed_amount');
            $table->float('GST')->nullable();
            $table->decimal('partial_amount', 20,2)->nullable();
            $table->decimal('paid_amount', 20,2)->nullable();
            $table->decimal('pending_amount', 20,2)->nullable();
            $table->float('total');
            $table->string("payment_status")->nullable();
            $table->string("note")->nullable();
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
        Schema::dropIfExists('sales_invoices');
    }
};
