<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    //
    protected $table = 'jurusans';
    protected $fillable = ['user_id','nama','deskripsi','logo'];

    public function user(){
        return $this->belongsTo("App\User");
    }

    public function berita()
    {
        return $this->belongsToMany("App\Berita");
    }

    public function guru() {
        return $this->belongsToMany("App\Guru");
    }
    
}
