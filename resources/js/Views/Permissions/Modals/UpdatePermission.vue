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
              Modificar Permiso
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
                >Modificar Permiso</span
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
  name: "PermissionUpdate",
  components: {},

  created() {},
  data() {
    return {
      form: this.getClearFormObject(),
    };
  },
  methods: {
    createPermission: function () {
      var url = "/permissions/"+this.form.id;
      axios
        .put(url, this.form)
        .then((response) => {
          this.errors = [];
          this.getClearFormObject();
          $("#exampleModal2").modal("hide");
          this.$emit("GetCreatedPermission");
        })
        .catch((error) => {});
    },
    UpdateGetPermission(permission) {
      this.form.name = permission.attributes.name;
      this.form.id = permission.id;
    },
    getClearFormObject() {
      return {
        id: null,
        name: null,
      };
    },
  },
};
</script>