<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    //
    protected $table = 'sekolahs';
    protected $fillable = ['user_id', 'guru_id', 'nama', 'alamat', 'email', 'visi', 'moto1', 'moto2', 'logo', 'avatar'];

    public function user()
    {
        return $this->belongsTo("App\User");
    }
    public function misi()
    {
        return $this->hasMany("App\Misi");
    }
    public function guru()
    {
        return $this->belongsTo("App\Guru");
    }
}
