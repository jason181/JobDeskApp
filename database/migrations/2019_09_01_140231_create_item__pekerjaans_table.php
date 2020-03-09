<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemPekerjaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_pekerjaans', function (Blueprint $table) {
            $table->increments('Id_Item_Pekerjaan');
            $table->unsignedInteger('Id_Sub_Divisi_Proyek');
            $table->unsignedInteger('Id_Divisi_Role');
            $table->string('Nama',50);
            // $table->string('Kode',50);
            // $table->string('Satuan',50);
            $table->integer('Durasi');
            $table->dateTime('Tanggal_Selesai');
            $table->integer('Persentase');

            $table->softDeletes();
            $table->timestamps();

            $table  ->foreign('Id_Sub_Divisi_Proyek')
                    ->references('Id_Sub_Divisi_Proyek')
                    ->on('sub_divisi_proyeks')
                    ->onChange('cascade')
                    ->onDelete('cascade');
            $table  ->foreign('Id_Divisi_Role')
                    ->references('Id_Divisi_Role')
                    ->on('divisi_roles')
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
        Schema::dropIfExists('item__pekerjaans');
    }
}
