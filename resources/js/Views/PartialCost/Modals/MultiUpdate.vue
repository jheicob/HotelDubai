<template>
    <div class="col text-right">
        <button
            type="button"
            data-toggle="modal"
            @click.prevent="openModal()"

            class="btn btn-info text-white btn-icon-split mb-4 text font-montserrat font-weight-bold"
        >
            Actualización Masiva
        </button>
    </div>
    <!-- Modal -->
    <div
    class="modal fade"
    id="multiupdate"
    tabindex="-1"
    role="dialog"
    aria-labelledby="multiupdate"
    aria-hidden="true"
    >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header py-2">
              <h5
                class="modal-title title-page text-secondary"
                id="multiupdate"
              >
                Actualización Masiva
              </h5>
              <a
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </a>
            </div>
            <div class="modal-body">
              <label for="name" class="form-label">Tipo Habitacion</label>

              <multiselect
                    v-model="form.room_types"
                    id="checkedPermissions"
                    :options="room_types"
                    :multiple="true"
                    label="name"
                    track-by="id"
                />

              <label for="name" class="form-label">Parcial</label>

              <multiselect
                    v-model="form.partial_rates"
                    id="checkedPermissions"
                    :options="partial_rates"
                    :multiple="true"
                    label="name"
                    track-by="id"
                />

              <label for="name" class="form-label">Tarifa</label>

              <input
                type="number"
                id="name"
                class="form-control form-control-user mb-3"
                autofocus
                name="name"
                v-model="form.rate"
              />
            </div>
            <div class="modal-footer">
              <a
                class="btn btn-danger text-white btn-icon-split mb-4"
                data-dismiss="modal"
              >
                <span class="text font-montserrat font-weight-bold"
                  >Cancelar</span
                >
              </a>
              <a
                @click.prevent="putPartial"
                class="btn btn-primary text-white btn-icon-split mb-4"
              >
                <span class="text font-montserrat font-weight-bold"
                  >Actualizar Masivo</span
                >
              </a>
            </div>
          </div>
        </div>
      </div>
  </template>

<script setup>
    import axios from "axios";
	import Multiselect from "vue-multiselect";
    import {ref} from "vue"
    import { HelperStore } from "../../../HelperStore";

    const helper = HelperStore();
    const form = ref({
        room_types: [],
        partial_rates: [],
        rate: 0
    })

    const room_types = ref([])
    const partial_rates = ref([])

    const putPartial = () => {
        form.value.room_types = form.value.room_types.map(item => (item.id))
        form.value.partial_rates = form.value.partial_rates.map(item => (item.id))
        axios
            .post('partial-cost/multiupdate',form.value)
            .then(res => {
                location.reload()
            })
    }

    const getRoomTypes = () => {
        room_types.value = []
        axios
           .get(`/configuracion/room-type/get`)
           .then(response => {
                room_types.value = response.data.data.map(item => {
                    return {
                        name: item.attributes.name,
                        id: item.id
                    }
                })
           })
           .catch(error => helper.getErrorRequest(error))
    }

    const getPartialRates = () => {
        partial_rates.value = []

        axios
          .get(`/configuracion/partial-rates/get`)
          .then(response => {
                partial_rates.value = response.data.data.map(item => {
                    return {
                        name: item.attributes.name,
                        id: item.id
                    }
                })
           })
          .catch(error => helper.getErrorRequest(error))
    }

    const openModal = () => {
        $('#multiupdate').modal("show");

        getRoomTypes()
        getPartialRates()
    }

  </script>
