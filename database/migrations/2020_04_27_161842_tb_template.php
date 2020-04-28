<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_template', function (Blueprint $table) {
            $table->increments('Id_Template');
            $table->unsignedInteger('Id_User');
            $table->integer('Finger_Idx');
            $table->integer('Alg_Ver');
            $table->integer('Template');

            $table->softDeletes();
            $table->timestamps();

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
