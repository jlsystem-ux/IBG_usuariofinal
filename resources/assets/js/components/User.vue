<template>
  <main class="main">
      <!-- Breadcrumb -->
      <ol class="breadcrumb">
          <li class="breadcrumb-item">Home</li>
          <li class="breadcrumb-item"><a href="#">Admin</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
      </ol>
      <div class="container-fluid">
          <!-- Ejemplo de tabla Listado -->
          <div class="card">
              <div class="card-header">
                  <i class="fa fa-align-justify"></i> Proveedores
                  <button type="button" @click="abrirModal('persona','registrar')" class="btn btn-secondary" >
                      <i class="icon-plus"></i>&nbsp;Nuevo
                  </button>
              </div>
              <div class="card-body">
                  <div class="form-group row">
                      <div class="col-md-6">
                          <div class="input-group">
                              <select class="form-control col-md-3" v-model="criterio">
                                <option value="nombre">Nombre</option>
                                <option value="numero_documento">Documento</option>
                                <option value="email">Email</option>
                                <option value="telefono">Teléfono</option>
                              </select>
                              <input type="text"  v-model="buscar" @keyup.enter = "listarPersona(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                              <button type="submit" @click="listarPersona(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                          </div>
                      </div>
                  </div>
                  <div class="table-responsive">
                  <table class="table table-bordered table-striped table-sm">
                      <thead>
                          <tr>
                              <th>Opciones</th>
                              <th>Nombre Empresa</th>
                              <th>Tipo Docuento</th>
                              <th>Número</th>
                              <th>Teléfono</th>
                              <th>Email</th>
                              <th>Usuario</th>
                              <th>Rol</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr v-for="persona in arrayPersona" :key="persona.id">
                              <td>                                     <!-- Actualizar Modelo - metodo - objeto -->
                                  <button type="button" @click="abrirModal('persona','actualizar',persona)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                  </button>&nbsp;

                                  <template  v-if="persona.condicion == 1">
                                    <button type="button" class="btn btn-danger btn-sm" @click="desactivarUsuario(persona.id)">
                                      <i class="icon-trash"></i>
                                    </button>
                                  </template>

                                  <template v-if="persona.condicion == 0">
                                    <button type="button" class="btn btn-info btn-sm" @click="activarUsuario(persona.id)">
                                      <i class="icon-check"></i>
                                    </button>
                                  </template>
                              </td>

                                <td v-text="persona.nombre"></td>
                                <td v-text="persona.tipo_documento"></td>
                                <td v-text="persona.numero_documento"></td>
                                <td v-text="persona.telefono"></td>
                                <td v-text="persona.email"></td>
                                <td v-text="persona.usuario"></td>
                                <td v-text="persona.rol"></td>

                          </tr>
                      </tbody>
                  </table>
                  </div>
                  <nav>
                      <ul class="pagination">
                          <li class="page-item" v-if="pagination.current_page > 1">
                              <a class="page-link" href="#" @click.prevent = "cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                          </li>
                          <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '' ]">
                              <a class="page-link" href="#" @click.prevent ="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                          </li>
                          <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                              <a class="page-link" href="#" @click.prevent ="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                          </li>
                      </ul>
                  </nav>
              </div>
          </div>
          <!-- Fin ejemplo de tabla Listado -->
      </div>
      <!--Inicio del modal agregar/actualizar-->
      <div class="modal fade"  tabindex="-1" :class="{'mostrar' : modal}"  role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
          <div class="modal-dialog modal-primary modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title" v-text="tituloModal"></h4>
                      <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                          <div class="form-group row">
                              <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                              <div class="col-md-9">
                                  <input type="text" v-model="nombre" class="form-control" placeholder="Nombre Completo">
                              </div>
                          </div>

                          <div class="form-group row">
                              <label class="col-md-3 form-control-label" for="input">Tipo Documento</label>
                              <div class="col-md-9">
                                <select  v-model="tipo_documento" class="form-control" >
                                        <option value="DNI">DNI</option>
                                        <option value="PASS">Pasaporte</option>
                                        <option value="CC">Cedula</option>
                                        <option value="TI">Tarjeta identidad</option>
                                </select>
                            </div>
                          </div>
                           <!--Numero Documento -->
                          <div class="form-group row">
                              <label class="col-md-3 form-control-label" for="text-input">Numero Documento</label>
                              <div class="col-md-9">
                                  <input type="text" v-model="numero_documento" class="form-control" placeholder="Número documento">
                              </div>
                          </div>
                            <!--Telefono -->
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Teléfono</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="telefono" class="form-control" placeholder="Teléfono">
                                </div>
                            </div>
                              <!--Email -->
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Correo Electronico</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="email" class="form-control" placeholder="Correo Electronico">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Rol (*)</label>
                                <div class="col-md-9">
                                  <select class="form-control" v-model="idrol">
                                    <option value="0">Seleccione un rol </option>
                                    <option v-for="rol in arrayRol" :key="rol.id" :value="rol.id" v-text="rol.nombre"></option>
                                  </select>
                                </div>
                            </div>
                                <!--Contacto Proveedor -->
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Usuario (*)</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="usuario" class="form-control" placeholder="Nombre Usuario">
                                </div>
                            </div>
                            <!--Contacto Proveedor -->
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Password</label>
                                <div class="col-md-9">
                                    <input type="password" v-model="password" class="form-control" placeholder="Escriba password">
                                </div>
                            </div>

                          <div v-show="errorPersona" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error">

                                    </div>
                                </div>
                          </div>
                      </form>
                  </div>
                  <div class="modal-footer">
                      <button type="button"  class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                      <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPersona()">Guardar</button>
                      <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPersona()">Actualizar</button>
                  </div>
              </div>
              <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
      </div>
      <!--Fin del modal-->
      <!-- Inicio del modal Eliminar -->

      <!-- Fin del modal Eliminar -->
  </main>
