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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('driver_id');
            $table->string('driver_man_id');
            $table->string('driver_name');
            $table->string('driver_email');
            $table->string('driver_mobile_no');
            $table->string('password');
            $table->string('show_password');
            $table->string('image')->nullable();
            $table->string('commission')->nullable();
            $table->string('earning')->nullable();
            $table->string('driver_address')->nullable();
            $table->string('region')->nullable();
            $table->string('order_delivered')->default('0');
            $table->string('status')->default('1');
            $table->string('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
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
        Schema::dropIfExists('drivers');
    }
};
