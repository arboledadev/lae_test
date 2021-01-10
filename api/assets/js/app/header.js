const header = new Vue({
    el: '#header',
    data() {
        return {
            base_url: base_url,
            user: {
                name: null
            }
        }
    },
    created: function () {
        this.get_validate_auth();
        var session = JSON.parse(localStorage.getItem("session"));
        this.user.name = session.user.name + " " + session.user.lastname;
    },
    methods: {
        get_validate_auth: function () {
            var token_session = localStorage.getItem("token_session");
            if (token_session == null) {
                location.href = base_url + 'auth/login';
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
                        return false;
                    }
                    localStorage.removeItem("token_session");
                    localStorage.removeItem("session");
                    location.href = base_url + 'auth/login';
                })
                .catch(error => console.log(error))
                .finally();
        },
        set_logout: function () {
            localStorage.removeItem("token_session");
            localStorage.removeItem("session");
            location.href = base_url + 'auth/login';
        }
    }
}).$mount('#header');