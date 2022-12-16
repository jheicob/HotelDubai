<template>
    <div class="row justify-content-center">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Plantilla de Días</li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-table"></i>
                Data Plantilla Día
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="row">
                        <div class="col"></div>
                        <div class="col">
                            <UpdateMasive :items="keeps" @GetCreatedPermission="getKeeps"></UpdateMasive>
                        </div>
                        <div class="col text-right">
                            <a data-toggle="modal" v-on:click.prevent="CreatePermission()" v-if="create"
                                class="btn btn-primary text-white btn-icon-split mb-4">
                                <i class="fas fa-check"></i>
                                <span class="text font-montserrat font-weight-bold">Crear Plantilla Día</span>
                            </a>
                        </div>
                    </div>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tipo Habitacion</th>
                                <th>Día</th>
                                <th>Hora Inicio</th>
                                <th>Hora Fin</th>
                                <th>Tarifa</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Tipo Habitacion</th>
                                <th>Día</th>
                                <th>Hora Inicio</th>
                                <th>Hora Fin</th>
                                <th>Tarifa</th>
                                <th>Accion</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr v-for="keep in keeps" :key="keep.id">
                                <td>{{ keep.id }}</td>
                                <td>
                                    {{ keep.relationships.roomType.attributes.name }}
                                </td>
                                <td>
                                    {{ keep.relationships.dayWeek.attributes.name }}
                                </td>
                                <td>
                                    {{ keep.attributes.hour_start }}
                                </td>
                                <td>
                                    {{ keep.attributes.hour_end }}
                                </td>
                                <td>
                                    {{ keep.attributes.rate }}
                                </td>
                                <td>
                                    <i v-on:click.prevent="UpdatedPermission(keep)" v-if="updated"
                                        class="ico fas fa-edit fa-lg text-secondary" style="cursor: pointer"
                                        title="Borrar"></i>

                                    <i v-on:click.prevent="deletePermission(keep)" v-if="deletet" :class="
                                        keep.attributes.deleted_at
                                            ? 'ico fas fa-trash-restore-alt fa-lg text-secondary'
                                            : 'ico fas fa-trash fa-lg text-secondary'
                                    " style="cursor: pointer" title="Borrar"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <create-permission @GetCreatedPermission="GetCreatedPermission" />
        <update-permission @GetCreatedPermission="GetCreatedPermission" ref="componente" />
    </div>
</template>

<script>
import axios from "axios";
import CreatePermission from "../Modals/CreateDayTemplate.vue";
import UpdatePermission from "../Modals/UpdateDayTemplate.vue";
import UpdateMasive from "../Modals/UpdateMasive.vue";

export default {
    name: "DayTemplateDataTable",
    components: {
        CreatePermission,
        UpdatePermission,
        UpdateMasive
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
            var urlKeeps = "/tarifas/day-templates/get";
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
                .catch((err) => { });
        },
        deletePermission: function (keep) {
            var url = "/tarifas/day-templates/delete/" + keep.id;
            axios.delete(url).then((response) => {
                this.getKeeps();
            });
        },

        CreatePermission: function () {
            $("#exampleModal").modal("show");
        },

        UpdatedPermission(permission) {
            this.$refs.componente.UpdateGetPermission(permission);
            $("#exampleModal2").modal("show");
        },

        GetCreatedPermission: function () {
            this.getKeeps();
        },
    },
};
</script>
