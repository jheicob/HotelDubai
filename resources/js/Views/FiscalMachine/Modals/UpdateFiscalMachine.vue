<template>
    <form>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header py-2">
                        <h5 class="modal-title title-page text-secondary" id="exampleModalLabel">
                            Modificar Maquina Fiscal
                        </h5>
                        <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <label for="name" class="form-label">Nombre</label>

                        <input type="name" id="name" class="form-control form-control-user mb-3" placeholder="Caja 1"
                            autofocus name="name" v-model="useHelper.form.name" />

                        <label for="name" class="form-label">Serial</label>

                        <input type="name" id="name" class="form-control form-control-user mb-3" autofocus name="name"
                            v-model="useHelper.form.serial" />

                        <label for="name" class="form-label">Tipo de Inmueble</label>

                        <select class="form-select" v-model="useHelper.form.estate_type_id">
                            <option value="">Seleccione...</option>
    useStore.clearForm();
                            <option v-for="item in useStore.estate_types" :value="item.id" :key="(item.id)">
                                {{item.attributes.name}}
                            </option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-danger text-white btn-icon-split mb-4" data-dismiss="modal">
                            <span class="text font-montserrat font-weight-bold">Cancelar</span>
                        </a>
                        <button :disabled="useHelper.desactiveButton" v-on:click.prevent="useStore.putFiscalMachines()"
                            class="btn btn-primary text-white btn-icon-split mb-4">
                            <span class="text font-montserrat font-weight-bold">Modificar Maquina Fiscal</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script setup>
import { RoomTypeStore } from "../FiscalMachineStore";
import { HelperStore } from "@/HelperStore";
const useStore = RoomTypeStore();
const useHelper = HelperStore();
</script>
