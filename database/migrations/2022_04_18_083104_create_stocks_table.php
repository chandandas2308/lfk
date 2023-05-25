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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('owner_id');
            $table->string('warehouse_name');
            $table->string('rack')->nullable();
            $table->string('product_name');
            $table->integer('product_id');
            $table->string('product_varient');
            $table->string('product_category');
            $table->date('return_and_exchanges_date')->nullable();
            $table->integer('quantity');
            $table->string('batch_code');
            $table->string('expiry_date')->nullable();
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
        Schema::dropIfExists('stocks');
    }
};
