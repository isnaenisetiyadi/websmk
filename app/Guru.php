<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Guru extends Model
{
    //
    protected $table = 'gurus';
    protected $fillable = ['user_id','nip','nuptk','nama','email','alamat','kontak','avatar','jabatan','randomkey'];

    public function user(){
        return $this->BelongsTo("App\User");
    }

    public function pendidikan(){
        return $this->hasMany("App\Pendidikan");
    }
    public function post(){
        return $this->belongsToMany("App\Post","App\Toy","post_id");
    }

    public function jurusan() {
        return $this->belongsToMany("App\Jurusan");
    }
}
