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
        Schema::create('infrastructure_legalities', function (Blueprint $table) {
            $table->id('il_id');
            $table->unsignedBigInteger('is_id');
            $table->string('NDI');
            $table->string('SLO');
            $table->string('IJIN_OPERASI');
            $table->string('TTB');
            $table->string('SOP_OPERASI');
            $table->string('SOP_PELIHARA');
            $table->date('date');
            $table->timestamps();
            $table->unsignedBigInteger('post_by')->nullable();
            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('infrastructure_legalities');
    }
};
