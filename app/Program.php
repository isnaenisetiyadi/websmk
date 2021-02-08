<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    //
    protected $table = "programs";
    protected $fillable = ['user_id','organisasi_id','nama','deskripsi','avatar','konten'];

    public function user(){
        return $this->belongsTo("App\User");
    }
    public function organisasi(){
        return $this->belongsTo("App\Organisasi");
    }
}
