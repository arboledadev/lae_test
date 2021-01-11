<template>
  <div class="row mb-2">
    <div class="col-sm-12">
      <h2 class="m-0">Usuarios</h2>
    </div>
    <div class="col-sm-12">
      <div class="card mt-4">
        <div class="card-body">
          <div v-if="usuarios.length != 0">
            <table class="table table-hover table-condensed table-bordered">
              <thead>
                <tr>
                  <th>Nombre completo</th>
                  <th>Teléfono</th>
                  <th>Email</th>
                  <th>Estado</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(usuario, index_usuario) in usuarios"
                  v-bind:key="index_usuario"
                >
                  <td>{{ usuario.nombres }} {{ usuario.apellidos }}</td>
                  <td>{{ usuario.telefono }}</td>
                  <td>{{ usuario.email }}</td>
                  <td>
                    <span v-if="usuario.estado == 1" class="badge badge-success"
                      >Activo</span
                    >
                    <span v-if="usuario.estado == 0" class="badge badge-danger"
                      >Inactivo</span
                    >
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div v-else>
            <span class="text-info"> No se encontraron usuarios.</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  name: "Usuarios",
  data() {
    return {
      usuarios: [],
    };
  },
  created: function () {
    this.get_usuarios();
  },
  methods: {
    get_usuarios: function () {
      var session = localStorage.getItem("session");
      if (session == null) {
        this.$router.push("/auth");
      }
      session = JSON.parse(session);
      var token_session = session.token;
      const headers = {
        "Content-Type": "application/json",
        "x-api-key": this.$api_key,
        token: token_session,
      };
      let config = {
        headers: headers,
      };
      axios
        .get(this.$base_url + "usuarios/get/", config, {
          headers: headers,
        })
        .then((response) => {
          if (response.data.status) {
            if (response.data.results != 0) {
              var usuarios = response.data.data;
              this.usuarios = this.sort_json(usuarios, "nombres");
            }
          }
        })
        .catch((error) => {
          if (error.response.status == 401) {
            localStorage.removeItem("session");
            this.$router.push("/auth");
          }
        })
        .finally();
    },
    sort_json: function (data, key) {
      return data.sort(function (a, b) {
        var x = a[key],
          y = b[key];

        return x < y ? -1 : x > y ? 1 : 0;
      });
    },
  },
};
</script>