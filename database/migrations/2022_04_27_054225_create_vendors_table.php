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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string("vendor_name");
            $table->string("contact_person_name");
            $table->string("address")->nullable();
            $table->string("email")->nullable();
            $table->bigInteger("phone_no")->nullable();
            $table->bigInteger("mobile_no");
            // $table->string("GST");
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
        Schema::dropIfExists('vendors');
    }
};
