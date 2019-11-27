<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Ingreso;
use App\DetalleIngreso;

class IngresoControlador extends Controller
{


  public function index(Request $request)
  {
     //if(!$request->ajax()) return redirect('/');
     $buscar   = $request->buscar;
     $criterio = $request->criterio;

     if($buscar == ''){
       $ingresos =  Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
       ->join('users', 'ingresos.idusuario','=', 'users.id')
       ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.serie_comprobante'
       ,'ingresos.num_comprobante','ingresos.fecha_hora','ingresos.impuesto','ingresos.total'
       ,'ingresos.estado','personas.nombre', 'users.usuario')
       ->orderBy('ingresos.id','desc')->paginate(5);
     }
     else{
       $ingresos =  Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
       ->join('users', 'ingresos.idusuario','=', 'users.id')
       ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.serie_comprobante'
       ,'ingresos.num_comprobante','ingresos.fecha_hora','ingresos.impuesto','ingresos.total'
       ,'ingresos.estado','personas.nombre', 'users.usuario')
        ->where('ingresos.' . $criterio, 'like', '%'. $buscar . '%')
        ->orderBy('ingresos.id','desc')->paginate(5);
     }


       return
        [
          'pagination' =>
          [
            'total'         => $ingresos->total(),
            'current_page'  => $ingresos->currentPage(),
            'per_page'      => $ingresos->perPage(),
            'last_page'     => $ingresos->lastPage(),
            'from'          => $ingresos->firstItem(),
            'to'            => $ingresos->lastItem(),
          ],
            'ingresos' => $ingresos

        ];

    }


  public function store(Request $request)
  {
      if(!$request->ajax()) return redirect('/');

      try{
          DB::beginTransaction();
            //duda
          $mytime = Carbon::now('America\Bogota');



          $ingreso                     =  new Persona();
          $ingreso->idproveedor = $request->idproveedor;
          $ingreso->idusuario = \Auth::user()->id;
          $ingreso->tipo_comprobante   = $request->tipo_comprobante;
          $ingreso->serie_comprobante  = $request->serie_comprobante;
          $ingreso->num_comprobante    =  $request->num_comprobante;
          $ingreso->fecha_hora         = $request->$mytime->toDateString();
          $ingreso->impuesto           = $request->inpuesto;
          $ingreso->total              = $request->total;
          $ingreso->estado             = 'Registrado';
          $ingreso->save();


           $detalles = $request->data;

           foreach ($detalle as $ep => $det) {

             $detalle = new DetalleIngreso();
             $detalle->idingreso  = $ingreso->id;
             $detalle->idarticulo = $det['idarticulo'];
             $detalle->cantidad   = $det['cantidad'];
             $detalle->precio     = $det['precio'];
             $detalle-save();
           }

           DB::commit();
      }catch(Exception $e){

           DB::rollBack();
      }




  }


  public function activar(Request $request)
  {
      if(!$request->ajax()) return redirect('/');
       $ingreso = User::findOrFail($request->id);
       $ingreso->condicion = '1';
       $ingreso->save();
  }


  public function desactivar(Request $request)
  {
      if(!$request->ajax()) return redirect('/');
    $ingreso = Ingreso::findOrFail($request->id);
    $ingreso->estado = 'Anulado';
    $ingreso->save();

  }



}
