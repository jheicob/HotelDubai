<template>
  <form>
    <!-- Modal -->
    <div
      class="modal fade"
      id="exampleModal"
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
              Crear Tipo Inmueble
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

            <label for="name" class="form-label">Descripcion</label>

            <input
              type="name"
              id="name"
              class="form-control form-control-user mb-3"
              autofocus
              name="name"
              v-model="form.description"
            />
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
                >Crear Tipo Inmueble</span
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
export default {
  name: "ThemeTypeCreate",
  components: {},

  created() {},
  data() {
    return {
      form: this.getClearFormObject(),
    };
  },
  methods: {
    createPermission: function () {
      var url = "/configuracion/estate-type/create";
      axios
        .post(url, this.form)
        .then((response) => {
          this.errors = [];
          this.getClearFormObject();
          $("#exampleModal").modal("hide");
          this.$emit("GetCreatedPermission");
        })
        .catch((error) => {});
    },
    getClearFormObject() {
      return {
        name: null,
        description: null,
      };
    },
  },
};
</script>