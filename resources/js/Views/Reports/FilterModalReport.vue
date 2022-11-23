<template>
    <ModalComponent idModal="reportModal" title size="lg" footer>
        <template #title>
            <h3>Reporte de {{ store.type_report }}</h3>
        </template>

        <div class="row" v-if="store.input_views.range_dates">
            <div class="col">
                <div class="form-floating">
                    <input type="date" class="form-control" id="date_start" v-model="store.form.date_start" />
                    <label for="date_start">Fecha Inicio</label>
                </div>
            </div>
            <div class="col">
                <div class="form-floating">
                    <input type="date" class="form-control" id="date_end" v-model="store.form.date_end" />
                    <label for="date_end">Fecha Fin</label>
                </div>
            </div>
        </div>
        <div class="row mt-3" v-if="store.input_views.room_type_id">
            <div class="col">
                <label for="room_type">Tipo de Habitacion</label>
                <multiselect
                    id="checkedPermissions"
                    :options="store.setRoomTypes(roomType.all)"
                    :multiple="true"
                    label="name"
                    v-model="store.form.room_type_id"
                    track-by="id"
                >
                </multiselect>
            </div>
        </div>
        <div class="row mt-3" v-if="store.input_views.estate_type_id">
            <div class="col">
                <label for="room_type">Tipo de Inmueble</label>
                <multiselect
                    id="checkedPermissions"
                    :options="store.setRoomTypes(store.estateTypes)"
                    :multiple="true"
                    label="name"
                    v-model="store.form.estate_type_id"
                    track-by="id"
                >
                </multiselect>
            </div>
        </div>
        <hr />
        <div class="fs-6 text">
            Nota: Si no seleccionas algún item no se tomará en cuenta al momento de hacer el filtro para generar el reporte
        </div>
        <template #footer>
            <button class="btn btn-danger col-3" @click="store.closeModal" type="button">
                Cancelar
            </button>
            <button class="btn btn-success col-3" @click="store.abrirReporte">
                Reporte
            </button>
        </template>
    </ModalComponent>
</template>
<script setup>
import ModalComponent from "@/components/ModalComponent.vue";
import { ReportStore } from "./ReportStore";
import Multiselect from "vue-multiselect";
import { RoomTypeStore } from "../RoomType/RoomTypeStore";
const store = ReportStore();
const roomType = RoomTypeStore();
</script>
