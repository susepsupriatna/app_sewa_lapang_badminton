<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLapangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        Schema::create('lapang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_lapang', 100);
            $table->enum('jenis_karpet', array('vinyl','interlock'));
            $table->integer('harga_per_jam')->nullable();
            $table->string('foto', 100)->nullable();
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
        Schema::dropIfExists('lapang');
    }
}
