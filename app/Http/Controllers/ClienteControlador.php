<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;


class ClienteControlador extends Controller
{

  public function index(Request $request)
  {
     if(!$request->ajax()) return redirect('/');
     $buscar   = $request->buscar;
     $criterio = $request->criterio;

     if($buscar == ''){
       $personas =  Persona::orderBy('id','desc')->paginate(5);
     }
     else{
        $personas =  Persona::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id','desc')->paginate(5);
     }


       return
        [
          'pagination' =>
          [
            'total'         => $personas->total(),
            'current_page'  => $personas->currentPage(),
            'per_page'      => $personas->perPage(),
            'last_page'     => $personas->lastPage(),
            'from'          => $personas->firstItem(),
            'to'            => $personas->lastItem(),
          ],
            'personas' => $personas

        ];

    }


    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $persona = new Persona();
        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->tipo_documento;
        $persona->numero_documento = $request->numero_documento;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->email = $request->email;

        $persona->save();


    }

      public function update(Request $request)
      {
        if(!$request->ajax()) return redirect('/');
        
        $persona = Persona::findOrFail($request->id);
        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->tipo_documento;
        $persona->numero_documento = $request->numero_documento;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->email = $request->email;

        $persona->save();

      }

}
