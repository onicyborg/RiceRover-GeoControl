<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alokasi_pupuk', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penanggung_jawab');
            $table->string('musim_tanam');
            $table->string('jenis_pupuk');
            $table->integer('jumlah_pupuk');
            $table->unsignedBigInteger('harga_pupuk');
            $table->unsignedBigInteger('total_nilai_subsidi');
            $table->text('foto_bukti_distribusi');
            $table->text('foto_tanda_tangan');
            $table->unsignedBigInteger('lahan_id');
            $table->timestamps();

            $table->foreign('lahan_id')->references('id')->on('lahans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alokasi_pupuk');
    }
};
