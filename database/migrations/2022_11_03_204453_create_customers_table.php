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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->nullable();
            $table->string('customer_type')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('address')->nullable();
            $table->string('fb_id')->nullable();
            $table->string('image')->nullable();
            $table->bigInteger('mobile_number')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('month')->nullable();
            $table->string('day')->nullable();
            $table->string('year')->nullable();
            $table->string('gender')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('unit_number')->nullable();
            $table->string('email_id')->nullable();
            $table->date('dob')->nullable();
            $table->boolean('status')->default(0);
            $table->json('specialPrice')->nullable();
            $table->integer('is_pos')->default(0);
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
        Schema::dropIfExists('customers');
    }
};
