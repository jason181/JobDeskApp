<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogPengerjaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_pengerjaans', function (Blueprint $table) {
            $table->increments('Id_Pengerjaan');
            $table->unsignedInteger('Id_Sub_Item_Pekerjaan');
            $table->unsignedInteger('Id_Akun');
            $table->dateTime('Waktu_Mulai');
            $table->dateTime('Waktu_Selesai');
            $table->integer('Progress');
            $table->string('Berkas',255);
            $table->string('Catatan',255);

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
        Schema::dropIfExists('log__pengerjaans');
    }
}
