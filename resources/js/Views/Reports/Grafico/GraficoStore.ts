import axios from 'axios';
import {defineStore} from 'pinia'
import { ref } from 'vue';

export const GraphStore = defineStore('graphStore', () => {

const options = ['RoomTypes','Rooms','EstateTypes'];
const showGrah = ref(false)
const form = ref({
    option: 'EstateTypes'
})
const chartData= ref({
    labels: [ ],
    datasets: [
        {
        label:['Rotación'],
        backgroundColor: ['#41B883'],
        data: []
        } ,
        {
        label:['Neto'],
        backgroundColor: ['#F0BA83'],
        data: []
        }
    ]
  })

const chartOptions= {
    responsive: true
  }

  const getDataGraph = () => {
    showGrah.value = false
    axios
        .get('/invoice/get-data-graph',{
            params:form.value
        })
       .then(response => {
            let data = response.data;
            // dataGraph.value = response.data;
            chartData.value.labels = data.names;
            chartData.value.datasets[0].data = data.values;
            showGrah.value = true

        })
       .catch(error => console.log(error));
}

return {
    form,
    chartData,
    chartOptions,
    getDataGraph,
    options,
    showGrah
}
})
