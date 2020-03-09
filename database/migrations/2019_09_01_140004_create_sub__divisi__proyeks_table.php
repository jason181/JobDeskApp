<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubDivisiProyeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_divisi_proyeks', function (Blueprint $table) {
            $table->increments('Id_Sub_Divisi_Proyek');
            $table->unsignedInteger('Id_Divisi_Proyek');
            $table->string('Nama',50);
            $table->dateTime('Tanggal_Selesai');
            $table->integer('Durasi');
            $table->integer('Persentase');
            
            $table->softDeletes();
            $table->timestamps();
            $table  ->foreign('Id_Divisi_Proyek')
                    ->references('Id_Divisi_Proyek')
                    ->on('divisi_proyeks')
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
        Schema::dropIfExists('sub__divisi__proyeks');
    }
}
