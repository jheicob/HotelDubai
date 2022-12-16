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
                            Crear plantilla de Fecha
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
                        <multiselect
							v-model="form.room_type_id"
							id="checkedPermissions"
							:options="setRoomTypes"
							:multiple="true"
							label="name"
							track-by="id"
						>
						</multiselect>

                        <label for="date" class="form-label">Fecha</label>
                        <input
                            type="date"
                            name="date"
                            v-model="form.date"
                            class="form-control"
                        />

                        <label for="name" class="form-label">Tarifa</label>
                        <input
                            type="number"
                            name="rate"
                            v-model="form.rate"
                            class="form-control"
                        />

                        <label for="name" class="form-label"
                            >Parciales Mínimos</label
                        >
                        <select
                            class="form-select"
                            aria-label="Default select example"
                            v-model="form.partial_rate_id"
                        >
                            <option selected value="">
                                Seleccione Parcial
                            </option>
                            <option
                                v-for="keep in partialRates"
                                :key="keep.id"
                                :value="keep.id"
                            >
                                {{ keep.attributes.name }}
                            </option>
                        </select>
                        <div class="row">
                            <div class="col">
                                <label for="rate" class="form-label">Hora de Inicio</label>
                                <input
                                    class="form-control"
                                    name="rate"
                                    type="time"
                                    v-model="form.hour_start"
                                />
                            </div>
                            <div class="col">
                                <label for="rate" class="form-label">Hora de Fin</label>
                                <input
                                    class="form-control"
                                    name="rate"
                                    type="time"
                                    v-model="form.hour_end"
                                />
                            </div>
                        </div>
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
                                >Crear plantilla de Fecha</span
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
	import Multiselect from "vue-multiselect";
import { dateFormat } from "./helper";
import dayjs from 'dayjs'
export default {
    name: "CreateDateTemplate",
    components: {Multiselect},
    computed:{
            setRoomTypes() {
                return this.roomType.map(item =>({
                    name:item.attributes.name,
                    id: item.id
                }))
            },
            getRoomTypes() {
                return this.form.room_type_id.map(item => item.id)
            }
        },
    mounted() {
        this.getRoomType();
        this.getPartial();
    },
    data() {
        return {
            form: this.getClearFormObject(),
            patials: [],
            roomType: [],
            dayWeek: [],
            systemTime: [],
            ShiftSystem: [],
            partialRates: []
        };
    },
    methods: {
        getPartial(){
            let url = '/configuracion/partial-rates/get'
            axios
                .get(url)
                .then((response) => {
                    this.partialRates = response.data.data
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        createPermission() {
            var url = "/tarifas/date-templates/create";
            this.form.date = dayjs(this.form.date).format('DD/MM')
            this.form.room_type_id = this.getRoomTypes
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
                rate: "",
                date: "",
                partial_rate_id: '',
                hour_end: '',
                hour_start: '',
            };
        },
        getRoomType(){
            var urlKeeps = "/configuracion/room-type/get";
            axios
                .get(urlKeeps)
                .then((response) => {
                    this.roomType = response.data.data;
                })
                .catch((err) => {});
        },
    },
};
</script>
