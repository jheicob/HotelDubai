<template>
  <div class="row justify-content-center">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Roles</li>
    </ol>

    <!-- DataTables Example -->
    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Data Roles
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <div class="col text-right">
            <a
              data-toggle="modal"
              v-on:click.prevent="CreateRol()"
               v-if="create"
              class="btn btn-primary text-white btn-icon-split mb-4"
            >
              <i class="fas fa-check"></i>
              <span class="text font-montserrat font-weight-bold"
                >Crear Rol</span
              >
            </a>
          </div>
          <table
            class="table table-bordered"
            id="dataTable"
            width="100%"
            cellspacing="0"
          >
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Accion</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Accion</th>
              </tr>
            </tfoot>
            <tbody>
              <tr v-for="keep in keeps" :key="keep.id">
                <td>{{ keep.id }}</td>
                <td>{{ keep.attributes.name }}</td>
                <td>
                  <i
                    v-on:click.prevent="UpdatedPermission(keep)"
                     v-if="updated"
                    class="ico fas fa-edit fa-lg text-secondary"
                    style="cursor: pointer"
                    title="editar"
                  ></i>

                  <i
                    v-on:click.prevent="deletePermission(keep)"
                    v-if="deletet"
                    class="ico fas fa-trash fa-lg text-secondary"
                    style="cursor: pointer"
                    title="Borrar"
                  ></i>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <create-rol @GetCreatedRol="GetCreatedRol" />
    <update-rol
      @GetCreatedRol="GetCreatedRol"
      ref="componente"
    />
  </div>
</template>

<script>
import axios from "axios";
import CreateRol from "../Modals/CreateRol.vue";
import UpdateRol from "../Modals/UpdateRol.vue";

export default {
  name: "RolesDataTable",
  components: {
    CreateRol,
    UpdateRol,
  },
  props: {
    create: {
      type: Number,
      default: 0,
    },
    deletet: {
      type: Number,
      default: 0,
    },
    updated: {
      type: Number,
      default: 0,
    },
  },
  created() {
    this.getKeeps();
  },
  data() {
    return {
      keeps: [],
    };
  },
  methods: {
    getKeeps: function () {
      var urlKeeps = "/roles/get";
      axios
        .get(urlKeeps)
        .then((response) => {
          this.keeps = response.data.data;
          $("#dataTable").DataTable().destroy();
          this.$nextTick(function () {
            $("#dataTable").DataTable({
              // DataTable options here...
            });
          });
        })
        .catch((err) => {});
    },
    deletePermission: function (keep) {
      var url = "roles/delete/" + keep.id;
      axios.delete(url).then((response) => {
        this.getKeeps();
      });
    },

    CreateRol: function () {
      $("#exampleModal").modal("show");
    },

    UpdatedPermission(permission) {
      this.$refs.componente.UpdateGetRol(permission);
      $("#exampleModal2").modal("show");
    },

    GetCreatedRol: function () {
      this.getKeeps();
    },
  },
};
</script>