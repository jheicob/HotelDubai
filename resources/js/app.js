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
app.component("permissions", permissions);
app.component("roles", roles);
app.component("users", users);
app.component("logs", logs);
app.component("profile", profile);
app.component("password", password);
app.component("roomtype", roomtype);
app.component("themetype", themetype);
app.component("estatetype", estatetype);
app.component("partialrates", partialrates);
app.component("roomstatus", roomstatus);
app.component("partialcost", partialcost);
app.component("partialtemplate", partialtemplate);
app.component("dayweek", dayweek);
app.component("systemtime", systemtime);
app.component("shiftsystem", shiftsystem);
app.component("datetemplate", datetemplate);
app.component("HourTemplate", HourTemplate);
app.component("DayTemplate", DayTemplate);
app.component("room", Room);
app.component("invoice", Invoice);
app.component("product", Product);
app.component("configuration", Configuration);
app.component("range-template", rangetemplate);
app.component("room-notification", Notification);
app.component("create-invoice", CreateInvoice);
app.component("extra-guest", ExtraGuest);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

app.mount("#app");
