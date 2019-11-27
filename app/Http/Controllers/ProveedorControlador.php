<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Proveedor;
use App\Persona;

class ProveedorControlador extends Controller
{

        public function index(Request $request)
        {
          if(!$request->ajax()) return redirect('/');
           $buscar   = $request->buscar;
           $criterio = $request->criterio;

           if($buscar == ''){
             $personas =  Proveedor::join('personas','proveedores.id','=','personas.id')
             ->select('personas.id','personas.nombre','personas.tipo_documento'
             ,'personas.numero_documento'
             ,'personas.direccion','personas.telefono','personas.email'
             ,'proveedores.teleono_contacto'
             ,'proveedores.contacto')->orderBy('personas.id','desc')->paginate(5);
           }
           else{
              $personas =  Proveedor::join('personas','proveedores.id','=','personas.id')
              ->select('personas.id','personas.nombre','personas.tipo_documento','personas.numero_documento'
              ,'personas.direccion','personas.telefono','personas.email','proveedores.teleono_contacto'
              ,'proveedores.contacto')
              ->where('personas.' . $criterio, 'like', '%'. $buscar . '%')->orderBy('personas.id','desc')->paginate(5);
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


        public function selectProveedor(Request $request){
        //  if(!$request->ajax()) return redirect('/');

          $filtro = $request->filtro;
          
          $proveedores = Proveedor::join('personas','proveedores.id', '=', 'personas.id')
          ->where('personas.nombre', 'like', '%'. $filtro . '%')
          ->orWhere('personas.numero_documento', 'like', '%' . $filtro . '%')
          ->select('personas.id','personas.nombre','personas.numero_documento')
          ->orderBy('personas.nombre', 'asc')->get();

          return['proveedores' => $proveedores];


        }

          public function store(Request $request)
          {
              if(!$request->ajax()) return redirect('/');

              try{
                  DB::beginTransaction();

                  $persona = new Persona();
                  $persona->nombre = $request->nombre;
                  $persona->tipo_documento = $request->tipo_documento;
                  $persona->numero_documento = $request->numero_documento;
                  $persona->direccion = $request->direccion;
                  $persona->telefono = $request->telefono;
                  $persona->email = $request->email;
                  $persona->save();

                  $proveedor = new Proveedor();
                  $proveedor->contacto = $request->contacto;
                  $proveedor->teleono_contacto = $request->teleono_contacto;
                  $proveedor->id = $persona->id;
                  $proveedor->save();

                   DB::commit();
              }catch(Exception $e){
                    DB::rollBack();
              }




          }

      public function update(Request $request)
      {
        if(!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

            //buscar el proveedor a modificar
            $proveedor = Proveedor::findOrFail($request->id);
            $persona = Persona::findOrFail($request->id);

            $persona->nombre           = $request->nombre;
            $persona->tipo_documento   = $request->tipo_documento;
            $persona->numero_documento = $request->numero_documento;
            $persona->direccion        = $request->direccion;
            $persona->telefono         = $request->telefono;
            $persona->email            = $request->email;
            $persona->save();


            $proveedor->contacto         = $request->contacto;
            $proveedor->teleono_contacto = $request->teleono_contacto;
            $proveedor->save();

             DB::commit();
        }catch(Exception $e){
              DB::rollBack();
        }

      }



}
