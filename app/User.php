<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username','email', 'password','role','remember_token','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function berita(){
        return $this->hasMany("App\Berita");
    }
    public function jurusan(){
        return $this->hasMany("App\Jurusan");
    }
    public function kategori(){
        return $this->hasMany("App\Kategori");
    }
    public function guru(){
        return $this->hasMany("App\Guru");
    }
    public function pendidikan(){
        return $this->hasMany("App\Pendidikan");
    }
    public function komentar(){
        return $this->hasMany("App\Komentar");
    }
    public function som(){
        return $this->hasMany("App\Som");
    }
    public function toy(){
        return $this->hasMany("App\Toy");
    }
    public function program(){
        return $this->hasMany("App\Program");
    }
    public function organisasi(){
        return $this->hasMany("App\Organisasi");
    }
}
