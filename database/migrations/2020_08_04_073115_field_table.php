<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('area_name');
            $table->string('color');
            $table->date('event_start');
            $table->date('event_end')->nullable();
            $table->float('water_level');
            $table->string('flood_type');
            $table->string('damage')->default("0");
            $table->string('civilians')->default("0");
            $table->string('description')->nullable();
            $table->string('status')->default('aman');
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
        Schema::dropIfExists('field');
    }
}
