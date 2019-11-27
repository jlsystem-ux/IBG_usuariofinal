<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    // protected $table = 'articulos';// no es necesario por defecto
     //protected $primaryKey = 'id'; // no es necesario

     protected $fillable =
     ['codigo_articulo',
     'nombre_articulo',
     'precio_venta',
     'stock',
     'descripcion',
     'estado'
      ];


}
