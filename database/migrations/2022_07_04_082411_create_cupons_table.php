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
        Schema::create('cupons', function (Blueprint $table) {
            $table->id();
            $table->integer('owner_id');
            $table->string('coupon');
            $table->string('coupon_type');
            $table->string('face_value');
            $table->integer('no_of_coupon');
            $table->integer('no_of_used_coupon')->nullable();
            $table->integer('limit');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('coupon_desc')->nullable();
            $table->string('merchendise_btn');
            $table->json('merchendise');
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
        Schema::dropIfExists('cupons');
    }
};
