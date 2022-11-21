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
              Modificar Tipo Inmueble
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
            <label for="name" class="form-label">Tipo Habitacion</label>

            <select
              class="form-select"
              aria-label="Default select example"
              v-model="form.room_type_id"
            >
              <option selected value="">Seleccione Tipo Habitacion</option>
              <option v-for="keep in roomType" :key="keep.id" :value="keep.id">
                {{ keep.attributes.name }}
              </option>
            </select>

            <label for="name" class="form-label">Parcial</label>

            <select
              class="form-select"
              aria-label="Default select example"
              v-model="form.partial_rates_id"
            >
              <option selected value="">Seleccione Parcial</option>
              <option v-for="keep in patials" :key="keep.id" :value="keep.id">
                {{ keep.attributes.name }}
              </option>
            </select>

            <label for="name" class="form-label">Tarifa</label>

            <input
              type="number"
              id="name"
              class="form-control form-control-user mb-3"
              autofocus
              name="name"
              v-model="form.rate"
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
                >Modificar Tipo Inmueble</span
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
  name: "ThemeTypeUpdate",
  components: {},

  created() {},
  data() {
    return {
      form: this.getClearFormObject(),
      patials: [],
      roomType: [],
    };
  },
  methods: {
    createPermission: function () {
      var url = "/tarifas/partial-cost/" + this.form.id;
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
      this.form.rate = permission.attributes.rate;
      this.form.partial_rates_id = permission.relationships.partialRate.id;
      this.form.room_type_id = permission.relationships.roomType.id;
      this.form.id = permission.id;
      this.getPartial();
      this.getRoomType();
    },
    getPartial: function () {
      var urlKeeps = "/configuracion/partial-rates/get";
      axios
        .get(urlKeeps)
        .then((response) => {
          this.patials = response.data.data;
        })
        .catch((err) => {});
    },

    getRoomType: function () {
      var urlKeeps = "/configuracion/room-type/get";
      axios
        .get(urlKeeps)
        .then((response) => {
          this.roomType = response.data.data;
        })
        .catch((err) => {});
    },
    getClearFormObject() {
      return {
        room_type_id: "",
        partial_rates_id: "",
        rate: null,
      };
    },
  },
};
</script>
