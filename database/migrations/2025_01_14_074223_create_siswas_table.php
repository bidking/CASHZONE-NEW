<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswasTable extends Migration
{
    public function up()
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('password');
            $table->string('status');  // misalnya 'aktif', 'tidak aktif'
            $table->string('kelas');   // kelas yang diikuti
            $table->string('walas');   // nama wali kelas (relasi ke tabel gurus)
            $table->string('image')->nullable();  // untuk menyimpan image
            $table->string('gander');  // jenis kelamin
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('siswas');
    }
    
}
