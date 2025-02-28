<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_gurus_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGurusTable extends Migration
{
    public function up()
{
    Schema::create('gurus', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->string('image')->nullable();  // untuk menyimpan image
        $table->string('status');  // misalnya 'aktif', 'tidak aktif'
        $table->string('kelas');  // kelas yang diajarkan
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('gurus');
}

}
