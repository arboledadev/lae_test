const routes = [
    { path: '/:id_analysis/:type/:section' },
]
const router = new VueRouter({
    routes // short for `routes: routes`
})
const app = new Vue({
    el: '#app',
    router,
    data() {
        return {
            base_url: base_url,
            loading: true,
            loading_content: true,
            id_analisis: null,
            analisis: [],
            tipo: 1,
            seccion: 1,
            data: [],
            results_data: 0,
            form_edit_value: false,
            form_edit_production: false,
            form_edit_participation: false,
            index_data_selected: null,
            index_production_selected: null,
            index_participation_selected: null,
            frecuencia_selected: null,
            msg_edit_value: null,
            msg_edit_production: null,
            msg_edit_participation: null,
            nuevo_valor: null
        }
    },
    created: function () {
        this.id_analisis = this.$route.params.id_analysis;
        this.tipo = this.$route.params.type;
        this.seccion = this.$route.params.section;
        this.get_analisis();
    },
    methods: {
        get_analisis: function () {
            this.loading = true;
            var token_session = localStorage.getItem("token_session");
            if (token_session == null) {
                location.href = base_url + 'auth/login';
            }
            const headers = {
                'Content-Type': 'application/json',
                'x-api-key': api_key
            };
            var params = {
                'token_session': token_session
            };
            let config = {
                headers: headers,
                params: params
            };
            axios
                .get(base_url + 'api/analisis/get_analisis/' + this.id_analisis, config, {
                    headers: headers
                })
                .then(response => {
                    if (response.data.status) {
                        if (response.data.results != 0) {
                            this.analisis = response.data.data;
                            this.get_data();
                        } else {
                            this.analisis = [];
                        }
                    }
                })
                .catch(
                    error => {
                        if (error.response.status == 401) {
                            localStorage.removeItem("token_session");
                            localStorage.removeItem("session");
                            location.href = base_url + "auth/login";
                        }
                    }
                )
                .finally(() => this.loading = false);
        },
        get_data: function () {
            var token_session = localStorage.getItem("token_session");
            if (token_session == null) {
                location.href = base_url + 'auth/login';
            }
            const headers = {
                'Content-Type': 'application/json',
                'x-api-key': api_key
            };
            var params = {
                'token_session': token_session,
                'tipo': this.tipo,
                'seccion': this.seccion
            };
            let config = {
                headers: headers,
                params: params
            };
            axios
                .get(base_url + 'api/analisis/get_data/' + this.id_analisis, config, {
                    headers: headers
                })
                .then(response => {
                    if (response.data.status) {
                        this.data = response.data.data;
                        this.results_data = response.data.results;
                    }
                })
                .catch(
                    error => {
                        if (error.response.status == 401) {
                            localStorage.removeItem("token_session");
                            localStorage.removeItem("session");
                            location.href = base_url + "auth/login";
                        }
                    }
                )
                .finally(() => this.loading_content = false);
        },
        editar_dato: function (index_data, frecuencia) {
            this.frecuencia_selected = frecuencia;
            this.index_data_selected = index_data;
            this.form_edit_value = true;
        },
        cerrar_editar_dato: function () {
            this.index_data_selected = null;
            this.form_edit_value = false;
            this.msg_edit_value = null;
        },
        set_valor_transaccion: function (index_data, frecuencia) {
            this.msg_edit_value = null;
            var token_session = localStorage.getItem("token_session");
            if (token_session == null) {
                location.href = base_url + 'auth/login';
            }
            if ((this.nuevo_valor == null || this.nuevo_valor == "") && this.nuevo_valor !== 0) {
                this.msg_edit_value = "Digite el valor a registrar.";
                return false;
            }
            if (isNaN(this.nuevo_valor)) {
                this.msg_edit_value = "El valor debe ser numérico.";
                return false;
            }
            var params = {
                'token_session': token_session,
                'id_analisis': this.id_analisis,
                'tipo': this.seccion,
                'frecuencia': frecuencia,
                'frecuencia_key': index_data,
                'value': this.nuevo_valor
            };
            const headers = {
                'Content-Type': 'application/json',
                'x-api-key': api_key
            };
            axios.post(base_url + 'api/analisis/set_value_transaction', params, { headers: headers })
                .then(function (response) {
                    if (response.data.status) {
                        app.nuevo_valor = null;
                        app.form_edit_value = false;
                        app.get_data();
                    } else {
                        app.msg_nuevo_analisis = "Ocurrió un error al intentar registrar el valor.";
                        console.log(error);
                    }
                })
                .catch(
                    error => {
                        if (error.response.status == 401) {
                            localStorage.removeItem("token_session");
                            localStorage.removeItem("session");
                            location.href = base_url + "auth/login";
                            return false;
                        }
                        app.msg_nuevo_analisis = "Ocurrió un error al intentar registrar el valor.";
                    });
        },
        update_data_value: function (index_data, tipo) {
            this.msg_edit_value = null;
            var token_session = localStorage.getItem("token_session");
            if (token_session == null) {
                location.href = base_url + 'auth/login';
            }

            switch (tipo) {
                case 1:
                    var valor = this.data.data.diary.data[index_data].value.value;
                    var id_transaccion = this.data.data.diary.data[index_data].value.id_transaction;
                    break;

                case 2:
                    var valor = this.data.data.weekly.data[index_data].value.value;
                    var id_transaccion = this.data.data.weekly.data[index_data].value.id_transaction;
                    break;

                case 3:
                    var valor = this.data.data.biweekly.data[index_data].value.value;
                    var id_transaccion = this.data.data.biweekly.data[index_data].value.id_transaction;
                    break;

                case 4:
                    var valor = this.data.data.monthly.data[index_data].value.value;
                    var id_transaccion = this.data.data.monthly.data[index_data].value.id_transaction;
                    break;
            }


            if ((valor == null || valor == "") && valor !== 0) {
                this.msg_edit_value = "Digite el valor a registrar.";
                return false;
            }
            if (isNaN(valor)) {
                this.msg_edit_value = "El valor debe ser numérico.";
                return false;
            }
            var params = {
                'token_session': token_session,
                'id_transaccion': id_transaccion,
                'valor': valor
            };
            const headers = {
                'Content-Type': 'application/json',
                'x-api-key': api_key
            };
            axios.put(base_url + 'api/analisis/update_value_transaction', params, { headers: headers })
                .then(function (response) {
                    if (response.data.status) {
                        app.nuevo_valor = null;
                        app.form_edit_value = false;
                        app.get_data();
                    } else {
                        app.msg_edit_value = "Ocurrió un error al intentar actualizar el valor.";
                        console.log(error);
                    }
                })
                .catch(
                    error => {
                        if (error.response.status == 401) {
                            localStorage.removeItem("token_session");
                            localStorage.removeItem("session");
                            location.href = base_url + "auth/login";
                            return false;
                        }
                        app.msg_edit_value = "Ocurrió un error al intentar registrar el valor.";
                    });
        },
        editar_production: function (index_production) {
            this.index_production_selected = index_production;
            this.form_edit_production = true;
        },
        cerrar_editar_production: function () {
            this.index_production_selected = null;
            this.form_edit_production = false;
        },
        set_production: function () {
            this.msg_edit_production = null;
            var token_session = localStorage.getItem("token_session");
            if (token_session == null) {
                location.href = base_url + 'auth/login';
            }
            var params = {
                'token_session': token_session,
                'tipo': this.seccion,
                'id_analisis': this.id_analisis
            };
            const headers = {
                'Content-Type': 'application/json',
                'x-api-key': api_key
            };
            axios.post(base_url + 'api/analisis/set_production', params, { headers: headers })
                .then(function (response) {
                    if (response.data.status) {
                        app.get_data();
                        var nuevo_index = app.data.data.production.data.length;
                        app.editar_production(nuevo_index);
                    } else {
                        app.msg_edit_production = "Ocurrió un error al intentar realizar el registro.";
                        console.log(error);
                    }
                })
                .catch(
                    error => {
                        if (error.response.status == 401) {
                            localStorage.removeItem("token_session");
                            localStorage.removeItem("session");
                            location.href = base_url + "auth/login";
                            return false;
                        }
                        app.msg_edit_production = "Ocurrió un error al intentar realizar el registro.";
                    });
        },
        update_production: function (index_production) {
            this.msg_edit_production = null;
            var token_session = localStorage.getItem("token_session");
            if (token_session == null) {
                location.href = base_url + 'auth/login';
            }
            var produccion = this.data.data.production.data[index_production];
            var params = {
                'token_session': token_session,
                'id_produccion': produccion.id_production_transaction,
                'cantidad': produccion.quantity,
                'descripcion': produccion.description,
                'frecuencia': produccion.frequency,
                'total': produccion.total,
            };
            const headers = {
                'Content-Type': 'application/json',
                'x-api-key': api_key
            };
            axios.put(base_url + 'api/analisis/update_production', params, { headers: headers })
                .then(function (response) {
                    if (response.data.status) {
                        app.form_edit_production = false;
                        app.get_data();
                    } else {
                        app.msg_edit_production = "Ocurrió un error al intentar actualizar el valor.";
                        console.log(error);
                    }
                })
                .catch(
                    error => {
                        if (error.response.status == 401) {
                            localStorage.removeItem("token_session");
                            localStorage.removeItem("session");
                            location.href = base_url + "auth/login";
                            return false;
                        }
                        app.msg_edit_production = "Ocurrió un error al intentar actualizar el valor.";
                    });
        },
        eliminar_production: function (index_production) {
            this.msg_edit_production = null;
            var token_session = localStorage.getItem("token_session");
            if (token_session == null) {
                location.href = base_url + 'auth/login';
            }
            var id_produccion = this.data.data.production.data[index_production].id_production_transaction;
            var params = {
                'token_session': token_session,
                'id_produccion': id_produccion
            };
            const headers = {
                'Content-Type': 'application/json',
                'x-api-key': api_key
            };
            var config = {
                headers: headers,
                params: params
            }
            axios.delete(base_url + 'api/analisis/delete_production', config)
                .then(function (response) {
                    if (response.data.status) {
                        app.get_data();
                    } else {
                        app.msg_edit_production = "Ocurrió un error al intentar actualizar el valor.";
                        console.log(error);
                    }
                })
                .catch(
                    error => {
                        if (error.response.status == 401) {
                            localStorage.removeItem("token_session");
                            localStorage.removeItem("session");
                            location.href = base_url + "auth/login";
                            return false;
                        }
                        app.msg_edit_production = "Ocurrió un error al intentar actualizar el valor.";
                    });
        },
        editar_participation: function (index_participation) {
            this.index_participation_selected = index_participation;
            this.form_edit_participation = true;
        },
        cerrar_editar_participation: function () {
            this.index_participation_selected = null;
            this.form_edit_participation = false;
        },
        set_participation: function () {
            this.msg_edit_participation = null;
            var token_session = localStorage.getItem("token_session");
            if (token_session == null) {
                location.href = base_url + 'auth/login';
            }
            var params = {
                'token_session': token_session,
                'tipo': this.seccion,
                'id_analisis': this.id_analisis
            };
            const headers = {
                'Content-Type': 'application/json',
                'x-api-key': api_key
            };
            axios.post(base_url + 'api/analisis/set_participation', params, { headers: headers })
                .then(function (response) {
                    if (response.data.status) {
                        app.get_data();
                        var nuevo_index = app.data.data.participation.data.length;
                        app.editar_participation(nuevo_index);
                    } else {
                        app.msg_edit_participation = "Ocurrió un error al intentar realizar el registro.";
                        console.log(error);
                    }
                })
                .catch(
                    error => {
                        if (error.response.status == 401) {
                            localStorage.removeItem("token_session");
                            localStorage.removeItem("session");
                            location.href = base_url + "auth/login";
                            return false;
                        }
                        app.msg_edit_participation = "Ocurrió un error al intentar realizar el registro.";
                    });
        },
        update_participation: function (index_participation) {
            this.msg_edit_participation = null;
            var token_session = localStorage.getItem("token_session");
            if (token_session == null) {
                location.href = base_url + 'auth/login';
            }

            var participacion = this.data.data.participation.data[index_participation];

            var params = {
                'token_session': token_session,
                'id_participacion': participacion.id_participation_transaction,
                'descripcion': participacion.description,
                'costo_unit': participacion.unit_cost,
                'p_venta': participacion.p_sale,
                'participacion': participacion.participation
            };

            const headers = {
                'Content-Type': 'application/json',
                'x-api-key': api_key
            };
            axios.put(base_url + 'api/analisis/update_participation', params, { headers: headers })
                .then(function (response) {
                    if (response.data.status) {
                        app.form_edit_participation = false;
                        app.get_data();
                    } else {
                        app.msg_edit_participation = "Ocurrió un error al intentar actualizar el valor.";
                        console.log(error);
                    }
                })
                .catch(
                    error => {
                        if (error.response.status == 401) {
                            localStorage.removeItem("token_session");
                            localStorage.removeItem("session");
                            location.href = base_url + "auth/login";
                            return false;
                        }
                        app.msg_edit_participation = "Ocurrió un error al intentar actualizar el valor.";
                    });
        },
        eliminar_participation: function (index_participation) {
            this.msg_edit_participation = null;
            var token_session = localStorage.getItem("token_session");
            if (token_session == null) {
                location.href = base_url + 'auth/login';
            }
            var id_participacion = this.data.data.participation.data[index_participation].id_participation_transaction;
            var params = {
                'token_session': token_session,
                'id_participacion': id_participacion
            };
            const headers = {
                'Content-Type': 'application/json',
                'x-api-key': api_key
            };
            var config = {
                headers: headers,
                params: params
            }
            axios.delete(base_url + 'api/analisis/delete_participation', config)
                .then(function (response) {
                    if (response.data.status) {
                        app.get_data();
                    } else {
                        app.msg_edit_participation = "Ocurrió un error al intentar actualizar el valor.";
                        console.log(error);
                    }
                })
                .catch(
                    error => {
                        if (error.response.status == 401) {
                            localStorage.removeItem("token_session");
                            localStorage.removeItem("session");
                            location.href = base_url + "auth/login";
                            return false;
                        }
                        app.msg_edit_participation = "Ocurrió un error al intentar actualizar el valor.";
                    });
        }
    },
    watch: {
        $route() {
            this.id_analisis = this.$route.params.id_analysis;
            this.tipo = this.$route.params.type;
            this.seccion = this.$route.params.section;
            this.get_data();
        }
    },
    updated: function () {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip({
                trigger: "hover"
            })
        });
    },
}).$mount('#app');