<template>
  <div class="home">
    <img alt="Vue logo" src="../assets/logo.png" />
    ¡Bienvenido!
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "Home",
  created: function () {
    this.get_validate_auth();
  },
  methods: {
    get_validate_auth: function () {
      var session = localStorage.getItem("session");

      if (session == null) {
        this.$router.push("/auth");
        return false;
      }

      session = JSON.parse(session);

      var token_session = session.token;

      const headers = {
        "Content-Type": "application/json",
        "x-api-key": this.$api_key,
      };
      let params = {
        token_session: token_session,
      };
      const vm = this;
      axios
        .post(this.$base_url + "auth/token_validate", params, {
          headers: headers,
        })
        .then((response) => {
          if (response.data.status) {
            var session = JSON.parse(localStorage.getItem("session"));
            vm.usuario.nombres = session.usuario.nombres;
            vm.usuario.apellidos = session.usuario.apellidos;
            return false;
          }
          localStorage.removeItem("session");
          this.$router.push("/auth");
        })
        .catch((error) => console.log(error))
        .finally();
    },
  },
};
</script>
