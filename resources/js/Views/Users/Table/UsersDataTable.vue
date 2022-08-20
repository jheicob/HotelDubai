<template>
  <div class="row justify-content-center">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Usuarios</li>
    </ol>

    <!-- DataTables Example -->
    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Data Usuarios
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
                >Crear Usuario</span
              >
            </a>
          </div>
          <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Accion</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Accion</th>
              </tr>
            </tfoot>
            <tbody>
              <tr v-for="keep in keeps" :key="keep.id">
                <td>{{ keep.id }}</td>
                <td>{{ keep.attributes.name }}</td>
                <td>{{ keep.attributes.email }}</td>
                <td>
                  <span v-for="role in keep.relationships.roles" :key="role.id">
                    {{ role.attributes.name }}
                  </span>
                </td>
                <td>
                  <i
                    v-on:click.prevent="UpdatedUser(keep)"
                    v-if="updated && !keep.attributes.deleted_at"
                    class="ico fas fa-edit fa-lg text-secondary"
                    style="cursor: pointer"
                    title="Borrar"
                  ></i>

                  <i
                    v-on:click.prevent="deletePermission(keep)"
                    v-if="deletet"
                    :class="
                      keep.attributes.deleted_at
                        ? 'ico fas fa-trash-restore-alt fa-lg text-secondary'
                        : 'ico fas fa-trash fa-lg text-secondary'
                    "
                    style="cursor: pointer"
                    title="Borrar"
                  ></i>
                </td>
              </tr>
            </tbody>
          </table>
          <Pagination
            align="center"
            :data="pagination"
            @pagination-change-page="getKeeps"
          />
        </div>
      </div>
    </div>
    <create-user @GetCreatedRol="GetCreatedRol" ref="componentecreate" />
    <update-user @GetCreatedRol="GetCreatedRol" ref="componente" />
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
import CreateUser from "../Modals/CreateUser.vue";
import UpdateUser from "../Modals/UpdateUser.vue";
import Pagination from "laravel-vue-pagination";

export default {
  name: "UsersDataTable",
  components: {
    CreateUser,
    UpdateUser,
    Pagination,
  },
  props: {
    create: {
      type: String,
      default: 0,
    },
    deletet: {
      type: String,
      default: 0,
    },
    updated: {
      type: String,
      default: 0,
    },
  },
  created() {
    this.getKeeps();
  },
  data() {
    return {
      keeps: [],
      pagination: {
        total: 0,
        current_page: 0,
        per_page: 25,
        last_page: 0,
        from: 0,
        to: 0,
      },
    };
  },
  methods: {
    getKeeps: function (page = 1) {
      var urlKeeps = "/users/getPaginate?page=" + page;
      axios
        .get(urlKeeps, {
          pag: this.pagination.per_page,
        })
        .then((response) => {
          this.keeps = response.data.data;
          this.pagination = response.data.meta;

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
      Swal.fire({
        title: "Eliminar",
        text: "estas seguro de esta accion",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "si",
        cancelButtonText: "no",
      }).then((result) => {
        if (result.value) {
          Swal.fire("¡Eliminado!", "Su registro ha sido eliminado.", "success");
          var url = "users/delete/" + keep.id;
          axios.delete(url).then((response) => {
            this.getKeeps();
          });
        }
      });
    },

    CreateRol: function () {
      this.$refs.componentecreate.getKeeps();
      $("#exampleModal").modal("show");
    },

    UpdatedUser(permission) {
      this.$refs.componente.UpdateGetUser(permission);
      $("#exampleModal2").modal("show");
    },

    GetCreatedRol: function () {
      this.getKeeps();
    },
  },
};
</script>

<style>
@import "~sweetalert2/dist/sweetalert2.css";
</style>