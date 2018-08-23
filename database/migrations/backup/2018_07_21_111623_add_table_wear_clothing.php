<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableWearClothing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wear_clothing', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('wear_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('clothing_id');
            $table->softDeletes();
            $table->timestamps();
            $table->index(['user_id', 'wear_id', 'clothing_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wear_clothing');
    }
}
