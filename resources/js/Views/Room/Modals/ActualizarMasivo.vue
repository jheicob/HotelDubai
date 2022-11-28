<template>
    <div class="col-2 my-auto">
        <a
            @click.prevent="openModal()"
            v-if="permiss.updated"
            class="btn btn-primary text-white btn-icon-split"
        >
            <i class="fas fa-check"></i>
            <span class="text font-montserrat font-weight-bold"
                >Actualización Masiva</span
            >
        </a>
    </div>
    <ModalComponent idModal="update-rooms-masive" title footer>
        <template #title>
            <h3>Actualización Masiva de Parciales</h3>
        </template>

        <div class="row">
            <div class="form-floating">
            <select
                class="form-select"
                id="floatingSelect"
                v-model="form.room_type_id"
                @change="updateFields"
            >
                <option value="">Seleccione...</option>
                <option
                    v-for="(item,i) in roomTypes"
                    :key="i"
                    :value="item.id"
                >
                {{item.attributes.name }}
                </option>
            </select>
            <label for="floatingSelect">Tipo de Habitación</label>
            </div>
        </div>
        <div class="row my-4 pr-4">
            <label>Habitaciones </label>
            <multiselect
                v-model="form.room_id"
                id="rooms_update_masive"
                :options="rooms"
                :multiple="true"
                label="name"
                track-by="id"
            >
            </multiselect>
        </div>
        <div class="row">
            <div class="form-floating">
            <select
                class="form-select"
                id="floatingSelect"
                aria-label="Floating label select example"
                v-model="form.partial_cost_id"
            >
                <option value="">Seleccione...</option>
                <option
                    v-for="(item,i) in partialCost"
                    :key="i"
                    :value="item.id"
                >
                ({{ item.relationships.partialRate.attributes.name }})
									$
									{{ item.attributes.rate }}
                </option>
            </select>
            <label for="floatingSelect">Precio - Parciales</label>
            </div>
        </div>
        <template #footer>
            <ButtonComponent
               :btnClass="['btn-danger']"
                @click="closeModal"
            >
                Cerrar
            </ButtonComponent>
            <ButtonComponent @click="updateMasive" :disabled="helper.desactiveButton">
                Guardar
            </ButtonComponent>
        </template>
    </ModalComponent>
</template>

<script setup>
import ModalComponent from "@/components/ModalComponent.vue"
import ButtonComponent from "@/components/ButtonComponent.vue"
import { HelperStore } from "../../../HelperStore";
import { storeToRefs } from "pinia";
import { ref, onMounted,computed } from "vue";
import axios from "axios";
import Multiselect from "vue-multiselect";
import { RoomStore } from "../RoomStore";

const roomStore = RoomStore()
const helper = HelperStore()
const {permiss} = storeToRefs(helper)

const {desactiveButton} = storeToRefs(helper)

const form = ref({
    room_type_id: '',
    room_id: '',
    partial_cost_id: '',
})

const closeModal = () => {
    form.value = {
        room_type_id: '',
        room_id: '',
        partial_cost_id: '',
    }
    $('#update-rooms-masive').modal('hide');
}

const openModal = () => {
    $('#update-rooms-masive').modal('show')
}

const updateMasive = () => {
    desactiveButton.value = true;
    form.value.room_id = form.value.room_id.map(item => (item.id))
    axios
        .put('room/update-masive',form.value)
        .then(res => {
            closeModal()
            roomStore.getRooms()
        })
        .catch(e => helper.getErrorRequest(e))
        .finally(() => {
            desactiveButton.value = false
        })
}

const updateFields = () => {
    getRooms()
    getPartialCost()
    form.value.partial_cost_id = ''
    form.value.room_id = []
}

const roomTypes = ref([])
const getRoomType = () => {
    axios
       .get('configuracion/room-type/get')
       .then(res => {
            roomTypes.value = res.data.data
       })
       .catch(err => helper.getErrorRequest(err))
}
const rooms = ref([])
const getRooms = () => {
    rooms.value = []
    axios
        .get('room/get?room_type_id='+form.value.room_type_id)
        .then(res => {
            rooms.value = res.data.data.map(item => ({
                id: item.id,
                name: item.attributes.name,
            }))
        })
        .catch(e => helper.getErrorRequest(e))
}
const partialCost = ref([])
const getPartialCost = () => {
    partialCost.value = []
    axios
        .get('/tarifas/partial-cost/get?room_type_id='+form.value.room_type_id)
        .then(res => {
                partialCost.value = res.data.data
            })
        .catch(e => helper.getErrorRequest(e))
}

onMounted(() => {
    getRoomType()
    getRooms()
})
</script>
