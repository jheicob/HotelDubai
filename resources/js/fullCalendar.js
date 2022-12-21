
import { Calendar } from '@fullcalendar/core';
import interactionPlugin from '@fullcalendar/interaction';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import './index.css';
import dayjs from 'dayjs';
import axios from 'axios';

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
        alert('selected ' + info.startStr + ' to ' + info.endStr);
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
