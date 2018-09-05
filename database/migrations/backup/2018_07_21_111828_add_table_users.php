<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema:: create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('wx_openid', 50)->nullable();
            $table->string('wx_unionid', 50)->nullable();
            $table->string('mobile', 11);
            $table->string('email', 50)->nullable();
            $table->string('password', 50)->nullable();
            $table->string('nickname', 30);
            $table->string('register_ip', 30);
            $table->string('register_city', 20);
            $table->dateTime('last_login_time')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->string('last_login_city')->nullable();
            $table->enum('gender', ['男', '女', '保密'])->default('保密');
            $table->text('avatar')->nullable();
            $table->timestamps();
            $table->index('wx_openid');
            $table->index('wx_unionid');
            $table->index('mobile');
            $table->index('nickname');
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
