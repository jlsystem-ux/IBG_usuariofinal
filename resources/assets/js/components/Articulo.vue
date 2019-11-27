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
                  <i class="fa fa-align-justify"></i> Artículo
                  <button type="button" @click="abrirModal('articulo','registrar')" class="btn btn-secondary" >
                      <i class="icon-plus"></i>&nbsp;Nuevo
                  </button>
              </div>
              <div class="card-body">
                  <div class="form-group row">
                      <div class="col-md-6">
                          <div class="input-group">
                              <select class="form-control col-md-3" v-model="criterio">
                                <option value="nombre_articulo">Nombre</option>
                                <option value="descripcion">Descripción</option>
                              </select>
                              <input type="text"  v-model="buscar" @keyup.enter = "listarArticulo(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                              <button type="submit" @click="listarArticulo(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                          </div>
                      </div>
                  </div>
                  <div class="table-responsive">

                  <table class="table table-bordered table-striped table-sm">
                      <thead>
                          <tr>
                              <th>Opciones</th>
                              <th>Nombre</th>
                              <th>Precio venta</th>
                              <th>Cantidad</th>
                              <th>Descripción</th>
                              <th>Estado</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr v-for="articulo in arrayArticulo" :key="articulo.id">
                              <td>                                     <!-- Actualizar Modelo - metodo - objeto -->
                                  <button type="button" @click="abrirModal('articulo','actualizar',articulo)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                  </button> &nbsp;
                              <template  v-if="articulo.estado==1">
                                <button type="button" class="btn btn-danger btn-sm" @click="desactivarArticulo(articulo.id)">
                                  <i class="icon-trash"></i>
                                </button>
                              </template>
                              <template v-else="articulo.estado==0">
                                <button type="button" class="btn btn-info btn-sm" @click="activarArticulo(articulo.id)">
                                  <i class="icon-check"></i>
                                </button>
                              </template>


                              </td>
                                <td v-text="articulo.nombre_articulo"></td>
                                <td v-text="articulo.precio_venta"></td>
                                <td v-text="articulo.stock"></td>
                                <td v-text="articulo.descripcion"></td>
                             <td>
                                <span v-if="articulo.estado==1" class="badge badge-success">Activo</span>
                                <span v-if="articulo.estado==0" class="badge badge-danger">Desactivado</span>
                              </td>
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
                                  <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de Articulo">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-md-3 form-control-label" for="input">Precio</label>
                              <div class="col-md-9">
                                  <input type="input" v-model="precioVenta" class="form-control" placeholder="Precio">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-md-3 form-control-label" for="input">Cantidad Articulo</label>
                              <div class="col-md-9">
                                  <input type="input" v-model="stock" class="form-control" placeholder="Antidad articulo" >
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-md-3 form-control-label" for="input">Descripción Articulo</label>
                              <div class="col-md-9">
                                  <input type="input" v-model="descripcion" class="form-control" placeholder="Descripción">
                              </div>
                          </div>
                          <div v-show="errorArticulo" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjArticulo" :key="error" v-text="error">

                                    </div>
                                </div>
                          </div>
                      </form>
                  </div>
                  <div class="modal-footer">
                      <button type="button"  class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                      <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarArticulo()">Guardar</button>
                      <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarArticulo()">Actualizar</button>
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
                      articulo_id : 0,
                      nombre : '',
                      precioVenta : 0,
                      stock : 0,
                      descripcion : '',
                      estado : 1,
                      arrayArticulo : [],
                      modal : 0,
                      tituloModal : '',
                      tipoAccion : 0,
                      errorArticulo : 0,
                      errorMostrarMsjArticulo : [],
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
         {              // lista todos los articulos de la base de datos
                        listarArticulo (page,buscar,criterio){
                           let me = this;
                           var url = '/articulo?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                             axios.get(url).then(function (response) {
                               var respuesta = response.data;
                               me.arrayArticulo = respuesta.articulos.data;
                               me.pagination = respuesta.pagination;
                               // handle success
                              // console.log(response);
                            //  me.arrayArticulo = response.data;
                              })
                              .catch(function (error) {
                               // handle error
                               console.log(error + " este es el error");
                              })
                              .finally(function () {
                               // always executed
                              });
                        },
                        //Registra un articulo en la base de datos por medio  del metodo post

                        cambiarPagina(page,buscar,criterio){
                          let me = this;
                          //actualiza la pagina donde estoi
                          me.pagination.current_page = page;
                          //envia la peticion para visualizar la data  de esa pag
                          me.listarArticulo(page,buscar,criterio);
                        },

                        registrarArticulo(){

                            if(this.validarArticulo()){
                              return ;
                            }

                           let me = this;

                           axios.post('/articulo/registrar', {
                            //metodo store     //data with v-model
                             'nombreArticulo' : this.nombre,
                             'precio' : this.precioVenta,
                             'cantidadArticulo' : this.stock,
                             'descripcion' : this.descripcion

                           }).then(function (response) {
                              me.cerrarModal();
                              me.listarArticulo(1,'','nombre');
                            me.arrayArticulo = response.data;
                            })
                            .catch(function (error) {

                             console.log(error);
                            })
                            .finally(function () {
                             // always executed
                            });

                        }, //gegistrar fin

                        actualizarArticulo(){

                          if(this.validarArticulo()){
                            return ;
                          }

                         let me = this;
                          //  ojo terminar
                         axios.put('/articulo/actualizar', {
                           //metodo updated     //data with v-model
                           'nombreArticulo' : this.nombre,
                           'precio' : this.precioVenta,
                           'id' : this.articulo_id,
                           'cantidadArticulo' : this.stock,
                           'descripcion' : this.descripcion

                         }).then(function (response) {
                            me.cerrarModal();
                            me.listarArticulo(1,'','nombre');
                          me.arrayArticulo = response.data;
                          })
                          .catch(function (error) {

                           console.log(error);
                          })
                          .finally(function () {
                           // always executed
                          });


                        },//fin actualizar

                        desactivarArticulo(id)
                        {
                      const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                          confirmButton: 'btn btn-success',
                          cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                      })

                      swalWithBootstrapButtons.fire({
                        title: 'Estas seguro de desactivar esta categoria?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                      }).then((result) => {
                        if (result.value) {

                          let me = this;
                           //  ojo terminar
                          axios.put('/articulo/desactivar', {

                            'id' : id,

                          }).then(function (response) {
                             me.listarArticulo(1,'','nombre');
                             swalWithBootstrapButtons.fire(
                               'Desactivado!',
                               'El articulo ha sido desactivado con exito',
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

                  activarArticulo(id){
                      const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                          confirmButton: 'btn btn-success',
                          cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                      })

                      swalWithBootstrapButtons.fire({
                        title: 'Estas seguro de activar este articulo',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                      }).then((result) => {
                        if (result.value) {

                          let me = this;
                           //  ojo terminar
                          axios.put('/articulo/activar', {

                            'id' : id,

                          }).then(function (response) {
                             me.listarArticulo(1,'','nombre');
                             swalWithBootstrapButtons.fire(
                               'Activado!',
                               'El articulo ha sido activado con exito',
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

                        validarArticulo(){
                          this.errorArticulo = 0;
                          this.errorMostrarMsjArticulo = [];

                          if(!this.nombre) this.errorMostrarMsjArticulo.push("El nombre del articulo no puede estar vacio");
                          if(!this.precioVenta) this.errorMostrarMsjArticulo.push("El precio de venta no puede estar vacio");
                          if(!this.stock) this.errorMostrarMsjArticulo.push("La cantidad no puede estar vacia");

                          if(this.errorMostrarMsjArticulo.length) this.errorArticulo =1;

                          return this.errorArticulo;

                        },//cerrar validar Articulo
                        //actualiza
                        cerrarModal(){
                          this.modal = 0;
                          this.tituloModal ="";
                          this.nombre = "";
                          this.precioVenta ="";
                          this.stock ="";
                          this.descripcion ="";
                        },
                        abrirModal(modelo, accion, data = [])
                        {
                              switch (modelo)
                              {
                                      case "articulo":
                                      {
                                          switch (accion)
                                          {
                                                case 'registrar' :
                                                {
                                                  this.modal = 1;
                                                  this.tituloModal = 'Registrar Articulo';
                                                  this.nombre = '';
                                                  this.precioVenta = 0;
                                                  this.stock = 0;
                                                  this.descripcion = '';
                                                  this.estado = 1;
                                                  this.tipoAccion = 1;
                                                  break;

                                                }
                                                case 'actualizar' :
                                                {
                                                  //console.log(data);
                                                  this.modal = 1;
                                                  this.tituloModal ="Actualizar Articulo";
                                                  this.tipoAccion = 2;
                                                  this.nombre = data['nombre_articulo'];
                                                  this.articulo_id = data['id'];
                                                  this.stock = data['stock'];
                                                  this.precioVenta = data['precio_venta'];
                                                  this.descripcion =data['descripcion'];

                                                  break;
                                                }


                                          }
                                      }
                              }
                        },
            },
        mounted() {
             this.listarArticulo(1,this.buscar,this.criterio);
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
