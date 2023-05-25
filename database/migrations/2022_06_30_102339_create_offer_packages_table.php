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
        Schema::create('offer_packages', function (Blueprint $table) {
            $table->id();
            $table->integer('owner_id');
            $table->string('offer_name');
            $table->string('offer')->nullable();
            $table->string('offer_type');
            $table->string('face_value');
            $table->integer('no_of_offers')->nullable();
            $table->integer('no_of_used_offer')->nullable();
            $table->integer('limit')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('offer_desc')->nullable();
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
        Schema::dropIfExists('offer_packages');
    }
};