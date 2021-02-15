<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Misi extends Model
{
    protected $table = "misis";
    protected $fillable = ["user_id", "sekolah_id", "text", "avatar"];
    //
    public function sekolah()
    {
        return $this->belongsTo("App\Sekolah");
    }
    public function user(){
        return $this->belongsTo("App\User");
    }
}
