<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShequTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shequ', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('姓名')->nullable();
            $table->string('tel')->comment('手机')->nullable();
            $table->string('area')->comment('地区')->nullable();
            $table->string('job')->comment('职业')->nullable();
            $table->string('status')->default('off')->comment('状态');
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
        Schema::dropIfExists('shequ');
    }
}
