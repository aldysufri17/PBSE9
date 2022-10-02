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
            $table->unsignedBigInteger('energy_id');
            $table->bigInteger('usage');
            $table->bigInteger('cost');
            $table->date('date');
            $table->json('file')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('post_by');
            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by');
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
