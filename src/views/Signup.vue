<template>
  <div class="hold-transition register-page">
    <div class="register-box">
      <div class="register-logo">
        <a href="javascript:voi(0)"><strong>LAE</strong> Test</a>
      </div>

      <div class="card">
        <div class="card-body register-card-body">
          <p class="login-box-msg"><strong>Crear una cuenta</strong></p>
          <div
            v-if="msg_auth_error != null"
            class="alert alert-danger mt-3 mb-3"
          >
            <i class="fa fa-exclamation-circle"></i> {{ msg_auth_error }}
          </div>
          <form v-on:submit.prevent="set_singnup">
            <div
              v-if="invalid && msg_nombre_invalid != null"
              class="invalid-feedback"
            >
              <i class="fa fa-exclamation-circle"></i> {{ msg_nombre_invalid }}
            </div>
            <div class="input-group mb-3">
              <input
                type="text"
                class="form-control"
                placeholder="Nombres"
                v-model="nombres"
              />
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div
              v-if="invalid && msg_apellido_invalid != null"
              class="invalid-feedback"
            >
              <i class="fa fa-exclamation-circle"></i>
              {{ msg_apellido_invalid }}
            </div>
            <div class="input-group mb-3">
              <input
                type="text"
                class="form-control"
                placeholder="Apellidos"
                v-model="apellidos"
              />
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div
              v-if="invalid && msg_email_invalid != null"
              class="invalid-feedback"
            >
              <i class="fa fa-exclamation-circle"></i> {{ msg_email_invalid }}
            </div>
            <div class="input-group mb-3">
              <input
                type="text"
                class="form-control"
                placeholder="Correo electrónico"
                v-model="email"
              />
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div
              v-if="invalid && msg_password_invalid != null"
              class="invalid-feedback"
            >
              <i class="fa fa-exclamation-circle"></i>
              {{ msg_password_invalid }}
            </div>
            <div class="input-group mb-3">
              <input
                type="password"
                class="form-control"
                placeholder="Contraseña"
                v-model="password"
              />
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div
              v-if="invalid && msg_password_confirm_invalid != null"
              class="invalid-feedback"
            >
              <i class="fa fa-exclamation-circle"></i>
              {{ msg_password_confirm_invalid }}
            </div>
            <div class="input-group mb-3">
              <input
                type="password"
                class="form-control"
                placeholder="Confirme la contraseña"
                v-model="password_confirm"
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
                  Registrarme
                </button>
              </div>
            </div>
          </form>
          <div class="mt-3 text-right">
            <a href="#/auth" class="text-center"
              >¿Tienes una cuenta? Inicia sesión</a
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
  name: "Signup",
  data() {
    return {
      nombres: null,
      apellidos: null,
      email: null,
      password: null,
      password_confirm: null,
      invalid: false,
      msg_auth_error: null,
      msg_nombre_invalid: null,
      msg_apellido_invalid: null,
      msg_email_invalid: null,
      msg_password_invalid: null,
      msg_password_confirm_invalid: null,
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
    set_singnup: function () {
      this.invalid = false;
      this.msg_auth_error = null;
      this.msg_nombre_invalid = null;
      this.msg_apellido_invalid = null;
      this.msg_email_invalid = null;
      this.msg_password_invalid = null;
      this.msg_password_confirm_invalid = null;

      if (this.nombres == null || this.nombres == "") {
        this.invalid = true;
        this.msg_nombre_invalid = "Digite su nombre";
      }

      if (this.apellidos == null || this.apellidos == "") {
        this.invalid = true;
        this.msg_apellido_invalid = "Digite su apellido";
      }

      if (this.email == null || this.email == "") {
        this.invalid = true;
        this.msg_email_invalid = "Digite tu correo electrónico";
      } else {
        var email_regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

        if (!email_regex.test(this.email)) {
          this.invalid = true;
          this.msg_email_invalid = "Digite un correo electrónico válido";
        }
      }

      if (this.password == null || this.password == "") {
        this.invalid = true;
        this.msg_password_invalid = "Digite una contraseña";
      } else {
        if (this.password.length < 7) {
          this.invalid = true;
          this.msg_password_invalid =
            "La contraseña debe tener como mínimo 7 caracteres.";
        } else {
          var pass_regex = /^(?=(?:.*\d){1})(?=(?:.*[A-Z]){1})(?=(?:.*[a-z]){1})\S{7,}$/;

          if (!pass_regex.test(this.password)) {
            this.invalid = true;
            this.msg_password_invalid =
              "La contraseña debe tener al menos un número y una letra mayúscula. ";
          }
        }
      }

      if (this.password_confirm == null || this.password_confirm == "") {
        this.invalid = true;
        this.msg_password_confirm_invalid = "Confirme la contraseña.";
      } else {
        if (this.password_confirm != this.password) {
          this.invalid = true;
          this.msg_password_confirm_invalid =
            "La contraseña no coincide con la confirmación.";
        }
      }

      if (this.invalid) {
        return false;
      }

      const headers = {
        "Content-Type": "application/json",
        "x-api-key": this.$api_key,
      };
      let params = {
        nombres: this.nombres,
        apellidos: this.apellidos,
        email: this.email,
        password: this.password,
      };
      const vm = this;
      axios
        .post(this.$base_url + "auth/signup", params, {
          headers: headers,
        })
        .then((response) => {
          if (!response.data.status) {
            vm.msg_auth_error = response.data.message;
            return false;
          }
          vm.msg_auth_error = null;
          var session = {
            token: response.data.data.token_session,
            usuario: response.data.data.usuario,
          };
          localStorage.setItem("session", JSON.stringify(session));
          location.reload();
        })
        .catch((error) => (vm.msg_auth_error = error))
        .finally();
    },
  },
};
</script>
