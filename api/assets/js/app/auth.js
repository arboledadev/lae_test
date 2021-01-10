const app = new Vue({
    el: '#app',
    data() {
        return {
            base_url: base_url,
            loading: true,
            email: null,
            password: null,
            validate: {
                email: false,
                password: false
            },
            msg_auth_status: false,
            msg_auth: null
        }
    },
    created: function () {
        this.get_validate_auth();
    },
    methods: {
        get_validate_auth: function () {
            var token_session = localStorage.getItem("token_session");
            if (token_session == null) {
                return false;
            }
            const headers = {
                'Content-Type': 'application/json',
                'x-api-key': api_key
            };
            let config = {
                headers: headers,
            };
            let params = {
                token_session: token_session
            };
            axios
                .post(base_url + 'api/auth/token_validate', params, {
                    headers: headers
                })
                .then(response => {
                    if (response.data.status) {
                        location.href = base_url;
                        return false;
                    }
                    localStorage.removeItem("token_session");
                    localStorage.removeItem("session");
                })
                .catch(error => console.log(error))
                .finally();
        },
        get_auth: function () {
            this.validate.email = false;
            this.validate.password = false;
            this.msg_auth_status = false;

            if ((this.email == null) || (this.email == "")) {
                this.validate.email = true;
            }

            if ((this.password == null) || (this.password == "")) {
                this.validate.password = true;
            }

            if (this.validate.email || this.validate.password) {
                return false;
            }

            const headers = {
                'Content-Type': 'application/json',
                'x-api-key': api_key
            };
            let params = {
                email: this.email,
                password: this.password
            };
            axios
                .post(base_url + 'api/auth/login', params, {
                    headers: headers
                })
                .then(response => {
                    if (!response.data.status) {
                        this.msg_auth_status = true;
                        return false;
                    }
                    this.msg_auth_status = false;
                    localStorage.setItem("token_session", response.data.data.token_session);
                    localStorage.setItem("session", JSON.stringify(response.data.data));
                    location.href = base_url;
                })
                .catch(error => console.log(error));
        }
    },
    mounted: function () {

    },
    updated: function () {

    },
    watch: {

    }
}).$mount('#app');