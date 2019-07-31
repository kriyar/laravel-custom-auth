<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username')->unique();
            $table->string('email')->unique()->nullable()->default(null);
            $table->timestamp('email_verified_at')->nullable()->default(null);
            $table->bigInteger('phone_number')->unique()->nullable()->default(null);
            $table->timestamp('phone_verified_at')->nullable()->default(null);
            $table->string('password');
            $table->boolean('status')->default(true)->comment('1: Active, 0: Blocked');
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
}
