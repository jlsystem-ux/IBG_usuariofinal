<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{


    protected $fillable = [
       'idproveedor'
      ,'idusuario'
      ,'tipo_comprobante'
      ,'serie_comprobante'
      ,'num_comprobante'
      ,'fecha_hora'
      ,'impuesto'
      ,'estado'
    ];

//usuario que a registrado el ingreso  id user id porveedor
    public function usuario()
    {
      return  $this->belongsTo('App\User');
    }

    public function Proveedor ()
    {
      return  $this->belongsTo('App\Proveedor');
    }
}
