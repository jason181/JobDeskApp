<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAksesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akses', function (Blueprint $table) {
            $table->bigIncrements('Id_Akses');
            $table->unsignedInteger('Id_Karyawan');
            $table->string('Fitur',255);
            $table->string('Deskripsi',255);

            
            $table->softDeletes();
            $table->timestamps();

            $table  ->foreign('Id_Karyawan')
                    ->references('Id_Karyawan')
                    ->on('karyawans')
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
        Schema::dropIfExists('akses');
    }
}
