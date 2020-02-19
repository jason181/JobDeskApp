<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyeks', function (Blueprint $table) {
            $table->increments('Id_Proyek');
            $table->string('Kode',50);
            $table->string('Nama',255);
            $table->string('Pemilik',15);
            $table->string('Alamat',255);
            $table->double('Nilai');
            $table->date('Target_Outcome');
            $table->date('Tanggal_Mulai');
            $table->date('Tanggal_Selesai');
            $table->longText('Catatan');
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyeks');
    }
}
