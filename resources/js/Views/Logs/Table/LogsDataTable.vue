<template>
  <div class="row justify-content-center">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Logs</li>
    </ol>

    <!-- DataTables Example -->
    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Data Logs
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <div class="col text-right">
            <a
              data-toggle="modal"
              v-on:click.prevent="CreateTag()"
              v-if="create"
              class="btn btn-primary text-white btn-icon-split mb-4"
            >
              <i class="fas fa-check"></i>
              <span class="text font-montserrat font-weight-bold"
                >Crear Logs</span
              >
            </a>
          </div>
          <table
            class="table table-bordered"
            width="100%"
            cellspacing="0"
          >
            <thead>
              <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Evento</th>
                <th>Modelo</th>
                <th>ID Modelo</th>
                <th>Valor</th>
                <th>Nuevo Valor</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Evento</th>
                <th>Modelo</th>
                <th>ID Modelo</th>
                <th>Valor</th>
                <th>Nuevo Valor</th>
              </tr>
            </tfoot>
            <tbody>
              <tr v-for="keep in keeps" :key="keep.id">
                <td>{{ keep.id }}</td>
                <td>{{ keep.relationships.user ? keep.relationships.user.attributes.email: '' }}</td>
                <td>{{ keep.attributes.event }}</td>
                <td>{{ keep.attributes.auditable_type }}</td>
                <td>{{ keep.attributes.auditable_id }}</td>
                <td>{{ keep.attributes.old_values }}</td>
                <td>{{ keep.attributes.new_values }}</td>
              </tr>
           </tbody>
          </table>
           <Pagination  align="center" :data="pagination" @pagination-change-page="getKeeps" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Pagination from "laravel-vue-pagination";

export default {
  name: "DepartmentsDataTable",
  components: {
    Pagination,
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
      var urlKeeps = "/logs/getPaginate?page="+ page;
      axios
        .get(urlKeeps)
        .then((response) => {
          this.keeps = response.data.data;
          this.pagination.total = response.data.meta.total;
          this.pagination.current_page = response.data.meta.current_page;
          this.pagination.per_page = response.data.meta.per_page;
          this.pagination.last_page = response.data.meta.last_page;
          this.pagination.from = response.data.meta.from;
          this.pagination.to = response.data.meta.to;
        })
        .catch((err) => {});
    },
  },
};
</script>
