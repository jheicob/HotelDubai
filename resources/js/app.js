/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require("./bootstrap");
//import "./bootstrap";

import { createApp } from "vue";
import { createPinia } from "pinia";
import permissions from "./Views/Permissions/Permissions.vue";
import roles from "./Views/Roles/Roles.vue";
import users from "./Views/Users/Users.vue";
import logs from "./Views/Logs/Logs.vue";
import profile from "./Views/Profile/Profile.vue";
import password from "./Views/Password/Password.vue";
import roomtype from "./Views/RoomType/RoomType.vue";
import themetype from "./Views/ThemeType/ThemeType.vue";
import estatetype from "./Views/EstateType/EstateType.vue";
import partialrates from "./Views/PartialRates/PartialRates.vue";
import roomstatus from "./Views/RoomStatus/RoomStatus.vue";
import partialcost from "./Views/PartialCost/PartialCost.vue";
import partialtemplate from "./Views/PartialTemplate/PartialTemplate.vue";
import dayweek from "./Views/DayWeek/DayWeek.vue";
import systemtime from "./Views/SystemTime/SystemTime.vue";
import shiftsystem from "./Views/ShiftSystem/ShiftSystem.vue";
import datetemplate from "./Views/Tarifas/DateTemplate/DateTemplate.vue";
import rangetemplate from "./Views/Tarifas/RangeTemplate/RangeTemplate.vue";
import Room from "./Views/Room/Room.vue";
import HourTemplate from "./Views/Tarifas/HourTemplate/HourTemplate.vue";
import DayTemplate from "./Views/Tarifas/DayTemplate/DayTemplate.vue";
import Invoice from "./Views/Invoice/Invoice.vue";
import Product from "./Views/Product/Product.vue";
import Configuration from "./Views/Configuration/Configuration.vue";
import Notification from "./Views/Notificaction/Notification.vue";
import CreateInvoice from "./Views/Invoice/Modals/CreateInvoice.vue";
import ExtraGuest from "./Views/ExtraGuest/ExtraGuest.vue";
import Login from "./Views/Auth/Login.vue"
import Report from "./Views/Reports/Report.vue"
import FiscalMachine from "./Views/FiscalMachine/FiscalMachine.vue";
import ProductCategory from "./Views/ProductCategory/ProductCategory.vue"
import ReportGraph from './Views/Reports/Grafico/GraficoView.vue'
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const app = createApp({});
app.use(createPinia());


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// app.component('example-component', require('./components/ExampleComponent.vue'));
app.component("permissions", permissions)
   .component("roles", roles)
   .component("users", users)
   .component("logs", logs)
   .component("profile", profile)
   .component("password", password)
   .component("roomtype", roomtype)
   .component("themetype", themetype)
   .component("estatetype", estatetype)
   .component("partialrates", partialrates)
   .component("roomstatus", roomstatus)
   .component("partialcost", partialcost)
   .component("partialtemplate", partialtemplate)
   .component("dayweek", dayweek)
   .component("systemtime", systemtime)
   .component("shiftsystem", shiftsystem)
   .component("datetemplate", datetemplate)
   .component("HourTemplate", HourTemplate)
   .component("DayTemplate", DayTemplate)
   .component("room", Room)
   .component("invoice", Invoice)
   .component("product", Product)
   .component("configuration", Configuration)
   .component("range-template", rangetemplate)
   .component("room-notification", Notification)
   .component("create-invoice", CreateInvoice)
   .component("extra-guest", ExtraGuest)
   .component("login", Login)
   .component("reports", Report)
   .component('fiscal-machine',FiscalMachine)
   .component('product-category',ProductCategory)
   .component('reporte-grafico',ReportGraph)
   .component('Datepicker', Datepicker);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

app.mount("#app");
