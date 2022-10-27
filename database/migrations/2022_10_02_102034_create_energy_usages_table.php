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
        Schema::create('energy_usages', function (Blueprint $table) {
            $table->id('eu_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('energy_id');
            $table->bigInteger('usage');
            $table->bigInteger('cost');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('invoice');
            $table->json('file')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('post_by');
            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->foreign('deleted_by')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('energy_usages');
    }
};
