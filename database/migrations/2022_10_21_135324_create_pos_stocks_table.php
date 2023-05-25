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
        Schema::create('pos_stocks', function (Blueprint $table) {
            $table->id()->unique();
            $table->bigInteger('owner_id');
            $table->bigInteger('product_id');
            $table->string('product_name');
            $table->string('product_variant');
            $table->decimal('unit_price',20,2);
            $table->longtext('barcode');
            $table->string('quantity');
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
        Schema::dropIfExists('pos_stocks');
    }
};
