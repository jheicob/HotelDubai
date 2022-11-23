<template>
    <li class="nav-item dropdown">
        <a
            class="nav-link dropdown-toggle"
            href="#"
            id="pagesDropdown"
            role="button"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
        >
            <i class="fas fa-clipboard-list"></i>
            <span>Reportes</span>
        </a>

        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a
                v-if="client_report"
                id="client_report"
                class="dropdown-item text-dark"
                @click.prevent="store.openModal('Clientes')"
                href="#"
            >
                Clientes
            </a>
            <a
                v-if="room_type_report"
                id="client_report"
                class="dropdown-item text-dark"
                @click.prevent="store.openModal('Tipo Habitaciones')"
                href="#"
            >
                Tipo de Habitaciones
            </a>
            <a
                v-if="room_report"
                @click.prevent="store.openModal('Habitaciones')"
                id="client_report"
                class="dropdown-item text-dark"
                href="#"

            >
                Habitaciones
            </a>
            <a
                v-if="reception_report"
                id="client_report"
                @click.prevent="store.openModal('Recepciones')"
                class="dropdown-item text-dark"
                href="#"
            >
                Recepciones
            </a>
        </div>
    </li>
    <FilterModalReport />
</template>
<script setup>
import FilterModalReport from "./FilterModalReport.vue";
import { ReportStore } from "./ReportStore";
import { RoomTypeStore } from "../RoomType/RoomTypeStore";
import { onMounted } from "vue";

const store = ReportStore();
const roomType = RoomTypeStore()
const props = defineProps({
    client_report: {
        type: Boolean,
        default: false,
    },
    room_type_report: {
        type: Boolean,
        default: false,
    },
    room_report: {
        type: Boolean,
        default: false,
    },
    reception_report: {
        type: Boolean,
        default: false,
    },
});

onMounted(() => {
    roomType.getRoomTypes()
    store.getEstateTypes()
})
</script>
<style></style>
