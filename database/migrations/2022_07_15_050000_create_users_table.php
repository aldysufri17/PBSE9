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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('section_id')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('avatar')->nullable();
            $table->tinyInteger('status');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
        Schema::table('sections', function (Blueprint $table){
            $table->foreign('deleted_by')->references('user_id')->on('users')->onDelete('cascade');
        });
        Schema::table('roles', function (Blueprint $table){
            $table->foreign('deleted_by')->references('user_id')->on('users')->onDelete('cascade');
        });
        Schema::table('users', function (Blueprint $table){
            $table->foreign('deleted_by')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('section_id')->references('section_id')->on('sections')->onDelete('cascade');
            $table->foreign('role_id')->references('role_id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
