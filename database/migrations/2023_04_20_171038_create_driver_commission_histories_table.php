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
        Schema::create('driver_commission_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('user_table_id');
            $table->integer('driver_table_id');
            $table->string('consolidate_order_no');
            $table->date('delivery_date');
            $table->string('commission');
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
        Schema::dropIfExists('driver_commission_histories');
    }
};
