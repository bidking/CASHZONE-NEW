<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('acaras', function (Blueprint $table) {
            $table->decimal('jumlah_bayar', 10, 2)->after('tanggal_acara');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('acaras', function (Blueprint $table) {
        $table->dropColumn('jumlah_bayar');
    });
}

};
