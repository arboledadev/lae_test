const app = new Vue({
    el: '#app',
    data() {
        return {
            base_url: base_url,
            identificacion_cliente: null,
            validate: {
                identificacion_cliente: false,
                nombre_cliente: false,
                apellido_cliente: false
            },
            cliente: [],
            load_buscar_cliente: true,
            nuevo_cliente: {
                nombre: null,
                apellido: null,
                email: null,
                phone: null,
                num_id: null,
            },
            id_cliente: null,
            msg_nuevo_analisis: null
        }
    },
    methods: {
        get_cliente: function () {
            this.cliente = [];
            var token_session = localStorage.getItem("token_session");
            if (token_session == null) {
                location.href = base_url + 'auth/login';
            }
            if (this.identificacion_cliente == null || this.identificacion_cliente == "") {
                this.validate.identificacion_cliente = true;
                return false;
            }
            this.validate.identificacion_cliente = null;
            const headers = {
                'Content-Type': 'application/json',
                'x-api-key': api_key
            };
            var params = {
                'token_session': token_session,
                'identificacion': this.identificacion_cliente
            };
            let config = {
                headers: headers,
                params: params
            };
            axios
                .get(base_url + 'api/clientes/buscar_cliente', config, {
                    headers: headers
                })
                .then(response => {
                    if (response.data.status) {
                        this.load_buscar_cliente = false;
                        if (response.data.results != 0) {
                            this.cliente = response.data.data;
                            this.id_cliente = response.data.data.id_client;
                            return false;
                        }
                        this.nuevo_cliente.num_id = this.identificacion_cliente;
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
                .finally();
        },
        set_cliente: function () {
            var validate = true;
            this.validate.nombre_cliente = false;
            this.validate.apellido_cliente = false;
            if (this.nuevo_cliente.nombre == null) {
                this.validate.nombre_cliente = true;
                validate = false;
            }
            if (this.nuevo_cliente.apellido == null) {
                this.validate.apellido_cliente = true;
                validate = false;
            }
            if (!validate) {
                return false;
            }
            var token_session = localStorage.getItem("token_session");
            if (token_session == null) {
                location.href = base_url + 'auth/login';
            }
            var params = {
                'token_session': token_session,
                'nombre': this.nuevo_cliente.nombre,
                'apellido': this.nuevo_cliente.apellido,
                'email': this.nuevo_cliente.email,
                'phone': this.nuevo_cliente.phone,
                'identificacion': this.nuevo_cliente.num_id
            };
            const headers = {
                'Content-Type': 'application/json',
                'x-api-key': api_key
            };
            axios.post(base_url + 'api/clientes/set_cliente/', params, { headers: headers })
                .then(function (response) {
                    app.id_cliente = response.data.data.id_client;
                    app.set_informe();
                })
                .catch(
                    error => {
                        if (error.response.status == 401) {
                            localStorage.removeItem("token_session");
                            localStorage.removeItem("session");
                            location.href = base_url + "auth/login";
                        }
                    }
                );
        },
        load_form_buscar_cliente: function () {
            this.identificacion_cliente = null;
            this.load_buscar_cliente = true;
        },
        set_informe: function () {
            this.msg_nuevo_analisis = null;

            var token_session = localStorage.getItem("token_session");
            if (token_session == null) {
                location.href = base_url + 'auth/login';
            }
            var params = {
                'token_session': token_session,
                'id_cliente': this.id_cliente
            };
            const headers = {
                'Content-Type': 'application/json',
                'x-api-key': api_key
            };
            axios.post(base_url + 'api/analisis/set_analisis/', params, { headers: headers })
                .then(function (response) {
                    if (response.data.status) {
                        location.href = base_url + "analysis/edit/#" + response.data.data.id_analysis + '/1/1';
                    } else {
                        app.msg_nuevo_analisis = "Ocurrió un error al intentar crear el análisis.";
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
                        app.msg_nuevo_analisis = "Ocurrió un error al intentar crear el análisis.";
                    });
        }
    }
}).$mount('#app');