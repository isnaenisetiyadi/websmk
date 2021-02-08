<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organisasi extends Model
{
    //
    protected $table = "organisasis";
    protected $fillable = ['user_id','nama','deskripsi','avatar'];

    public function user(){
        return $this->belongsTo("App\User");
    }
    public function program(){
        return $this->hasMany("App\Program");
    }

    public function berita()
    {
        return $this->belongsToMany("App\Berita");
    }
}
