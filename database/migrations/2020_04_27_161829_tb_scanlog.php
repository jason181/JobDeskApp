<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbScanlog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_scanlog', function (Blueprint $table) {
            $table->increments('Id_Scanlog');
            $table->unsignedInteger('Id_Device');
            $table->unsignedInteger('Id_User');
            $table->integer('Verify_Mode');
            $table->integer('IO_Mode');
            $table->integer('Work_Code');

            $table->softDeletes();
            $table->timestamps();

            $table  ->foreign('Id_Device')
                    ->references('Id_Device')
                    ->on('tb_device');
            $table  ->foreign('Id_User')
                    ->references('Id_User')
                    ->on('tb_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
