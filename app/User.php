<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
      protected $fillable = [
          'id','usuario', 'password', 'condicion','idrol'
      ];


      public $timestamps = false;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
      protected $hidden = [
        'password', 'remember_token',
      ];

      public function rol(){
        return $this->belongsTo('App\Rol'); //referencia para el modelo 1 usuario pertene a un rol
      }

      public function persona(){
        return $this->belongsTo('App\Persona'); //referencia para el modelo 1 usuario pertene a una persona
      }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
