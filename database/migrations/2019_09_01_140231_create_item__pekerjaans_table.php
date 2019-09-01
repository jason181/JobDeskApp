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
            $table->unsignedInteger('Id_Proyek');
            $table->unsignedInteger('Id_Divisi');
            $table->string('Item',50);
            $table->string('Kode',50);
            $table->string('Satuan',50);
            $table->integer('Durasi');

            $table->softDeletes();
            $table->timestamps();

            $table  ->foreign('Id_Proyek')
                    ->references('Id_Proyek')
                    ->on('proyeks')
                    ->onChange('cascade')
                    ->onDelete('cascade');
            $table  ->foreign('Id_Divisi')
                    ->references('Id_Divisi')
                    ->on('divisis')
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
