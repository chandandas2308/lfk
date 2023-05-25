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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string("owner_id");
            $table->integer("customer_id");
            $table->string("quotation_id");
            $table->string("customer_name");
            $table->date("expiration");
            $table->string("customer_address");
            $table->string("payment_terms");
            $table->json("products_details");
            $table->boolean("tax_inclusive");
            $table->string("untaxted_amount",20,2);
            $table->string("GST")->nullable();
            $table->string("gstValue",20,2)->nullable();
            $table->string("status")->nullable();
            $table->string("note")->nullable();
            $table->string("sub_total",20,2);
            $table->string("invoicestatus")->nullable();
            $table->string("display")->nullable();
            $table->string("orderID")->nullable();
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
        Schema::dropIfExists('quotations');
    }
};
