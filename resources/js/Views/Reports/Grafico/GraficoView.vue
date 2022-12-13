<template>
    <div class="row">
    <Datepicker class="col-3" v-model="store.dates" range :format="store.formatPicker"/>
        <!-- <input type="date" v-model="form.date_start" />
        <input type="date" v-model="form.date_out" /> -->
        <select class="form-select col-2 mx-3" v-model="form.option" @change="getDataGraph">
            <option v-for="(item,i) in options" :key="i">
                {{item}}
            </option>
        </select>
        <select class="form-select col-1" v-model="store.type_current" @change="getDataGraph">
            <option v-for="(item,i) in store.type">
                {{item}}
            </option>
        </select>
        <button type="button" @click="getDataGraph" class="btn btn-primary col-1 mx-3">
        Filtrar
        </button>
        <button type="button" @click="PrintImage" class="btn btn-primary col-1 mx-3">
        PDF
        </button>
    </div>
    <div id="reportPage">
<Bar

    v-if="showGrah"
    id="grafico"
    :options="chartOptions"
    :data="chartData"
  />
    </div>
</template>
<script setup >
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
import {onMounted} from 'vue'
import {GraphStore} from './GraficoStore.ts'
import { storeToRefs } from 'pinia'
import { jsPDF } from "jspdf";
import dayjs from 'dayjs'
const store = GraphStore()
const {form,showGrah} = storeToRefs(store)

const {chartData,
    chartOptions,
    getDataGraph,
    changeType,
    options,
    type_current,
} = store
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

onMounted(() =>{
    getDataGraph()
})


function PrintImage() {
  // get size of report page
  var reportPageHeight = $('#reportPage').innerHeight();
  var reportPageWidth = $('#reportPage').innerWidth();

  // create a new canvas object that we will populate with all other canvas objects
  var pdfCanvas = $('<canvas />').attr({
    id: "canvaspdf",
    width: reportPageWidth,
    height: reportPageHeight
  });

  // keep track canvas position
  var pdfctx = $(pdfCanvas)[0].getContext('2d');
  var pdfctxX = 0;
  var pdfctxY = 0;
  var buffer = 100;

  // for each chart.js chart
  $("canvas").each(function(index) {
    // get the chart height/width
    var canvasHeight = $(this).innerHeight();
    var canvasWidth = $(this).innerWidth();

    // draw the chart into the new canvas
    pdfctx.drawImage($(this)[0], pdfctxX, pdfctxY, canvasWidth, canvasHeight);
    pdfctxX += canvasWidth + buffer;

    // our report page is in a grid pattern so replicate that in the new canvas
    if (index % 2 === 1) {
      pdfctxX = 0;
      pdfctxY += canvasHeight + buffer;
    }
  });

  // create new pdf and add our new canvas as an image
  var pdf = new jsPDF('l', 'pt', [reportPageWidth, reportPageHeight]);
  pdf.addImage($(pdfCanvas)[0], 'PNG', 0, 0);

  // download the pdf
  let fecha = dayjs().format('YYYY-MM-DDTHH:mm') +' '+type_current+'('+form.value.option+')'
  pdf.save(`${fecha}.pdf`);

}
function imprSelec(nombre) {
        var ficha = document.getElementById('grafico');
        var ventimp = window.open(' ', 'popimpr');
        ventimp.document.write( ficha.innerHTML );
        ventimp.document.close();
        ventimp.print( );
        ventimp.close();
      }
</script>
<style></style>
