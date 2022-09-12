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
              Crear plantilla Partcial
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

            <label for="name" class="form-label">Dia</label>
            <select
              class="form-select"
              aria-label="Default select example"
              v-model="form.day_week_id"
            >
              <option selected value="">Seleccione Dia</option>
              <option v-for="keep in dayWeek" :key="keep.id" :value="keep.id">
                {{ keep.attributes.name }}
              </option>
            </select>

            <label for="name" class="form-label">Hora</label>
            <select
              class="form-select"
              aria-label="Default select example"
              v-model="form.system_time_id"
            >
              <option selected value="">Seleccione Hora</option>
              <option
                v-for="keep in systemTime"
                :key="keep.id"
                :value="keep.id"
              >
                {{ keep.attributes.name }}
              </option>
            </select>

            <label for="name" class="form-label">Turno</label>
            <select
              class="form-select"
              aria-label="Default select example"
              v-model="form.shift_system_id"
            >
              <option selected value="">Seleccione Turno</option>
              <option
                v-for="keep in ShiftSystem"
                :key="keep.id"
                :value="keep.id"
              >
                {{ keep.attributes.name }}
              </option>
            </select>

            <label for="name" class="form-label">Parcial Minimo</label>
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
                >Crear plantilla Partcial</span
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
  name: "PartialCostCreate",
  components: {},

  created() {
    this.getPartial();
    this.getRoomType();
    this.getDayWeek();
    this.getSystemTime();
    this.getShiftSystem();
  },
  data() {
    return {
      form: this.getClearFormObject(),
      patials: [],
      roomType: [],
      dayWeek: [],
      systemTime: [],
      ShiftSystem: [],
    };
  },
  methods: {
    createPermission: function () {
      var url = "/tarifas/partial-templates/create";
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
        room_type_id: "",
        day_week_id: "",
        system_time_id: "",
        shift_system_id: "",
        partial_rates_id: "",
      };
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

    getDayWeek: function () {
      var urlKeeps = "/configuracion/day-week/get";
      axios
        .get(urlKeeps)
        .then((response) => {
          this.dayWeek = response.data.data;
        })
        .catch((err) => {});
    },
    getSystemTime: function () {
      var urlKeeps = "/configuracion/system-time/get";
      axios
        .get(urlKeeps)
        .then((response) => {
          this.systemTime = response.data.data;
        })
        .catch((err) => {});
    },
    getShiftSystem: function () {
      var urlKeeps = "/configuracion/shift-system/get";
      axios
        .get(urlKeeps)
        .then((response) => {
          this.ShiftSystem = response.data.data;
        })
        .catch((err) => {});
    },
  },
};
</script>

