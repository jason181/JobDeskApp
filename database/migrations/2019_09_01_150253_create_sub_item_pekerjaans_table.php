<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubItemPekerjaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_item_pekerjaans', function (Blueprint $table) {
            $table->increments('Id_Sub_Item_Pekerjaan');
            $table->unsignedInteger('Id_Item_Pekerjaan');
            $table->string('Nama',50);
            $table->string('Kode',50);
            $table->dateTime('Tanggal_Selesai');
            $table->integer('Persentase');
            // $table->string('Berkas',255);
            $table->softDeletes();
            $table->timestamps();

            $table  ->foreign('Id_Item_Pekerjaan')
                    ->references('Id_Item_Pekerjaan')
                    ->on('item_pekerjaans')
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
        Schema::dropIfExists('sub_item_pekerjaans');
    }
}
