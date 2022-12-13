import axios from 'axios';
import dayjs from 'dayjs';
import {defineStore} from 'pinia'
import { ref,computed } from 'vue';

export const GraphStore = defineStore('graphStore', () => {

const options = ['RoomTypes','Rooms','EstateTypes'];
const showGrah = ref(false)

const form = ref({
    option: 'EstateTypes',
    date_start: '',
    date_end:   '',
})
const chartData= ref({
    labels: [ ],
    datasets: [
        {
        label:['Rotación'],
        backgroundColor: ['#41B883'],
        data: []
        } ,
        // {
        // label:['Neto'],
        // backgroundColor: ['#F0BA83'],
        // data: []
        // }
    ]
  })

const chartOptions= ref({
    responsive: true,
    plugins: {
        title: {
          display: true,
          text: 'Grafico ',
        }
      }
  })

  const dates = ref([])
  const values = ref([]);
  const payments = ref([]);
  const type = ['Dinero','Rotación'];
  const type_current = ref('Rotación');

  const labels = ref([])

  const getDataGraph = () => {
    showGrah.value = false
    form.value.date_start = getDatePicker.value[0]
    form.value.date_end = getDatePicker.value[1]
    axios
        .get('/invoice/get-data-graph',{
            params:form.value
        })
       .then(response => {
            let data = response.data;
            // dataGraph.value = response.data;
            labels.value = data.names;
            values.value = data.values;
            payments.value = data.payments;

            changeType()
            // chartData.value.datasets[1].data = data.payments;

        })
       .catch(error => console.log(error));
}

const changeType = () => {
    showGrah.value = false

    if(type_current.value == 'Dinero'){
        chartData.value.datasets[0].label = ['Dinero']
        chartData.value.datasets[0].data = payments.value;payments
    }else
    if(type_current.value == 'Rotación'){
        chartData.value.datasets[0].label = ['Rotación']
        chartData.value.datasets[0].data = values.value;
    }
    chartOptions.value.plugins.title.text += `de ${form.value.option} (${type_current.value})`
    if(getDatePicker.value[0] != ''){
        chartOptions.value.plugins.title.text += ` desde: ${getDatePicker.value[0]} hasta: ${getDatePicker.value[1]}`
    }
    chartData.value.labels = labels.value;
    showGrah.value = true

}
const formatPicker = (date) => {
        const day = date[0].getDate();
        const month = date[0].getMonth() + 1;
        const year = date[0].getFullYear();

        const day_o   = date[1].getDate();
        const month_o = date[1].getMonth() + 1;
        const year_o  = date[1].getFullYear();
        return `${day}/${month}/${year} - ${day_o}/${month_o}/${year_o}`;
}

const getDatePicker = computed(() => {
    if(!dates.value){
        return [
            '',
            ''
        ]
    }
    return [
        dates.value[0] ? dayjs(dates.value[0]).format('DD-MM-YYYY') : '',
        dates.value[1] ? dayjs(dates.value[1]).format('DD-MM-YYYY') : '',
    ]

})

return {
    form,
    getDatePicker,
    chartData,
    chartOptions,
    getDataGraph,
    options,
    showGrah,
    type,
    type_current,
    changeType,
    dates,
    formatPicker
}
})
