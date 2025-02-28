<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabungansTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tabungans', function (Blueprint $table) {
            $table->id();
            // Field dari tabel siswa
            $table->string('nisn');
            $table->string('name');
            $table->string('status')->nullable();
            $table->string('kelas')->nullable();
            $table->string('walas')->nullable();
            $table->string('image')->nullable();
            $table->string('gander')->nullable();
            $table->string('no_telpon')->nullable();
            // Field dari tabel acara
            $table->string('nama_acara')->nullable();
            $table->date('tanggal_acara')->nullable();
            $table->decimal('jumlah_bayar', 10, 2)->default(0);
            // Field tambahan
            $table->decimal('total_masuk', 10, 2)->default(0);
            $table->decimal('tagihan', 10, 2)->default(0);
            // $table->integer('jumlah_masuk')->default(0);
            $table->string('tipe_pembayaran')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tabungans');
    }
}
    