<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    //
    protected $table = 'beritas';
    protected $fillable = ['user_id','kategori_id','judul','deskripsi','konten'];

    public function user()
    {
        return $this->belongsTo("App\User");
    }
    public function kategori()
    {
        return $this->belongsTo("App\Kategori");
    }
    public function jurusan()
    {
        return $this->belongsToMany("App\Jurusan");
    }
    public function komentar()
    {
        return $this->hasMany("App\Komentar");
    }
    public function post(){
        return $this->hasOne("App\Post");
    }
    public function organisasi()
    {
        // return $this->belongsToMany("App\Organisasi");
        // return $this->belongsToMany("App\Organisasi")->withPivot('created_at');
        return $this->belongsToMany("App\Organisasi")->withTimestamps();
    }
}