</template>

<script>
    export default {
            //en data se declaran las variables a usar
        data() {
               return{
                      persona_id : 0,
                      nombre : '',
                      tipo_documento : 'CC',
                      numero_documento : '',
                      direccion : '',
                      telefono : '',
                      email : '',
                      usuario : '',
                      password : '',
                      idrol : 0,

                      arrayPersona : [],
                      arrayRol : [],
                      modal : 0,
                      tituloModal : '',
                      tipoAccion : 0,
                      errorPersona : 0,
                      errorMostrarMsjPersona : [],
                      pagination : {
                        'total'         :0,
                        'current_page'  :0,
                        'per_page'      :0,
                        'last_page'     :0,
                        'from'          :0,
                        'to'            :0,
                      },
                        offset   : 3,
                        criterio : 'nombre',
                        buscar   : ''
               }
         },
         computed : {
                        isActived: function(){
                          return this.pagination.current_page;
                        },
                        //calcula los elementos de la pagination
                        pagesNumber : function(){
                              if(!this.pagination.to){
                                  return [];
                              }
                              //pagina 1
                          var from = this.pagination.current_page - this.offset;
                              if(from < 1 ){
                                from = 1;
                              }
                              //ultima pagina
                          var to = from + (this.offset * 2);
                              if(to >= this.pagination.last_page ){
                                to = this.pagination.last_page;
                              }

                              //cambiando la paginacion
                              var pagesArray = [];
                              while (from <= to) {
                                pagesArray.push(from);
                                from++;
                              }
                              return pagesArray;
                        }

         },
        methods :
         {


                   // lista todos los Persons de la base de datos
                        listarPersona (page,buscar,criterio){
                           let me = this;
                           var url = '/user?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                             axios.get(url).then(function (response) {
                               var respuesta = response.data;
                               me.arrayPersona = respuesta.personas.data;
                               me.pagination = respuesta.pagination;

                              })
                              .catch(function (error) {
                               // handle error
                               console.log(error + " este es el error");
                              })
                              .finally(function () {
                               // always executed
                              });
                        },

                        //Registra un cliente en la base de datos por medio  del metodo post

                        selectRol(){
                          let me = this;
                          var url = '/rol/selectRol';
                            axios.get(url).then(function (response) {
                              var respuesta = response.data;
                              me.arrayRol = respuesta.roles;

                             })
                             .catch(function (error) {
                              // handle error
                              console.log(error + " este es el error");
                             })
                             .finally(function () {
                              // always executed
                             });

                        },

                        cambiarPagina(page,buscar,criterio){
                          let me = this;
                          //actualiza la pagina donde estoi
                          me.pagination.current_page = page;
                          //envia la peticion para visualizar la data  de esa pag
                          me.listarPersona(page,buscar,criterio);
                        },

                        registrarPersona(){

                            if(this.validarPersona()){
                              return ;
                            }

                           let me = this;

                           axios.post('/user/registrar', {
                            //metodo store     //data with v-model
                             'nombre' : this.nombre,
                             'tipo_documento' : this.tipo_documento,
                             'numero_documento' : this.numero_documento,
                             'direccion' : this.direccion,
                             'telefono' : this.telefono,
                             'email' : this.email,
                             'usuario' : this.usuario,
                             'password' : this.password,
                             'idrol'   : this.idrol


                           }).then(function (response) {
                              me.cerrarModal();
                              me.listarPersona(1,'','nombre');
                            me.arrayPersona = response.data;
                            })
                            .catch(function (error) {

                             console.log(error);
                            })
                            .finally(function () {
                             // always executed
                            });

                        }, //gegistrar fin

                        actualizarPersona(){

                          if(this.validarPersona()){
                            return ;
                          }

                         let me = this;

                         axios.put('/user/actualizar', {
                           //metodo updated     //data with v-model

                           'nombre' : this.nombre,
                           'tipo_documento' : this.tipo_documento,
                           'numero_documento' : this.numero_documento,
                           'direccion' : this.direccion,
                           'telefono' : this.telefono,
                           'email' : this.email,
                            'id' : this.persona_id,
                            'usuario' : this.usuario,
                            'password' : this.password,
                            'idrol'   : this.idrol

                         }).then(function (response) {
                            me.cerrarModal();
                            me.listarPersona(1,'','nombre');
                            me.arrayPersona = response.data;
                          })
                          .catch(function (error) {

                           console.log(error);
                          })
                          .finally(function () {
                           // always executed
                          });


                        },//fin actualizar

                        validarPersona(){
                          this.errorPersona = 0;
                          this.errorMostrarMsjPersona = [];

                          if(!this.nombre) this.errorMostrarMsjPersona.push("El nombre de la persona no puede estar vacio");
                          if(!this.usuario) this.errorMostrarMsjPersona.push("El nombre de usuario no puede estar vacio");
                          if(!this.password) this.errorMostrarMsjPersona.push("El password no puede estar vacio");
                          if(this.idrol == 0) this.errorMostrarMsjPersona.push("Debe seleccionar un rol para el usuario");
                          if(this.errorMostrarMsjPersona.length) this.errorPersona =1;

                          return this.errorPersona;

                        },//cerrar validar Persona
                        //actualiza
                        cerrarModal(){
                          //v-molde
                          this.modal = 0;
                          this.tituloModal ="";
                          this.nombre = "";
                          this.tipo_documento = 'CC';
                          this.numero_documento = '';
                          this.direccion = '';
                          this.telefono = '';
                          this.email = '';
                          this.usuario = '';
                          this.password = '';
                          this.idrol = 0 ;
                          this.errorPersona = 0;

                        },
                        abrirModal(modelo, accion, data = [])
                        {    this.selectRol();
                              switch (modelo)
                              {
                                      case "persona":
                                      {
                                          switch (accion)
                                          {
                                                case 'registrar' :
                                                {
                                                  this.modal = 1;
                                                  this.tituloModal = 'Registrar User';
                                                  this.nombre = "";
                                                  this.tipo_documento = 'CC';
                                                  this.numero_documento = '';
                                                  this.direccion = '';
                                                  this.telefono = '';
                                                  this.email = '';
                                                  this.usuario = '';
                                                  this.password = '';
                                                  this.idrol = 0 ;
                                                  this.tipoAccion = 1;
                                                  break;

                                                }
                                                case 'actualizar' :
                                                {
                                                  //console.log(data);
                                                  this.modal             = 1;
                                                  this.tituloModal       ="Actualizar Usuario";
                                                  this.tipoAccion        = 2;
                                                  this.persona_id        = data['id'];
                                                  this.nombre            = data['nombre'];
                                                  this.tipo_documento    = data['tipo_documento'];
                                                  this.numero_documento  = data['numero_documento'];
                                                  this.direccion         = data['direccion'];
                                                  this.telefono          = data['telefono'];
                                                  this.email             = data['email'];
                                                  this.usuario           = data['usuario'];
                                                  this.password          = data['password'];
                                                  this.idrol             = data['idrol'];
                                                  break;
                                                }


                                          }
                                      }
                              }
                        },

                        desactivarUsuario(id)
                        {
                              const swalWithBootstrapButtons = Swal.mixin({
                                customClass: {
                                  confirmButton: 'btn btn-success',
                                  cancelButton: 'btn btn-danger'
                                },
                                buttonsStyling: false
                              })

                              swalWithBootstrapButtons.fire({
                                title: 'Estas seguro de desactivar este usuario?',
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Aceptar',
                                cancelButtonText: 'Cancelar',
                                reverseButtons: true
                              }).then((result) => {
                                if (result.value) {

                                  let me = this;
                                   //  ojo terminar
                                  axios.put('/user/desactivar', {

                                    'id' : id,

                                  }).then(function (response) {
                                     me.listarPersona(1,'','nombre');
                                     swalWithBootstrapButtons.fire(
                                       'Desactivado!',
                                       'El usuario ha sido desactivado con exito',
                                       'success'
                                     )

                                   })
                                   .catch(function (error) {

                                    console.log(error);
                                   })
                                   .finally(function () {
                                    // always executed
                                   });

                                } else if (
                                  /* Read more about handling dismissals below */
                                  result.dismiss === Swal.DismissReason.cancel
                                ) {

                                }
                              })
                        },

                        activarUsuario(id){
                          const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                              confirmButton: 'btn btn-success',
                              cancelButton: 'btn btn-danger'
                            },
                            buttonsStyling: false
                          })

                          swalWithBootstrapButtons.fire({
                            title: 'Estas seguro de activar este usuario',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Aceptar',
                            cancelButtonText: 'Cancelar',
                            reverseButtons: true
                          }).then((result) => {
                            if (result.value) {

                              let me = this;
                               //  ojo terminar
                              axios.put('/user/activar', {

                                'id' : id,

                              }).then(function (response) {
                                 me.listarPersona(1,'','nombre');
                                 swalWithBootstrapButtons.fire(
                                   'Activado!',
                                   'El usuario ha sido activado con exito',
                                   'success'
                                 )

                               })
                               .catch(function (error) {

                                console.log(error);
                                   })
                                   .finally(function () {
                                    // always executed
                                   });

                                } else if (
                                  /* Read more about handling dismissals below */
                                  result.dismiss === Swal.DismissReason.cancel
                                ) {

                                }
                              })
                      },

            },

        mounted() {
             this.listarPersona(1,this.buscar,this.criterio);
        }
    }

</script>

<style>
  .modal-content
              {
                width: 100% !important;
                position: absolute !important;
              }
  .mostrar
              {
                display: list-item !important;
                opacity:  1 !important;
                position:  absolute  !important;
                background-color: #3c29297a !important;

              }

  .div-error
              {
                display: flex;
                justify-content: center;
              }
  .text-error {
              color: red !important;
              font-weight: bold;
              }

</style>
