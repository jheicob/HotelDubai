<template>
   <div id='calendar'></div>

    <ModalComponent id-modal="createReservation" size="xl" >
        <template #title>
            <h3>Crear Reservacion</h3>
        </template>

            <div class="row">
                <div class="col"></div>
                <div class="col-3">
                <label>Seleccione una Habitación</label>
                <select  class="form-select" @change="setItem" v-model="room_id">
                    <option value="">
                        Seleccione ...
                    </option>
                    <option v-for="room,i in helper.all" :key="i" :value="room.id">
                        {{ room.attributes.name }} - {{ room.relationships.partialCost.relationships.roomType.attributes.name }}
                    </option>
                </select>

                </div>
                <div class="col"></div>

            </div>
        <CreateReception></CreateReception>
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
import { ref,onMounted } from 'vue';
import { RoomStore } from './RoomStore';
import { storeToRefs } from 'pinia';
import { ocuppyRoomStore } from './Modals/OcuppyRoomStore';

const room_id = ref('')
const roomStore = RoomStore()
const helper = HelperStore()
const {item} = storeToRefs(helper)
const ocuppy = ocuppyRoomStore()
const {date} = storeToRefs(ocuppy)
const setItem = () => {
    item.value = helper.all.find(element => element.id == room_id.value)
}
const showReception = ref(false)
onMounted(() => {
    helper.getAll('room_status_id=2')

})


$(document).ready(function() {
    getReservation()
})

let events = []; // recepciones
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

const renderCalendar = () => {
    var calendarEl = document.getElementById('calendar');

    var calendar = new Calendar(calendarEl, {
      plugins: [ interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin ],
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
      eventClick: function(info) {
        var eventObj = info.event;
        console.log(eventObj);
        if (eventObj.url) {
          alert(
            'Clicked ' + eventObj.title + '.\n' +
            'Will open ' + eventObj.url + ' in a new tab'
          );

          window.open(eventObj.url);

          info.jsEvent.preventDefault(); // prevents browser from following link in current tab.
        } else {
          alert('Clicked ' + eventObj.title);
        }
      },
      select: function(info) {
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
document.addEventListener('DOMContentLoaded', function() {

});

</script>
