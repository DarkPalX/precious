<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PhCity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ph_cities', function (Blueprint $table) {
            $table->bigIncrements('CityID');
            $table->integer('CountryID')->nullable();
            $table->string('City')->nullable();
            $table->string('Province')->nullable();
            $table->string('Region')->nullable();
            $table->string('ZipCode')->nullable();
            $table->string('IslandGroup')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ph_cities');
    }
}
