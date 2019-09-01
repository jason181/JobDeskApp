<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAksesPekerjaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akses_pekerjaans', function (Blueprint $table) {
            $table->increments('Id_Akses_Pekerjaan');
            $table->unsignedInteger('Id_Sub_Item_Pekerjaan');
            $table->unsignedInteger('Id_Akun');
            $table->string('Status');
            $table->string('Verifikasi',50);

            $table->softDeletes();
            $table->timestamps();

            $table  ->foreign('Id_Sub_Item_Pekerjaan')
                    ->references('Id_Sub_Item_Pekerjaan')
                    ->on('sub_item_pekerjaans')
                    ->onChange('cascade')
                    ->onDelete('cascade');

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
        Schema::dropIfExists('akses__pekerjaans');
    }
}
