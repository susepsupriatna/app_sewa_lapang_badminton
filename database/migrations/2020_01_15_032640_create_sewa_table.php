<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSewaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sewa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->index('user_id_foreign');
            $table->integer('member_id')->index('member_id_foreign');
            $table->integer('lapang_id')->index('lapang_id_foreign');
            $table->string('tanggal', 100);
            $table->string('jam_mulai', 100);
            $table->string('jam_selesai', 100);
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
        Schema::dropIfExists('sewa');
    }
}
