<template>
    <div id='calendar'></div>

    <ModalComponent id-modal="createReservation" size="xl" :footer="!showButtonsModal" title>
        <template #title>
            <h3>Crear Reservacion</h3>
        </template>

        <div class="row">
            <div class="col"></div>
            <div class="col-3">
                <label>Seleccione una Habitación</label>
                <select class="form-select" @change="setItem" v-model="room_id">
                    <option value="">
                        Seleccione ...
                    </option>
                    <option v-for="room, i in helper.all" :key="i" :value="room.id">
                        {{ room.attributes.name }} - {{
                                room.relationships.partialCost.relationships.roomType.attributes.name
                        }}
                    </option>
                </select>

            </div>
            <div class="col"></div>

        </div>
        <CreateReception :showButtons="showButtonsModal"></CreateReception>

        <template #footer>

            <a class="btn btn-danger text-white btn-icon-split col-3" @click="cancelarReservation"
                v-if="updated_reception">
                <span class="text font-montserrat font-weight-bold">Cancelar Reservación</span>
            </a>
            <a class="btn btn-success text-white btn-icon-split col-1" @click="closeModal"
                v-if="updated_reception">
                <span class="text font-montserrat font-weight-bold">cerrar</span>

            </a>
            <button v-if="false" class="btn btn-success text-white btn-icon-split col-1" type="button"
                @click.prevent="editarReception()">
                Editar
            </button>

        </template>
    </ModalComponent>
</template>

<script setup>
import ModalComponent from '../../components/ModalComponent.vue'
import CreateReception from './Reception/CreateReception.vue';
import { Calendar } from '@fullcalendar/core';
import interactionPlugin from '@fullcalendar/interaction';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import '@/index.css';
import dayjs from 'dayjs';
import axios from 'axios';
import { HelperStore } from '../../HelperStore';
import { ref, onMounted } from 'vue';
import { RoomStore } from './RoomStore';
import { storeToRefs } from 'pinia';
import { ocuppyRoomStore } from './Modals/OcuppyRoomStore';
import { receptionStore } from './Reception/ReceptionStore';

const reception_store = receptionStore()
const room_id = ref('')
const roomStore = RoomStore()
const helper = HelperStore()
const { item, form } = storeToRefs(helper)
const ocuppy = ocuppyRoomStore()
const { updated_reception } = storeToRefs(reception_store)
const { date } = storeToRefs(ocuppy)
const setItem = () => {
    item.value = helper.all.find(element => element.id == room_id.value)
}

const closeModal = () => {
    $('#createReservation').modal('hide')
}

onMounted(() => {
    getReservation()
    helper.getAll('room_status_id=2')
})
const editarReception = () => {
    console.log('se edito')
}


const cancelarReservation = () => {
    let url = '/room/cancel-reservation/' + reception_id.value
    axios
        .delete(url)
        .then(res => {
            $('#createReservation').modal('hide')
            getReservation()
        })

}

let events = ref([]); // recepciones
const getReservation = () => {
    let url = '/room/get-reservation/calendar-reservation'
    axios
        .get(url)
        .then(res => {
            events = (res.data);
            renderCalendar()
            console.log(events)
        })
}

const showButtonsModal = ref(true)
const reception_id = ref()
const renderCalendar = () => {
    var calendarEl = document.getElementById('calendar');

    var calendar = new Calendar(calendarEl, {
        plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin],
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        initialDate: dayjs().format('YYYY-MM-DD'),
        navLinks: true, // can click day/week names to navigate views
        // editable: true,
        selectable: true,
        dragScroll: true,
        eventClick: function (info) {
            showButtonsModal.value = false
            var eventObj = info.event;
            let i = events.find(element => element.id == eventObj.id)
            console.log(i)
            if (i) {
                updated_reception.value = true
                form.value.reception_id = eventObj.id
                reception_id.value = eventObj.id
                form.value.client_id = i.client.id
                form.value.document = i.client.document
                form.value.type_document_id = i.client.type_document_id
                form.value.first_name = i.client.first_name
                form.value.last_name = i.client.last_name
                form.value.phone = i.client.phone
                form.value.email = i.client.email
                form.value.room_id = i.room.id
                form.value.date_in = i.date_in
                date.value = dayjs(i.date_in).format('YYYY-MM-DDTHH:mm');
                room_id.value = i.room.id
                item.value = helper.all.find(element => element.id == i.room.id)

            }

            $('#createReservation').modal('show')
        },
        select: function (info) {
            showButtonsModal.value = true
            updated_reception.value = false
            $('#createReservation').modal('show')
            date.value = dayjs(info.startStr).format('YYYY-MM-DDTHH:mm');
            // alert('selected ' + info.startStr + ' to ' + info.endStr);
        },
        // dateClick: function(info) {
        //     alert('Clicked on: ' + info.dateStr);
        //     alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
        //     alert('Current view: ' + info.view.type);
        //     // change the day's background color just for fun
        //     console.log(info,info.dayEl)
        //     info.dayEl.style.backgroundColor = 'red';
        //   },
        dayMaxEvents: true, // allow "more" link when too many events
        events
    });
    calendar.setOption('locale', 'es');
    calendar.render();
}
document.addEventListener('DOMContentLoaded', function () {

});

</script>
