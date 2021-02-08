<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    //
    protected $table = 'pendidikans';
    protected $fillable = ['user_id','guru_id','jenjang','sekolah','tahun_masuk','tahun_lulus'];

    public function guru()
    {
        return $this->belongsTo("App\Guru");
    }
    public function user()
    {
        return $this->belongsTo("App\User");
    }
}
