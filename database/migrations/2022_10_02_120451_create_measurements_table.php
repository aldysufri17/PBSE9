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
        Schema::create('measurements', function (Blueprint $table) {
            $table->id('m_id');
            $table->json('daya_aktif'); //RST Total
            $table->json('daya_reaktif');
            $table->json('daya_semu');
            $table->json('tegangan_satu_fasa'); //Vrst
            $table->json('tegangan_tiga_fasa');
            $table->json('tegangan_tidak_seimbang');
            $table->json('arus'); //RST Netral
            $table->float('frekuensi');
            $table->float('harmonisa_arus');
            $table->float('harmonisa_tegangan');
            $table->float('faktor_daya');
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
        Schema::dropIfExists('measurements');
    }
};
