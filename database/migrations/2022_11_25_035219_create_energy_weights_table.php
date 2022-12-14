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
        Schema::create('energy_weights', function (Blueprint $table) {
            $table->id('ew_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('building_id');
            $table->unsignedBigInteger('room_id');
            $table->string('name');
            $table->integer('capacity');
            $table->integer('quantity');
            $table->integer('total');
            $table->timestamps();
            $table->unsignedBigInteger('post_by')->nullable();
            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('building_id')->references('building_id')->on('buildings')->onDelete('cascade');
            $table->foreign('room_id')->references('room_id')->on('rooms')->onDelete('cascade');
            $table->foreign('section_id')->references('section_id')->on('sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('energy_weights');
    }
};
