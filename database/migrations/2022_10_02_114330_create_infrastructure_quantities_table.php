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
        Schema::create('infrastructure_quantities', function (Blueprint $table) {
            $table->id('iq_id');
            $table->unsignedBigInteger('is_id');
            $table->tinyInteger('type');
            $table->string('name');
            $table->integer('capacity');
            $table->integer('quantity');
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
        Schema::dropIfExists('infrastructure_quantities');
    }
};
