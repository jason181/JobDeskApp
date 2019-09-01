<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->increments('Id_Token');
            $table->unsignedInteger('Id_Akun');
            $table->string('Username',50);
            $table->string('Password',255);

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
        Schema::dropIfExists('tokens');
    }
}
