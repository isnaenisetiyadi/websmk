<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    //
    protected $table = 'posts';
    protected $fillable = ['user_id','berita_id','views','utama'];

    public function berita(){
        return $this->belongsTo("App\Berita");
    }
    public function som(){
        return $this->hasMany("App\Som");
    }

    public function guru(){
        return $this->belongsToMany("App\Guru","App\Toy","guru_id");
    }
}
