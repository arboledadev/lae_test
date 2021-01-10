<template>
  <div class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="javascript:voi(0)"><strong>LAE</strong> Test</a>
      </div>
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg"><strong>Inicia sesión</strong></p>
          <div v-if="msg_auth_error" class="alert alert-danger mt-3 mb-3">
            <i class="fa fa-exclamation-circle"></i> Datos incorrectos
          </div>
          <form v-on:submit.prevent="set_auth">
            <div v-if="invalid.email" class="invalid-feedback">
              <i class="fa fa-exclamation-circle"></i> Por favor digite su
              correo electrónico
            </div>
            <div class="input-group mb-3">
              <input
                v-model="email"
                type="email"
                class="form-control"
                placeholder="Correo electrónico"
              />
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div v-if="invalid.password" class="invalid-feedback">
              <i class="fa fa-exclamation-circle"></i> Por favor digite su
              contraseña
            </div>
            <div class="input-group mb-3">
              <input
                v-model="password"
                type="password"
                class="form-control"
                placeholder="Contraseña"
              />
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">
                  Iniciar
                </button>
              </div>
            </div>
          </form>
          <hr />
          <div class="text-right mt-3 mb-0">
            <a href="javascript:void(0)" class="text-center"
              >Crear una cuenta</a
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  name: "Auth",
  data() {
    return {
      email: null,
      password: null,
      invalid: {
        email: false,
        password: false,
      },
      msg_auth_error: false,
    };
  },
  created: function () {
    this.get_validate_auth();
  },
  methods: {
    get_validate_auth: function () {
      var session = localStorage.getItem("session");
      if (session == null) {
        return false;
      }
      this.$router.push("/");
    },
    set_auth: function () {
      this.invalid.email = false;
      this.invalid.password = false;
      this.msg_auth_error = false;

      if (this.email == null || this.email == "") {
        this.invalid.email = true;
      }

      if (this.password == null || this.password == "") {
        this.invalid.password = true;
      }

      if (this.invalid.email || this.invalid.password) {
        return false;
      }

      const headers = {
        "Content-Type": "application/json",
        "x-api-key": this.$api_key,
      };
      let params = {
        email: this.email,
        password: this.password,
      };
      const vm = this;
      axios
        .post(this.$base_url + "auth/login", params, {
          headers: headers,
        })
        .then((response) => {
          if (!response.data.status) {
            vm.msg_auth_error = true;
            return false;
          }
          vm.msg_auth_error = false;
          var session = {
            token: response.data.data.token_session,
            usuario: response.data.data.usuario,
          };
          localStorage.setItem("session", JSON.stringify(session));
          location.reload();
        })
        .catch((error) => console.log(error))
        .finally();
    },
  },
};
</script>
