<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableWears extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wears', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('temperature_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->text('images')->nullable();
            $table->text('tags')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->index(['user_id', 'temperature_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wears');
    }
}
