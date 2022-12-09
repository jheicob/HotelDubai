<template>
<div>
<select v-model="form.option" @change="getDataGraph">
<option v-for="(item,i) in options" :key="i">
{{item}}
</option>
</select>
</div>
<Bar
    v-if="showGrah"
    id="my-chart-id"
    :options="chartOptions"
    :data="chartData"
  />
</template>
<script setup >
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
import {onMounted} from 'vue'
import {GraphStore} from './GraficoStore.ts'
import { storeToRefs } from 'pinia'

const store = GraphStore()
const {form,showGrah} = storeToRefs(store)

const {chartData,
    chartOptions,
    getDataGraph,
    options} = store
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

onMounted(() =>{
    getDataGraph()
})
</script>
<style></style>
