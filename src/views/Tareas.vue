<template>
  <div>
    <div class="col-sm-12">
      <h2 class="m-0">Tareas</h2>
    </div>
    <div class="col-sm-12">
      <div class="card mt-4">
        <div class="card-body">
          <div v-if="msg_tarea_error != null" class="alert alert-danger">
            <i class="fa fa-exclamation-circle"></i> {{ msg_tarea_error }}
          </div>
          <div class="mt-3 mb-3">
            <form
              v-on:submit.prevent="set_tarea"
              class="row row-cols-lg-auto g-3 align-items-center"
            >
              <div class="col-10">
                <input type="text" class="form-control" v-model="nueva_tarea" />
              </div>
              <div class="col-2">
                <button type="submit" class="btn btn-primary">
                  <i class="fa fa-plus-circle"></i> Agregar tarea
                </button>
              </div>
            </form>
          </div>
          <div v-if="tareas.length != 0">
            <ul class="todo-list" data-widget="todo-list">
              <li
                v-for="(tarea, index_tarea) in tareas"
                v-bind:key="index_tarea"
              >
                <div v-if="form_edit && index_selected == index_tarea">
                  <div class="row">
                    <div class="col-lg-10">
                      <input
                        v-on:keyup.enter="update_tarea"
                        type="text"
                        class="form-control"
                        v-model="tarea.tarea"
                      />
                    </div>
                    <div class="col-lg-2">
                      <button
                        v-on:click.prevent="update_tarea"
                        class="btn btn-success btn-sm mr-2"
                      >
                        <i class="fa fa-save"></i>
                      </button>
                      <button
                        v-on:click.prevent="unload_form_edit"
                        class="btn btn-outline-secondary btn-sm"
                      >
                        <i class="fa fa-times"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div v-else>
                  <div class="icheck-primary d-inline ml-2">
                    <input
                      type="checkbox"
                      value=""
                      v-bind:name="'todo_' + index_tarea"
                      v-bind:id="'todoCheck' + index_tarea"
                      v-model="tarea.estado"
                      v-on:click="update_estado_tarea(index_tarea)"
                    />
                    <label v-bind:for="'todoCheck' + index_tarea"></label>
                  </div>
                  <span class="text">{{ tarea.tarea }}</span>
                  <small v-if="tarea.estado" class="badge badge-info">
                    Completa
                  </small>
                  <div class="tools">
                    <a
                      v-on:click.prevent="load_form_edit(index_tarea)"
                      href="javascript:void(0)"
                      class="text-info mr-2"
                      ><i class="fas fa-edit"></i
                    ></a>
                    <a
                      v-on:click.prevent="delete_tarea(index_tarea)"
                      href="javascript:void(0)"
                      class="text-danger"
                      ><i class="fas fa-trash"></i
                    ></a>
                  </div>
                </div>
              </li>
            </ul>
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
  name: "Tareas",
  props: {
    num_tareas: null,
  },
  data() {
    return {
      tareas: [],
      nueva_tarea: null,
      msg_tarea_error: null,
      form_edit: false,
      index_selected: null,
    };
  },
  created: function () {
    this.get_tareas();
  },
  methods: {
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
            if (response.data.results != 0) {
              this.tareas = response.data.data;
            }
            this.$emit("get_num_tareas", response.data.results);
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
    set_tarea: function () {
      var session = localStorage.getItem("session");
      if (session == null) {
        this.$router.push("/auth");
      }
      session = JSON.parse(session);

      var token_session = session.token;

      this.msg_tarea_error = null;

      if (this.nueva_tarea == null || this.email == "") {
        this.msg_tarea_error = "Digite la descripción de la tarea.";
      }

      const headers = {
        "Content-Type": "application/json",
        "x-api-key": this.$api_key,
        token: token_session,
      };
      let params = {
        tarea: this.nueva_tarea,
      };
      const vm = this;
      axios
        .post(this.$base_url + "tareas/set", params, {
          headers: headers,
        })
        .then((response) => {
          if (!response.data.status) {
            vm.msg_tarea_error = response.data.message;
            return false;
          }
          vm.nueva_tarea = null;
          vm.get_tareas();
        })
        .catch((error) => (vm.msg_tarea_error = error))
        .finally();
    },
    load_form_edit: function (index) {
      this.form_edit = true;
      this.index_selected = index;
    },
    unload_form_edit: function () {
      this.form_edit = false;
      this.index_selected = null;
    },
    update_tarea: function () {
      var session = localStorage.getItem("session");
      if (session == null) {
        this.$router.push("/auth");
      }
      session = JSON.parse(session);

      var token_session = session.token;

      this.msg_tarea_error = null;

      if (
        this.tareas[this.index_selected].tarea == null ||
        this.tareas[this.index_selected].tarea == ""
      ) {
        this.msg_tarea_error = "Digite la descripción de la tarea.";
        return false;
      }

      const headers = {
        "Content-Type": "application/json",
        "x-api-key": this.$api_key,
        token: token_session,
      };
      let params = {
        id_tarea: this.tareas[this.index_selected].id_tarea,
        tarea: this.tareas[this.index_selected].tarea,
      };
      const vm = this;
      axios
        .put(this.$base_url + "tareas/update", params, {
          headers: headers,
        })
        .then((response) => {
          if (!response.data.status) {
            vm.msg_tarea_error = response.data.message;
            return false;
          }
          vm.unload_form_edit();
        })
        .catch((error) => (vm.msg_tarea_error = error))
        .finally();
    },
    update_estado_tarea: function (index) {
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
      let params = {
        id_tarea: this.tareas[index].id_tarea,
        estado: this.tareas[index].estado,
      };
      const vm = this;
      axios
        .put(this.$base_url + "tareas/update_estado", params, {
          headers: headers,
        })
        .then((response) => {
          if (!response.data.status) {
            vm.msg_tarea_error = response.data.message;
            return false;
          }
        })
        .catch((error) => (vm.msg_tarea_error = error))
        .finally();
    },
    delete_tarea: function (index) {
      var session = localStorage.getItem("session");
      if (session == null) {
        this.$router.push("/auth");
      }
      session = JSON.parse(session);

      var token_session = session.token;

      this.msg_tarea_error = null;

      const headers = {
        "Content-Type": "application/json",
        "x-api-key": this.$api_key,
        token: token_session,
      };
      var id_tarea = this.tareas[index].id_tarea;
      var config = {
        headers: headers,
      };
      const vm = this;
      axios
        .delete(this.$base_url + "tareas/delete/" + id_tarea, config)
        .then((response) => {
          if (!response.data.status) {
            vm.msg_tarea_error = response.data.message;
            return false;
          }
          vm.get_tareas();
        })
        .catch((error) => (vm.msg_tarea_error = error))
        .finally();
    },
  },
};
</script>