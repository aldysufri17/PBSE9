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
        Schema::create('consumtion_intensities', function (Blueprint $table) {
            $table->id("ci_id");
            $table->unsignedBigInteger('energy_id');
            $table->tinyInteger('type');
            $table->bigInteger('IKE');
            $table->string('desc');
            $table->date('date');
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
        Schema::dropIfExists('consumtion_intensities');
    }
};
