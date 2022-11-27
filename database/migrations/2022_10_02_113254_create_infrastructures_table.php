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
        Schema::create('infrastructures', function (Blueprint $table) {
            $table->id('is_id');
            $table->unsignedBigInteger('room_id');
            $table->string('name');
            $table->string('type');
            $table->timestamps();
            $table->unsignedBigInteger('post_by')->nullable();
            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('room_id')->references('room_id')->on('rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('infrastructures');
    }
};
