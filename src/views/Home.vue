<template>
  <div class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"
              ><i class="fas fa-bars"></i
            ></a>
          </li>
        </ul>
        <form class="form-inline ml-3">
          <div class="input-group input-group-sm">
            <input
              class="form-control form-control-navbar"
              type="search"
              placeholder="Buscar"
              aria-label="Search"
            />
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="far fa-bell"></i>
              <span class="badge badge-warning navbar-badge">{{
                num_tareas
              }}</span>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link user-panel" data-toggle="dropdown" href="#">
              {{ usuario.nombres }} {{ usuario.apellidos }}
              <img
                src="assets/dist/img/avatar.png"
                class="img-circle img-responsive"
                alt="User Image"
              />
            </a>
            <div class="dropdown-menu dropdown-menu-lg p-2 dropdown-menu-right">
              <a href="javascript:void(0)">
                <i class="fas fa-sign-out-alt"></i>
                Cerrar sesión
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#/" class="brand-link">
          LAE
          <span class="brand-text font-weight-light"
            ><small>Educación Internacional</small></span
          >
        </a>
        <div class="sidebar">
          <nav class="mt-2">
            <ul
              class="nav nav-pills nav-sidebar flex-column"
              data-widget="treeview"
              role="menu"
              data-accordion="false"
            >
              <li class="nav-item">
                <a href="#/inicio" class="nav-link">
                  <i class="nav-icon fas fa-th"></i>
                  <p>Inicio</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#/usuarios" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>Usuarios</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#/tareas" class="nav-link">
                  <i class="nav-icon fas fa-tasks"></i>
                  <p>Tareas</p>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </aside>
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid"></div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <RouterView :usuario="usuario" @get_num_tareas="get_num_tareas" />
          </div>
        </section>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "Home",
  data() {
    return {
      usuario: {
        nombres: null,
        apellidos: null,
      },
      num_tareas: null,
    };
  },
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
            vm.get_tareas();
            return false;
          }
          localStorage.removeItem("session");
          vm.$router.push("/auth");
        })
        .catch((error) => console.log(error))
        .finally();
    },
    get_tareas: function () {
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
        .get(this.$base_url + "tareas/get", config, {
          headers: headers,
        })
        .then((response) => {
          if (response.data.status) {
            this.num_tareas = response.data.results;
          }
        })
        .catch()
        .finally();
    },
    get_num_tareas: function (num_tareas) {
      this.num_tareas = num_tareas;
    },
  },
};
</script>
