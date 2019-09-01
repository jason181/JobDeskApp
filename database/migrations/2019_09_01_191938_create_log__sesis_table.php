<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogSesisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_sesis', function (Blueprint $table) {
            $table->increments('Id_Log_Sesi');
            $table->unsignedInteger('Id_Akun');
            $table->time('Waktu');
            $table->string('Keterangan',255);
            
            $table->softDeletes();
            $table->timestamps();

            $table  ->foreign('Id_Akun')
                    ->references('Id_Akun')
                    ->on('akuns')
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
        Schema::dropIfExists('log__sesis');
    }
}
