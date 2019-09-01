<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKaryawansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->increments('Id_Karyawan');
            $table->unsignedInteger('Id_Divisi');
            $table->unsignedInteger('Id_Jabatan');
            $table->string('Kode',50);
            $table->string('Nama',50);
            $table->string('Alamat',255);
            $table->string('Telepon',15);
            $table->date('Tanggal_Masuk');
            $table->string('Grade',50);
            $table->string('KTP',50);
            $table->string('Nomor_Asosiasi',50);
            $table->string('Nomor_SKA',50);

            $table->softDeletes();
            $table->timestamps();

            $table  ->foreign('Id_Divisi')
                    ->references('Id_Divisi')
                    ->on('divisis')
                    ->onChange('cascade')
                    ->onDelete('cascade');
                    
            $table  ->foreign('Id_Jabatan')
                    ->references('Id_Jabatan')
                    ->on('jabatans')
                    ->onChange('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('karyawans');
    }
}
