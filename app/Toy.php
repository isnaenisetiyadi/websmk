<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Toy extends Model
{
    //
    protected $table = 'toys';
    protected $fillable = ['user_id','post_id','guru_id'];

    public function user(){
        return $this->belongsTo("App\User");
    }
    
}
