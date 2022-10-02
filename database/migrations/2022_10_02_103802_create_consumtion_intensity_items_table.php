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
        Schema::create('consumtion_intensity_items', function (Blueprint $table) {
            $table->id('ci_item_id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consumtion_intensity_items');
    }
};
