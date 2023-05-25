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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('customer_name');
            $table->string('inv_no');            
            $table->string('invoice_no');            
            $table->decimal('amount',20,2);
            $table->decimal('partialamount',20,2)->nullable();
            $table->decimal('paid_amount',20,2)->nullable();
            $table->decimal('pending_amt',20,2)->nullable();
            $table->string('invoice_date');
            $table->string('payment_type');
            $table->string('payment_date');
            $table->string('payment_status');
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
        Schema::dropIfExists('payments');
    }
};
