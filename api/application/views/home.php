<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Inicio</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./">Inicio</a></li>
    </ol>
</div>
<div id="app">
    <!--Row-->
    <div class="row">
        <div class="col-lg-12">
            <div class="text-right">
                <a href="javascript:void(0)" class="btn btn-info" data-toggle="modal" data-target="#nuevo_analisis">
                    <i class="fa fa-plus-circle"></i> Nuevo análisis
                </a>
            </div>
        </div>
    </div>
    <div class="modal fade" id="nuevo_analisis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="exampleModalLabelLogout">Nuevo análisis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div v-if="msg_nuevo_analisis!=null" class="alert alert-danger mb-3">
                        <i class="fa fa-exclamation-circle"></i> {{msg_nuevo_analisis}}
                    </div>
                    <div v-if="load_buscar_cliente">
                        <div class="form-group">
                            <label>Número de identificación del cliente</label>
                            <input type="text" class="form-control" v-model="identificacion_cliente"
                                v-on:keyup.enter="get_cliente">
                            <div v-if="validate.identificacion_cliente" class="invalid-feedback">
                                Por favor digite el número de identificación del cliente.
                            </div>
                        </div>
                        <div class="text-right">
                            <a href="javascript:void(0)" class="btn btn-success" v-on:click="get_cliente">Continuar</a>
                            <button type="button" class="btn btn-outline-secondary"
                                data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                    <div v-else>
                        <div v-if="cliente.length==0">
                            <span class="text-info"><i class="fa fa-info-circle"></i> Cliente nuevo</span>
                            <div class="mt-2">
                                <a href="javascript:void(0)" class="text-primary" v-on:click="load_form_buscar_cliente">
                                    <i class="fa fa-chevron-left"></i> Digitar otro número de identificación
                                </a>
                            </div>
                            <form class="mt-3" v-on:submit.prevent="set_cliente">
                                <div class="form-group">
                                    <label>Nombres</label>
                                    <input type="text" class="form-control" v-model="nuevo_cliente.nombre">
                                    <div v-if="validate.nombre_cliente" class="invalid-feedback">
                                        Digite el nombre del cliente
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Apellidos</label>
                                    <input type="text" class="form-control" v-model="nuevo_cliente.apellido">
                                    <div v-if="validate.apellido_cliente" class="invalid-feedback">
                                        Digite el apellido del cliente
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Número de identificación</label>
                                    <input type="text" class="form-control" v-model="nuevo_cliente.num_id" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Correo electrónico</label>
                                    <input type="email" class="form-control" v-model="nuevo_cliente.email">
                                </div>
                                <div class="form-group">
                                    <label>Número de teléfono</label>
                                    <input type="text" class="form-control" v-model="nuevo_cliente.phone">
                                </div>
                                <div class="text-right">
                                    <a href="javascript:void(0)" class="btn btn-success" v-on:click="set_cliente">
                                        Guardar e iniciar informe
                                    </a>
                                    <button type="button" class="btn btn-outline-secondary"
                                        data-dismiss="modal">Cancelar
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div v-else>
                            <div class="card card-body">
                                <div class="mt-2 mb-2">
                                    <a href="javascript:void(0)" class="text-primary"
                                        v-on:click="load_form_buscar_cliente">
                                        <i class="fa fa-chevron-left"></i> Digitar otro número de identificación
                                    </a>
                                </div>
                                <span>Nombre del cliente:</span>
                                <h5 class="font-weight-bold">{{cliente.name}} {{cliente.lastname}}</h5>
                                <span>Identificación:</span>
                                <h5 class="font-weight-bold">{{cliente.num_id}}</h5>
                                <span>Correo electrónico:</span>
                                <h5 class="font-weight-bold">{{cliente.email}}</h5>
                            </div>
                            <div class="mt-3 text-right">
                                <a href="javascript:void(0)" class="btn btn-success" v-on:click="set_informe">
                                    Iniciar informe
                                </a>
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script src="<?=base_url()?>assets/js/app/home.js"></script>