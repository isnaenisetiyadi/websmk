<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSekolahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sekolahs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('guru_id')->nullable();
            $table->string('nama')->nullable();
            $table->string('alamat')->nullable();
            $table->string('email')->nullable();
            $table->string('visi')->nullable();
            $table->string('moto1')->nullable();
            $table->string('moto2')->nullable();
            $table->string('logo')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamps();
        });
        DB::table('sekolahs')->insert(
            array(
                'user_id' => 1,
                'nama' => "SMK Negeri 1 Mepanga",
                'alamat' => "Jl. Nusantara NO.116 Kayuagung - Kec. Mepanga",
                'email' => "smknmepanga@gmail.com",
                'visi' => "Terampil, Cerdas, Terdidik berdasarkan iman dan taqwa",
                'moto1' => "Vocational School",
                'moto2' => "SMK Bisa, Mandiri",

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
        Schema::dropIfExists('sekolahs');
    }
}
