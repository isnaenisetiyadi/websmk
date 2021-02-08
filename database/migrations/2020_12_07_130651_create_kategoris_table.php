<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateKategorisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('nama')->nullable();
            $table->timestamps();
        });

        //insert data awal
        DB::table('kategoris')->insert(
            array(
                'user_id' => '1',
                'nama' => 'PENGUMUMAN'
            )
        );
        DB::table('kategoris')->insert(
            array(
                'user_id' => '1',
                'nama' => 'BERITA'
            )
        );
        DB::table('kategoris')->insert(
            array(
                'user_id' => '1',
                'nama' => 'KEGIATAN'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kategoris');
    }
}
