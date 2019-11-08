<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDivisiProyeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('divisi_proyeks', function (Blueprint $table) {
            $table->increments('Id_Divisi_Proyek');
            $table->unsignedInteger('Id_Divisi_Role');
            $table->unsignedInteger('Id_Proyek');
            $table->string('Nama',50);
            $table->dateTime('Tanggal_Selesai');
            $table->integer('Persentase');
            
            $table->softDeletes();
            $table->timestamps();
            $table  ->foreign('Id_Divisi_Role')
                    ->references('Id_Divisi_Role')
                    ->on('divisi_roles')
                    ->onChange('cascade')
                    ->onDelete('cascade');
            $table  ->foreign('Id_Proyek')
                    ->references('Id_Proyek')
                    ->on('proyeks')
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
        Schema::dropIfExists('divisi__proyeks');
    }
}
