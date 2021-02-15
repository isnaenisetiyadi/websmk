<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Nullable;

class CreateMisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('misis', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id")->nullable();
            $table->integer("sekolah_id")->nullable();
            $table->string("text")->nullable();
            $table->string("avatar")->nullable();
            $table->timestamps();
        });
        DB::table('misis')->insert(
            array(
                'user_id' => 1,
                'sekolah_id' => 1,
                'text' => 'Mengembangkan iklim belajar berdasarkan norma budaya Indonesia',
            ),

        );
        DB::table('misis')->insert(

            array(
                'user_id' => 1,
                'sekolah_id' => 1,
                'text' => 'Mengembangkan sistem pendidikan yang fleksible',
            ),

        );
        DB::table('misis')->insert(


            array(
                'user_id' => 1,
                'sekolah_id' => 1,
                'text' => 'Menyiapkan tamatan yang memiliki keterampilan sesuai profesionalismenya',
            ),

        );
        DB::table('misis')->insert(



            array(
                'user_id' => 1,
                'sekolah_id' => 1,
                'text' => 'Mencetak tamatan yang memiliki karir di bidangnya serta memberi landasan untuk melanjutkan pendidikan ke jenjang yang lebih tinggi',
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
        Schema::dropIfExists('misis');
    }
}
