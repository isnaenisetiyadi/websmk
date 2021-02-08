<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    //
    protected $table = 'kategoris';
    protected $fillable = ['user_id','nama'];

    public function berita()
    {
        return $this->hasMany("App\Berita");
    }
    public function user()
    {
        return $this->belongsTo("App\User");
    }
}
