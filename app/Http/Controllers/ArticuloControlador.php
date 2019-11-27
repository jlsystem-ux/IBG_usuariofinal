<?php

namespace App\Http\Controllers;

use App\Articulo;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class ArticuloControlador extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      // if(!$request->ajax()) return redirect('/');
       $buscar   = $request->buscar;
       $criterio = $request->criterio;

       if($buscar == ''){
         $articulos =  Articulo::orderBy('id','desc')->paginate(5);
       }
       else{
         $articulos =  Articulo::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id','desc')->paginate(5);
       }


         return
          [
            'pagination' =>
            [
              'total'         => $articulos->total(),
              'current_page'  => $articulos->currentPage(),
              'per_page'      => $articulos->perPage(),
              'last_page'     => $articulos->lastPage(),
              'from'          => $articulos->firstItem(),
              'to'            => $articulos->lastItem(),
            ],
              'articulos' => $articulos

          ];

      }



    public function buscarArticulo(Request $request){
      //  if(!$request->ajax()) return redirect('/');

      $filtro = $request->filtro;

      $articulos = Articulo::where('nombre_articulo', '=', $filtro)
      ->select('id','nombre_articulo')
      ->orderBy('nombre_articulo', 'asc')
      ->take(1)->get();

      return ['articulos' => $articulos ];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //  if(!$request->ajax()) return redirect('/');
        $articulo = new Articulo();

        $articulo->codigo_articulo = "SB30"; //Salon de bellaza calle 30
        $articulo->nombre_articulo = $request->nombreArticulo;
        $articulo->precio_venta = $request->precio;
        $articulo->stock = $request->cantidadArticulo;
        $articulo->descripcion = $request->descripcion;
        $articulo->estado = '1';

        $articulo->save();



    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      if(!$request->ajax()) return redirect('/');
      $articulo = Articulo::findOrFail($request->id);
      $articulo->codigo_articulo = "SB30"; //Salon de bellaza calle 30
      $articulo->nombre_articulo= $request->nombreArticulo;
      $articulo->precio_venta = $request->precio;
      $articulo->stock = $request->cantidadArticulo;
      $articulo->descripcion = $request->descripcion;
      $articulo->estado = '1';

      $articulo->save();



    }

    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
      $articulo = Articulo::findOrFail($request->id);
      $articulo->estado = '1';
      $articulo->save();
    }


    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
      $articulo = Articulo::findOrFail($request->id);
      $articulo->estado = '0';
      $articulo->save();

    }



}
