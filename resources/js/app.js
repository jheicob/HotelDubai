/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('permissions', require('./Views/Permissions/Permissions').default);
Vue.component('roles', require('./Views/Roles/Roles').default);
Vue.component('users', require('./Views/Users/Users').default);
Vue.component('logs', require('./Views/Logs/Logs').default);
Vue.component('profile', require('./Views/Profile/Profile').default);
Vue.component('password', require('./Views/Password/Password').default);
Vue.component('roomtype', require('./Views/RoomType/RoomType').default);
Vue.component('themetype', require('./Views/ThemeType/ThemeType').default);
Vue.component('estatetype', require('./Views/EstateType/EstateType').default);
Vue.component('partialrates', require('./Views/PartialRates/PartialRates').default);
Vue.component('roomstatus', require('./Views/RoomStatus/RoomStatus').default);
Vue.component('partialcost', require('./Views/PartialCost/PartialCost').default);
Vue.component('partialtemplate', require('./Views/PartialTemplate/PartialTemplate').default);
Vue.component('dayweek', require('./Views/DayWeek/DayWeek').default);
Vue.component('systemtime', require('./Views/SystemTime/SystemTime').default);
Vue.component('shiftsystem', require('./Views/ShiftSystem/ShiftSystem').default);
Vue.component('datetemplate', require('./Views/Tarifas/DateTemplate/DateTemplate.vue').default);
Vue.component('hour-template', require('./Views/Tarifas/HourTemplate/HourTemplate.vue').default);
Vue.component('room', require('./Views/Room/Room.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
