<template>
  <div class="row justify-content-center">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Contraseña</li>
    </ol>

    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Datos De Contraseña
      </div>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-md-12">
            <form class="row g-3">
              <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Contraseña Actual</label>
                <input v-model="form.current_password" type="password" class="form-control" />
              </div>
              <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Nueva Contraseña</label>
                <input v-model="form.password" type="password" class="form-control" />
              </div>
              <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Confirmar Contraseña</label>
                <input v-model="form.password_confirmation" type="password" class="form-control" />
              </div>

              <div class="col-12 text-center">
                <button
                  v-on:click.prevent="updateProfile()"
                  type="submit"
                  class="btn btn-primary"
                >
                  Guardar
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import toastr from "toastr";

export default {
  name: "Profile",
  components: {},
  created() {
  },
  data() {
    return {
      form: {
        current_password: "",
        password: "",
        password_confirmation: "",
      },
    };
  },
  methods: {

    updateProfile: function () {
      var url = "/profile/password/update";
      axios
        .put(url, this.form)
        .then((response) => {
          this.errors = [];
          toastr.success("Usuario actualizado");
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          }
          for (error in this.errors) {
            toastr.error(this.errors[error]);
          }
        });
    },
  },
};
</script>
<style>
@import "~toastr/build/toastr.css";
</style>
