<template>
  <form>
    <!-- Modal -->
    <div
      class="modal fade"
      id="exampleModal2"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header py-2">
            <h5
              class="modal-title title-page text-secondary"
              id="exampleModalLabel"
            >
              Modificar Rol
            </h5>
            <a
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </a>
          </div>
          <div class="modal-body">
            <label for="name" class="form-label">Nombre</label>

            <input
              type="name"
              id="name"
              class="form-control form-control-user mb-3"
              autofocus
              name="name"
              v-model="form.name"
            />

            <label for="name" class="form-label">Email</label>
            <input
              type="text"
              id="email"
              class="form-control form-control-user mb-3"
              autofocus
              name="email"
              v-model="form.email"
            />

            <label for="name" class="form-label">Contraseña</label>
            <input
              type="password"
              id="password"
              class="form-control form-control-user mb-3"
              autofocus
              name="password"
              v-model="form.password"
            />

            <label for="checkedPermissions" class="form-label">Roles</label>
            <multiselect
              v-model="form.role_id"
              id="checkedPermissions"
              :options="roles"
              :multiple="true"
              label="name"
              track-by="id"
            >
            </multiselect>
          </div>
          <div class="modal-footer">
            <a
              class="btn btn-danger text-white btn-icon-split mb-4"
              data-dismiss="modal"
            >
              <span class="text font-montserrat font-weight-bold"
                >Cancelar</span
              >
            </a>
            <a
              v-on:click.prevent="createPermission()"
              class="btn btn-primary text-white btn-icon-split mb-4"
            >
              <span class="text font-montserrat font-weight-bold"
                >Modificar Rol</span
              >
            </a>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import axios from "axios";
import toastr from "toastr";
import Multiselect from "vue-multiselect";

export default {
  name: "RolesUpdate",
  components: {
    Multiselect,
  },

  created() {},
  data() {
    return {
      form: this.getClearFormObject(),
      roles: [],
    };
  },
  methods: {
    createPermission: function () {
      var url = "/users/" + this.form.id;
      this.form.role_id = this.form.role_id.map(function (elt) {
        return { role_id: elt.id };
      });
      axios
        .put(url, this.form)
        .then((response) => {
          this.errors = [];
          this.getClearFormObject();
          toastr.success("Usuaio Modificado");
          $("#exampleModal2").modal("hide");
          this.$emit("GetCreatedRol");
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
    getKeeps: function () {
      var urlKeeps = "/roles/get";
      axios
        .get(urlKeeps)
        .then((response) => {
          this.roles = response.data.data.map(function (elt) {
            return { name: elt.attributes.name, id: elt.id };
          });
        })
        .catch((err) => {});
    },

    UpdateGetUser(user) {
      this.form.name = user.attributes.name;
      this.form.email = user.attributes.email;
      this.form.id = user.id;
      this.form.role_id = user.relationships.roles.map(function (elt) {
        return { name: elt.attributes.name, id: elt.id };
      });
      this.getKeeps();
    },
    getClearFormObject() {
      return {
        name: null,
        email: null,
        password: null,
        role_id: [],
      };
    },
  },
};
</script>

<style>
@import "~toastr/build/toastr.css";
@import "~vue-multiselect/dist/vue-multiselect.min.css";
</style>