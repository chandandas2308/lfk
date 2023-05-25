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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('is_admin');
            $table->string('name');
            $table->string('fb_id')->nullable();
            $table->string('image')->nullable();
            $table->string('month')->nullable();
            $table->string('day')->nullable();
            $table->string('year')->nullable();
            $table->string('gender')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('address')->nullable();
            $table->string('unit_number')->nullable();
            $table->string('email')->nullable();
            $table->integer('status')->default('1');
            $table->bigInteger('mobile_number')->nullable();
            $table->string("phone_number")->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('assigned_modules')->nullable();
            $table->string('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
