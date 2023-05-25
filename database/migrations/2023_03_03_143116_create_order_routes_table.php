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
        Schema::create('order_routes', function (Blueprint $table) {
            $table->id();
            $table->string('consolidate_order_no')->nullable();
            $table->integer('driver_id');
            $table->integer('placement_id');
            $table->longText('address');
            $table->string('delivery_date');
            $table->longText('lat');
            $table->longText('lng');
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
        Schema::dropIfExists('order_routes');
    }
};
