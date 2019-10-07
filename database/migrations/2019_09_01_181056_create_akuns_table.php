<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAkunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akuns', function (Blueprint $table) {
            $table->increments('Id_Akun');
            // $table->unsignedInteger('Id_Karyawan');
            $table->string('Username',50);
            $table->string('Password',255);

            $table->softDeletes();
            $table->timestamps();

            // $table  ->foreign('Id_Karyawan')
            //         ->references('Id_Karyawan')
            //         ->on('karyawans')
            //         ->onChange('cascade')
            //         ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akuns');
    }
}
