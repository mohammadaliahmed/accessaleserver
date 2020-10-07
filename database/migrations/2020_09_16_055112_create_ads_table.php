<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('title');
            $table->longText('description');
            $table->integer('price');
            $table->string('category');
            $table->bigInteger('time');
            $table->text('images');
            $table->string('city');
            $table->integer('views')->nullable();
            $table->string('area');
            $table->boolean('promoted')->default(false);
            $table->bigInteger('promotion_end_time')->nullable();
            $table->string('status')->default('pending');
            $table->double('latitude')->default(0.0);
            $table->double('longitude')->default(0.0);
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
        Schema::dropIfExists('ads');
    }
}
