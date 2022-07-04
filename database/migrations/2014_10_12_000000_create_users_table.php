<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pma_user', function (Blueprint $table) {
            $table->id();
            $table->string('namauser')->unique();
            $table->string('nama');
            $table->integer('golongan');
            $table->string('sandi');
            $table->string('pic');
            $table->string('kodesite');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pma_user');
    }
};
