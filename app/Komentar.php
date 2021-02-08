<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    //

    protected $table = 'komentars';
    protected $fillable = ['user_id','berita_id','komentar_id','komen'];

    public function user()
    {
        return $this->belongsTo("App\User");
    }
    public function berita()
    {
        return $this->belongsTo("App\Berita");
    }

    // FUNGSI PERCOBAAN RELASI DALAM TABEL
    public function komentar()
    {
        return $this->belongsTo("App\Komentar");
    }
    public function balasan()
    {
        return $this->hasMany("App\Komentar");
    }
    // AKHIR FUNGSI PERCOBAAN RELASI DALAM TABEL
}
