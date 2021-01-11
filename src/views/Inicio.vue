<template>
  <div class="row mb-2">
    <div class="col-sm-12">
      <h2 class="m-0">Inicio</h2>
    </div>
    <div class="col-sm-12 text-center p-4">
      <h3>
        Bienvenido <strong>{{ usuario.nombres }}</strong>
      </h3>
      <img src="assets/dist/img/home.jpg" />
    </div>
  </div>
</template>
<script>
export default {
  name: "Usuarios",
  props: {
    usuario: Object,
  },
};
</script>