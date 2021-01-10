<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Análisis</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?=base_url()?>">Inicio</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Análisis</a></li>
    </ol>
</div>
<div id="app">
    <div v-if="loading">
        <div class="text-center mx-auto">
            <small>Cargando...</small><br>
            <div class="spinner-border text-info" role="status">
                <span class="sr-only"></span>
            </div>
        </div>
    </div>
    <div v-else>
        <div v-if="analisis.length==0">
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-circle"></i> No se encontró el análisis consultado.
            </div>
        </div>
        <div v-else>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-body mb-3">
                        <div class="row">
                            <div class="col-lg-4">
                                <span class="text-muted font-weight-bold">Cliente</span>
                                <h5 class="font-weight-bold text-success">{{analisis.client.name}}</h5>
                            </div>
                            <div class="col-lg-4">
                                <span class="text-muted font-weight-bold">Correo electrónico</span>
                                <h5 class="font-weight-bold text-success">{{analisis.client.email}}</h5>
                            </div>
                            <div class="col-lg-4">
                                <span class="text-muted font-weight-bold">Teléfono</span>
                                <h5 class="font-weight-bold text-success">{{analisis.client.phone}}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">

                    <div class="mb-3">
                        <a v-bind:href="'#/'+id_analisis+'/1/1'"
                            v-bind:class="{'btn btn-info':tipo==1, 'btn btn-outline-info':tipo!=1}">
                            <i v-if="tipo==1" class="fa fa-circle"></i>
                            <i v-if="tipo!=1" class="far fa-circle"></i>
                            Análisis financiero 1
                        </a>
                        <a v-bind:href="'#/'+id_analisis+'/2/1'"
                            v-bind:class="{'btn btn-info':tipo==2, 'btn btn-outline-info':tipo!=2}">
                            <i v-if="tipo==2" class="fa fa-circle"></i>
                            <i v-if="tipo!=2" class="far fa-circle"></i>
                            Análisis financiero 2
                        </a>
                        <a v-bind:href="'#/'+id_analisis+'/3/1'"
                            v-bind:class="{'btn btn-info':tipo==3, 'btn btn-outline-info':tipo!=3}">
                            <i v-if="tipo==3" class="fa fa-circle"></i>
                            <i v-if="tipo!=3" class="far fa-circle"></i>
                            Análisis financiero 3
                        </a>
                    </div>

                    <div class="card card-body mb-4">
                        <h5 class="font-weight-bold text-primary">Análisis financiero {{tipo}}</h5>
                        <div v-if="tipo==1">
                            <a v-bind:href="'#/'+id_analisis+'/1/1'"
                                v-bind:class="{'btn btn-primary':seccion==1, 'btn btn-outline-primary':seccion!=1}"
                                class="mt-2">
                                <i v-if="seccion==1" class="fa fa-circle"></i>
                                <i v-if="seccion!=1" class="far fa-circle"></i>
                                Ventas
                            </a>
                            <a v-bind:href="'#/'+id_analisis+'/1/2'"
                                v-bind:class="{'btn btn-primary':seccion==2, 'btn btn-outline-primary':seccion!=2}"
                                class="mt-2">
                                <i v-if="seccion==2" class="fa fa-circle"></i>
                                <i v-if="seccion!=2" class="far fa-circle"></i>
                                Compras
                            </a>
                        </div>
                        <hr>
                        <div v-if="loading_content">
                            <div class="text-center mx-auto">
                                <small>Cargando...</small><br>
                                <div class="spinner-border text-info" role="status">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5 class="font-weight-bold text-primary">{{data.section}}</h5>
                                    <div v-if="results_data==0" class="text-muted mt-3">
                                        <i class="fa fa-info-circle"></i> No se han registrado datos
                                    </div>
                                    <div v-else>
                                        <div v-if="msg_edit_value!=null" class="alert alert-danger">
                                            <i class="fa fa-exclamation-circle"></i> {{msg_edit_value}}
                                        </div>
                                        <div v-if="tipo==1">
                                            <div>
                                                <div v-if="data.data.diary.results!=0">
                                                    <div class="card card-body">
                                                        <h6 class="text-info font-weight-bold">Díarias</h6>
                                                        <div class="row">
                                                            <div class="col-sm border text-center no_select"
                                                                v-for="(data, index_data) in data.data.diary.data"
                                                                v-on:dblclick="editar_dato(index_data,1)"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Doble click para editar">
                                                                <span
                                                                    class="text-uppercase font-weight-bold">{{data.label}}</span><br>
                                                                <div v-if="!form_edit_value || (index_data != index_data_selected) || frecuencia_selected!=1"
                                                                    class="text-primary font-weight-bold">
                                                                    <span v-if="data.value!=null">
                                                                        {{data.value.value_c}}
                                                                    </span>
                                                                </div>
                                                                <div
                                                                    v-if="form_edit_value && index_data == index_data_selected && frecuencia_selected==1">
                                                                    <input v-if="data.value!=null" type="text"
                                                                        class="form-control my_input"
                                                                        v-model="data.value.value"
                                                                        v-on:keyup.enter="update_data_value(index_data, 1)"
                                                                        v-on:keyup.esc="cerrar_editar_dato">
                                                                    <input v-if="data.value==null" type="text"
                                                                        class="form-control my_input"
                                                                        v-model="nuevo_valor"
                                                                        v-on:keyup.enter="set_valor_transaccion(index_data, 1)"
                                                                        v-on:keyup.esc="cerrar_editar_dato">
                                                                    <span class="text-muted">
                                                                        <a href="javascript:void(0)"
                                                                            v-on:click="cerrar_editar_dato"
                                                                            class="text-danger">
                                                                            <i class="fa fa-times"></i>
                                                                        </a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-lg-9 text-right">
                                                                Promedio:
                                                            </div>
                                                            <div class="col-lg-3 text-right">
                                                                <span class="text-success font-weight-bold">
                                                                    {{data.data.diary.average_c}}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-lg-9 text-right">
                                                                Total mensual:
                                                            </div>
                                                            <div class="col-lg-3 text-right">
                                                                <span class="text-success font-weight-bold">
                                                                    {{data.data.diary.total_c}}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-if="data.data.weekly.results!=0">
                                                    <div class="card card-body mt-3">
                                                        <h6 class="text-info font-weight-bold">Semanales</h6>
                                                        <div class="row">
                                                            <div class="col-sm border text-center no_select"
                                                                v-for="(data, index_data) in data.data.weekly.data"
                                                                v-on:dblclick="editar_dato(index_data,2)"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Doble click para editar">
                                                                <span
                                                                    class="text-uppercase font-weight-bold">{{data.label}}</span><br>
                                                                <div v-if="!form_edit_value || (index_data != index_data_selected) || frecuencia_selected!=2"
                                                                    class="text-primary font-weight-bold">
                                                                    <span v-if="data.value!=null">
                                                                        {{data.value.value_c}}
                                                                    </span>
                                                                </div>
                                                                <div
                                                                    v-if="form_edit_value && index_data == index_data_selected && frecuencia_selected==2">
                                                                    <input v-if="data.value!=null" type="text"
                                                                        class="form-control my_input"
                                                                        v-model="data.value.value"
                                                                        v-on:keyup.enter="update_data_value(index_data, 2)"
                                                                        v-on:keyup.esc="cerrar_editar_dato">
                                                                    <input v-if="data.value==null" type="text"
                                                                        class="form-control my_input"
                                                                        v-model="nuevo_valor"
                                                                        v-on:keyup.enter="set_valor_transaccion(index_data, 2)"
                                                                        v-on:keyup.esc="cerrar_editar_dato">
                                                                    <span class="text-muted">
                                                                        <a href="javascript:void(0)"
                                                                            v-on:click="cerrar_editar_dato"
                                                                            class="text-danger">
                                                                            <i class="fa fa-times"></i>
                                                                        </a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-lg-9 text-right">
                                                                Promedio:
                                                            </div>
                                                            <div class="col-lg-3 text-right">
                                                                <span class="text-success font-weight-bold">
                                                                    {{data.data.weekly.average_c}}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-lg-9 text-right">
                                                                Total mensual:
                                                            </div>
                                                            <div class="col-lg-3 text-right">
                                                                <span class="text-success font-weight-bold">
                                                                    {{data.data.weekly.total_c}}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-if="data.data.biweekly.results!=0">
                                                    <div class="card card-body mt-3">
                                                        <h6 class="text-info font-weight-bold">Quincenal</h6>
                                                        <div class="row">
                                                            <div class="col-sm border text-center no_select"
                                                                v-for="(data, index_data) in data.data.biweekly.data"
                                                                v-on:dblclick="editar_dato(index_data,3)"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Doble click para editar">
                                                                <span
                                                                    class="text-uppercase font-weight-bold">{{data.label}}</span><br>
                                                                <div v-if="!form_edit_value || (index_data != index_data_selected) || frecuencia_selected!=3"
                                                                    class="text-primary font-weight-bold">
                                                                    <span v-if="data.value!=null">
                                                                        {{data.value.value_c}}
                                                                    </span>
                                                                </div>
                                                                <div
                                                                    v-if="form_edit_value && index_data == index_data_selected && frecuencia_selected==3">
                                                                    <input v-if="data.value!=null" type="text"
                                                                        class="form-control my_input"
                                                                        v-model="data.value.value"
                                                                        v-on:keyup.enter="update_data_value(index_data, 3)"
                                                                        v-on:keyup.esc="cerrar_editar_dato">
                                                                    <input v-if="data.value==null" type="text"
                                                                        class="form-control my_input"
                                                                        v-model="nuevo_valor"
                                                                        v-on:keyup.enter="set_valor_transaccion(index_data, 3)"
                                                                        v-on:keyup.esc="cerrar_editar_dato">
                                                                    <span class="text-muted">
                                                                        <a href="javascript:void(0)"
                                                                            v-on:click="cerrar_editar_dato"
                                                                            class="text-danger">
                                                                            <i class="fa fa-times"></i>
                                                                        </a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-lg-9 text-right">
                                                                Promedio:
                                                            </div>
                                                            <div class="col-lg-3 text-right">
                                                                <span class="text-success font-weight-bold">
                                                                    {{data.data.biweekly.average_c}}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-lg-9 text-right">
                                                                Total mensual:
                                                            </div>
                                                            <div class="col-lg-3 text-right">
                                                                <span class="text-success font-weight-bold">
                                                                    {{data.data.biweekly.total_c}}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-if="data.data.monthly.results!=0">
                                                    <div class="card card-body mt-3">
                                                        <h6 class="text-info font-weight-bold">Mensual</h6>
                                                        <div class="row">
                                                            <div class="col-sm border text-right no_select"
                                                                v-for="(data, index_data) in data.data.monthly.data"
                                                                v-on:dblclick="editar_dato(index_data,4)"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Doble click para editar">
                                                                <div v-if="!form_edit_value || (index_data != index_data_selected) || frecuencia_selected!=4"
                                                                    class="text-primary font-weight-bold">
                                                                    <span v-if="data.value!=null">
                                                                        {{data.value.value_c}}
                                                                    </span>
                                                                </div>
                                                                <div
                                                                    v-if="form_edit_value && index_data == index_data_selected && frecuencia_selected==4">
                                                                    <input v-if="data.value!=null" type="text"
                                                                        class="form-control my_input"
                                                                        v-model="data.value.value"
                                                                        v-on:keyup.enter="update_data_value(index_data, 4)"
                                                                        v-on:keyup.esc="cerrar_editar_dato">
                                                                    <input v-if="data.value==null" type="text"
                                                                        class="form-control my_input"
                                                                        v-model="nuevo_valor"
                                                                        v-on:keyup.enter="set_valor_transaccion(index_data, 4)"
                                                                        v-on:keyup.esc="cerrar_editar_dato">
                                                                    <span class="text-muted">
                                                                        <a href="javascript:void(0)"
                                                                            v-on:click="cerrar_editar_dato"
                                                                            class="text-danger">
                                                                            <i class="fa fa-times"></i>
                                                                        </a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="mt-3">
                                                <div class="card card-body mt-3">
                                                    <h6 class="text-info font-weight-bold">Ventas por producción</h6>
                                                    <div v-if="msg_edit_production!=null"
                                                        class="alert alert-danger mt-2 mb-2">
                                                        <i class="fa fa-exclamation-circle"></i> {{msg_edit_production}}
                                                    </div>
                                                    <div v-if="data.data.production.data.length!=0">
                                                        <div class="row mb-2">
                                                            <div class="col-sm">
                                                                <small class="font-weight-bold">Cantidad</small>
                                                            </div>
                                                            <div class="col-sm">
                                                                <small class="font-weight-bold">Descripción</small>
                                                            </div>
                                                            <div class="col-sm">
                                                                <small class="font-weight-bold">Frecuencia</small>
                                                            </div>
                                                            <div class="col-sm text-right">
                                                                <small class="font-weight-bold">Total</small>
                                                            </div>
                                                            <div class="col-sm text-right"></div>
                                                        </div>
                                                        <div v-for="(production, index_production) in data.data.production.data"
                                                            class="row my_row_hover border-bottom mb-2">
                                                            <div class="col-sm">
                                                                <div
                                                                    v-if="form_edit_production && index_production == index_production_selected">
                                                                    <input type="number" class="form-control my_input"
                                                                        v-model="production.quantity"
                                                                        v-on:keyup.enter="update_production_value(index_production, 1)"
                                                                        v-on:keyup.esc="cerrar_editar_production">
                                                                </div>
                                                                <span v-else class="text-primary font-weight-bold">
                                                                    {{production.quantity}}
                                                                </span>
                                                            </div>
                                                            <div class="col-sm">
                                                                <div
                                                                    v-if="form_edit_production && index_production == index_production_selected">
                                                                    <input type="text" class="form-control my_input"
                                                                        v-model="production.description"
                                                                        v-on:keyup.enter="update_production_value(index_production, 1)"
                                                                        v-on:keyup.esc="cerrar_editar_production">
                                                                </div>
                                                                <span v-else class="text-primary font-weight-bold">
                                                                    {{production.description}}
                                                                </span>
                                                            </div>
                                                            <div class="col-sm">
                                                                <div
                                                                    v-if="form_edit_production && index_production == index_production_selected">
                                                                    <input type="text" class="form-control my_input"
                                                                        v-model="production.frequency"
                                                                        v-on:keyup.enter="update_production_value(index_production, 1)"
                                                                        v-on:keyup.esc="cerrar_editar_production">
                                                                </div>
                                                                <span v-else class="text-primary font-weight-bold">
                                                                    {{production.frequency}}
                                                                </span>
                                                            </div>
                                                            <div class="col-sm text-right">
                                                                <div
                                                                    v-if="form_edit_production && index_production == index_production_selected">
                                                                    <input type="text" class="form-control my_input"
                                                                        v-model="production.total"
                                                                        v-on:keyup.enter="update_production_value(index_production, 1)"
                                                                        v-on:keyup.esc="cerrar_editar_production">
                                                                </div>
                                                                <span v-else class="text-primary font-weight-bold">
                                                                    {{production.total_c}}
                                                                </span>
                                                            </div>
                                                            <div class="col-sm text-right">
                                                                <span
                                                                    v-if="form_edit_production && index_production == index_production_selected">
                                                                    <a href="javascript:void(0)"
                                                                        class="btn btn-success btn-sm"
                                                                        v-on:click="update_production(index_production)">
                                                                        <i class="fa fa-save"></i>
                                                                    </a>
                                                                    <a href="javascript:void(0)"
                                                                        class="btn btn-outline-secondary btn-sm"
                                                                        v-on:click="cerrar_editar_production">
                                                                        <i class="fa fa-times"></i>
                                                                    </a>
                                                                </span>
                                                                <span v-else>
                                                                    <a href="javascript:void(0)"
                                                                        class="btn btn-info btn-sm"
                                                                        v-on:click="editar_production(index_production)">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                    <a href="javascript:void(0)"
                                                                        class="btn btn-danger btn-sm"
                                                                        v-on:click="eliminar_production(index_production)">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-right mt-2">
                                                        <a href="javascript:void(0)" class="text-primary"
                                                            v-on:click="set_production">
                                                            <i class="fa fa-plus-circle"></i> Agregar
                                                        </a>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-lg-7 text-right">
                                                            Total ventas:
                                                        </div>
                                                        <div class="col-lg-3 text-right">
                                                            <span class="text-success font-weight-bold mr-4">
                                                                {{data.data.production.total_c}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <div class="card card-body">
                                                    <div class="row">
                                                        <div class="col-lg-9 text-right">
                                                            <h5 class="font-weight-bold">
                                                                Total ventas promedio - Info cliente:
                                                            </h5>
                                                        </div>
                                                        <div class="col-lg-3 text-right">
                                                            <h5 class="font-weight-bold text-success">
                                                                {{data.data.total_average_c}}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-9 text-right">
                                                            <h5 class="font-weight-bold">
                                                                Ventas por margen:
                                                            </h5>
                                                        </div>
                                                        <div class="col-lg-3 text-right">
                                                            <h5 class="font-weight-bold text-success">

                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <div class="card card-body mt-3">
                                                    <h6 class="text-info font-weight-bold">Participación en ventas</h6>
                                                    <div v-if="msg_edit_participation!=null"
                                                        class="alert alert-danger mt-2 mb-2">
                                                        <i class="fa fa-exclamation-circle"></i>
                                                        {{msg_edit_participation}}
                                                    </div>
                                                    <div v-if="data.data.participation.data.length!=0">
                                                        <div v-if="seccion==1">
                                                            <div class="row mb-2">
                                                                <div class="col-sm">
                                                                    <small class="font-weight-bold">Producto</small>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <small class="font-weight-bold">Descripción</small>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <small class="font-weight-bold">Unid.</small>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <small class="font-weight-bold">Cost. unit.</small>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <small class="font-weight-bold">P. Venta</small>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <small class="font-weight-bold">Partic. %</small>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <small class="font-weight-bold">Margen</small>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <small class="font-weight-bold">Ponderado</small>
                                                                </div>
                                                                <div class="col-sm"></div>
                                                            </div>
                                                            <div v-for="(participation, index_participation) in data.data.participation.data"
                                                                class="row my_row_hover border-bottom mb-2">
                                                                <div class="col-sm">
                                                                    <strong>Producto{{index_participation+1}}</strong>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <div
                                                                        v-if="form_edit_participation && index_participation == index_participation_selected">
                                                                        <input type="text" class="form-control my_input"
                                                                            v-model="participation.description"
                                                                            v-on:keyup.enter="update_participation_value(index_participation, 1)"
                                                                            v-on:keyup.esc="cerrar_editar_participation">
                                                                    </div>
                                                                    <span v-else class="text-primary font-weight-bold">
                                                                        {{participation.description}}
                                                                    </span>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <span class="text-success font-weight-bold">
                                                                        {{participation.unid}}
                                                                    </span>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <div
                                                                        v-if="form_edit_participation && index_participation == index_participation_selected">
                                                                        <input type="text" class="form-control my_input"
                                                                            v-model="participation.unit_cost"
                                                                            v-on:keyup.enter="update_participation_value(index_participation, 1)"
                                                                            v-on:keyup.esc="cerrar_editar_participation">
                                                                    </div>
                                                                    <span v-else class="text-primary font-weight-bold">
                                                                        {{participation.unit_cost_c}}
                                                                    </span>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <div
                                                                        v-if="form_edit_participation && index_participation == index_participation_selected">
                                                                        <input type="text" class="form-control my_input"
                                                                            v-model="participation.p_sale"
                                                                            v-on:keyup.enter="update_participation_value(index_participation, 1)"
                                                                            v-on:keyup.esc="cerrar_editar_participation">
                                                                    </div>
                                                                    <span v-else class="text-primary font-weight-bold">
                                                                        {{participation.p_sale_c}}
                                                                    </span>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <div
                                                                        v-if="form_edit_participation && index_participation == index_participation_selected">
                                                                        <input type="text" class="form-control my_input"
                                                                            v-model="participation.participation"
                                                                            v-on:keyup.enter="update_participation_value(index_participation, 1)"
                                                                            v-on:keyup.esc="cerrar_editar_participation">
                                                                    </div>
                                                                    <span v-else class="text-primary font-weight-bold">
                                                                        {{participation.participation}}%
                                                                    </span>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <span class="text-success font-weight-bold">
                                                                        {{participation.margin}}%
                                                                    </span>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <span class="text-success font-weight-bold">
                                                                        {{participation.weighted}}%
                                                                    </span>
                                                                </div>
                                                                <div class="col-sm text-right">
                                                                    <span
                                                                        v-if="form_edit_participation && index_participation == index_participation_selected">
                                                                        <a href="javascript:void(0)"
                                                                            class="btn btn-success btn-sm"
                                                                            v-on:click="update_participation(index_participation)">
                                                                            <i class="fa fa-save"></i>
                                                                        </a>
                                                                        <a href="javascript:void(0)"
                                                                            class="btn btn-outline-secondary btn-sm"
                                                                            v-on:click="cerrar_editar_participation">
                                                                            <i class="fa fa-times"></i>
                                                                        </a>
                                                                    </span>
                                                                    <span v-else>
                                                                        <a href="javascript:void(0)"
                                                                            class="btn btn-info btn-sm"
                                                                            v-on:click="editar_participation(index_participation)">
                                                                            <i class="fa fa-edit"></i>
                                                                        </a>
                                                                        <a href="javascript:void(0)"
                                                                            class="btn btn-danger btn-sm"
                                                                            v-on:click="eliminar_participation(index_participation)">
                                                                            <i class="fa fa-trash"></i>
                                                                        </a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-else>
                                                            <div class="row mb-2">
                                                                <div class="col-sm">
                                                                    <small class="font-weight-bold">Producto</small>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <small class="font-weight-bold">Descripción</small>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <small class="font-weight-bold">Unid.</small>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <small class="font-weight-bold">Cost. unit.</small>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <small class="font-weight-bold">P. Venta</small>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <small class="font-weight-bold">Partic. %</small>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <small class="font-weight-bold">Margen</small>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <small class="font-weight-bold">Ponderado</small>
                                                                </div>
                                                                <div class="col-sm"></div>
                                                            </div>
                                                            <div v-for="(participation, index_participation) in data.data.participation.data"
                                                                class="row my_row_hover border-bottom mb-2">
                                                                <div class="col-sm">
                                                                    <strong>Producto{{index_participation+1}}</strong>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <div
                                                                        v-if="form_edit_participation && index_participation == index_participation_selected">
                                                                        <input type="text" class="form-control my_input"
                                                                            v-model="participation.description"
                                                                            v-on:keyup.enter="update_participation_value(index_participation, 1)"
                                                                            v-on:keyup.esc="cerrar_editar_participation">
                                                                    </div>
                                                                    <span v-else class="text-primary font-weight-bold">
                                                                        {{participation.description}}
                                                                    </span>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <span class="text-success font-weight-bold">
                                                                        {{participation.unid}}
                                                                    </span>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <div
                                                                        v-if="form_edit_participation && index_participation == index_participation_selected">
                                                                        <input type="text" class="form-control my_input"
                                                                            v-model="participation.unit_cost"
                                                                            v-on:keyup.enter="update_participation_value(index_participation, 1)"
                                                                            v-on:keyup.esc="cerrar_editar_participation">
                                                                    </div>
                                                                    <span v-else class="text-primary font-weight-bold">
                                                                        {{participation.unit_cost_c}}
                                                                    </span>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <div
                                                                        v-if="form_edit_participation && index_participation == index_participation_selected">
                                                                        <input type="text" class="form-control my_input"
                                                                            v-model="participation.p_sale"
                                                                            v-on:keyup.enter="update_participation_value(index_participation, 1)"
                                                                            v-on:keyup.esc="cerrar_editar_participation">
                                                                    </div>
                                                                    <span v-else class="text-primary font-weight-bold">
                                                                        {{participation.p_sale_c}}
                                                                    </span>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <div
                                                                        v-if="form_edit_participation && index_participation == index_participation_selected">
                                                                        <input type="text" class="form-control my_input"
                                                                            v-model="participation.participation"
                                                                            v-on:keyup.enter="update_participation_value(index_participation, 1)"
                                                                            v-on:keyup.esc="cerrar_editar_participation">
                                                                    </div>
                                                                    <span v-else class="text-primary font-weight-bold">
                                                                        {{participation.participation}}%
                                                                    </span>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <span class="text-success font-weight-bold">
                                                                        {{participation.margin}}%
                                                                    </span>
                                                                </div>
                                                                <div class="col-sm">
                                                                    <span class="text-success font-weight-bold">
                                                                        {{participation.weighted}}%
                                                                    </span>
                                                                </div>
                                                                <div class="col-sm text-right">
                                                                    <span
                                                                        v-if="form_edit_participation && index_participation == index_participation_selected">
                                                                        <a href="javascript:void(0)"
                                                                            class="btn btn-success btn-sm"
                                                                            v-on:click="update_participation(index_participation)">
                                                                            <i class="fa fa-save"></i>
                                                                        </a>
                                                                        <a href="javascript:void(0)"
                                                                            class="btn btn-outline-secondary btn-sm"
                                                                            v-on:click="cerrar_editar_participation">
                                                                            <i class="fa fa-times"></i>
                                                                        </a>
                                                                    </span>
                                                                    <span v-else>
                                                                        <a href="javascript:void(0)"
                                                                            class="btn btn-info btn-sm"
                                                                            v-on:click="editar_participation(index_participation)">
                                                                            <i class="fa fa-edit"></i>
                                                                        </a>
                                                                        <a href="javascript:void(0)"
                                                                            class="btn btn-danger btn-sm"
                                                                            v-on:click="eliminar_participation(index_participation)">
                                                                            <i class="fa fa-trash"></i>
                                                                        </a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="text-right mt-2">
                                                        <a href="javascript:void(0)" class="text-primary"
                                                            v-on:click="set_participation">
                                                            <i class="fa fa-plus-circle"></i> Agregar
                                                        </a>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-sm-5 text-right">
                                                            Total P. Venta
                                                        </div>
                                                        <div class="col-sm-2 text-center">
                                                            <span class="text-success font-weight-bold">
                                                                {{data.data.participation.total_p_sale_c}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-sm-8 text-right">
                                                            Total Margen
                                                        </div>
                                                        <div class="col-sm-3 text-right">
                                                            <span class="text-success font-weight-bold mr-5">
                                                                {{data.data.participation.total_margin}}%
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?=base_url()?>assets/js/app/analysis.js"></script>