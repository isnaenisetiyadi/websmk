<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeritasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('kategori_id')->nullable();
            $table->string('judul')->nullable();
            $table->string('deskripsi')->nullable();
            $table->string('avatar')->nullable();
            $table->mediumtext('konten')->nullable(); //tynytext(642byt), text(64kb), mediumtext(16MB), longtext(4GB)
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
        Schema::dropIfExists('beritas');
    }
}
