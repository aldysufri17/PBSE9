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
        Schema::create('conservation_managements', function (Blueprint $table) {
            $table->id('cm_id');
            $table->unsignedBigInteger('coi_id')->nullable();
            $table->text('desc')->nullable();
            $table->string('item')->nullable();
            $table->string('file')->nullable();
            $table->boolean('category')->nullable();
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
        Schema::dropIfExists('conservation_managements');
    }
};
