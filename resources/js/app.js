/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
//require('./bootstrap');
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import Room from './Views/Room/Room.vue';
import permissions from './Views/Permissions/Permissions'
import roles from './Views/Roles/Roles'
import users from './Views/Users/Users'
import logs from './Views/Logs/Logs'
import profile from './Views/Profile/Profile'
import password from './Views/Password/Password'
import roomtype from './Views/RoomType/RoomType'
import themetype from './Views/ThemeType/ThemeType'
import estatetype from './Views/EstateType/EstateType'
import partialrates from './Views/PartialRates/PartialRates'
import roomstatus from './Views/RoomStatus/RoomStatus'
import partialcost from './Views/PartialCost/PartialCost'
import partialtemplate from './Views/PartialTemplate/PartialTemplate'
import dayweek from './Views/DayWeek/DayWeek'
import systemtime from './Views/SystemTime/SystemTime'
import shiftsystem from './Views/ShiftSystem/ShiftSystem'
import datetemplate from './Views/Tarifas/DateTemplate/DateTemplate.vue'
import HourTemplate from './Views/Tarifas/HourTemplate/HourTemplate.vue'
import DayTemplate from './Views/Tarifas/DayTemplate/DayTemplate.vue'
const app = createApp({});
app.use(createPinia())
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

app.component('example-component', require('./components/ExampleComponent.vue'));
app.component('permissions',permissions);
app.component('roles',roles);
app.component('users',users);
app.component('logs',logs);
app.component('profile',profile);
app.component('password',password);
app.component('roomtype',roomtype);
app.component('themetype',themetype);
app.component('estatetype',estatetype);
app.component('partialrates',partialrates);
app.component('roomstatus',roomstatus);
app.component('partialcost',partialcost);
app.component('partialtemplate',partialtemplate);
app.component('dayweek',dayweek);
app.component('systemtime',systemtime);
app.component('shiftsystem',shiftsystem);
app.component('datetemplate',datetemplate);
app.component('HourTemplate',HourTemplate);
app.component('DayTemplate',DayTemplate);
app.component('room', Room);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

app.mount('#app')
