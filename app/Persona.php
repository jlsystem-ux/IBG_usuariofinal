<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{


  protected $fillable =
  ['nombre',
  'tipo_documento',
  'numero_documento',
  'direccion',
  'telefono',
  'email'
   ];

    //de 1 a 1;
    public function proovedor()
    { // este manda su id al proveedor de 1 a 1
      return $this->hasOne('App\Proveedor');
    }

    public function user()
    {
      return $this->hasOne('App\User');
    }


}
