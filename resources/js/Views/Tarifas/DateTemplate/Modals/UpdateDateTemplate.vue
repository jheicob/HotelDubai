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
                            Modificar Plantilla de Fecha
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
                        <label for="name" class="form-label"
                            >Tipo Habitacion</label
                        >
                        <select
                            class="form-select"
                            aria-label="Default select example"
                            v-model="form.room_type_id"
                        >
                            <option selected value="">
                                Seleccione Tipo Habitacion
                            </option>
                            <option
                                v-for="keep in roomType"
                                :key="keep.id"
                                :value="keep.id"
                            >
                                {{ keep.attributes.name }}
                            </option>
                        </select>

                        <label for="date" class="form-label">Fecha</label>
                        <input
                            type="date"
                            name="date"
                            v-model="form.date"
                            class="form-control"
                        />

                        <label for="number" class="form-label">Tarifa</label>
                        <input
                            type="number"
                            name="rate"
                            v-model="form.rate"
                            class="form-control"
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
                                >Modificar Plantilla de Fecha</span
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
import {
    dateFormat,
    getDateFormat
    } from "./helper";
export default {
    name: "UpdateDateTemplate",
    components: {},

    mounted(){
        this.getRoomType();
    },
    data() {
        return {
            form: {
                id:'',
                room_type_id: "",
                rate: "",
                date: "",
            },
            patials: [],
            roomType: [],
            dayWeek: [],
            systemTime: [],
            ShiftSystem: [],
        };
    },
    methods: {
        createPermission: function () {
            var url = "/tarifas/date-templates/" + this.form.id;
            this.form.date = dateFormat(this.form.date)
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
        getClearFormObject(){
            this.form = {
                id:'',
                room_type_id:'',
                date:'',
                rate:'',
            }
        },
        UpdateGetPermission(permission) {
            this.getRoomType();
            this.form = {
                id: permission.id,
                room_type_id: permission.relationships.roomType.id,
                date: getDateFormat(permission.attributes.date),
                rate: permission.attributes.rate,
            }

        },
        getRoomType: function () {
            var urlKeeps = "/configuracion/room-type/get";
            axios
                .get(urlKeeps)
                .then((response) => {
                    this.roomType = response.data.data;
                })
                .catch((err) => {});
        }
    },
};
</script>
