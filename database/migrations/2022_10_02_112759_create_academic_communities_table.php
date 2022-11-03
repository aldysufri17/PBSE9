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
        Schema::create('academic_communities', function (Blueprint $table) {
            $table->id('ac_id');
            $table->json('incoming_students');
            $table->json('graduate_students');
            $table->json('employee');
            // $table->date('date');
            $table->timestamps();
            $table->unsignedBigInteger('post_by');
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
        Schema::dropIfExists('academic_communities');
    }
};
