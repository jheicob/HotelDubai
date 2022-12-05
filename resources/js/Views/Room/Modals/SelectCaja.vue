<template>
    <div class="input-group mb-3">
        <label class="input-group-text" for="inputGroupSelect01">Caja</label>
        <select
            :disabled="helper.permiss.fiscal_machine_id != ''"
            class="form-select" id="inputGroupSelect01"
            v-model="caja_fiscal"
            >
            <option v-for="option in fiscalStore.all" :key="option.id" :value="option.id">
                {{ option.attributes.name }}
            </option>
        </select>
    </div>
</template>
<script setup>
import { HelperStore } from '../../../HelperStore';
import { RoomTypeStore } from '../../FiscalMachine/FiscalMachineStore';
import { onMounted } from 'vue';
import { storeToRefs } from 'pinia';

const helper = HelperStore()
const fiscalStore = RoomTypeStore()

const { caja_fiscal } = storeToRefs(helper)

onMounted(() => {
    fiscalStore.getFiscalMachine()
    caja_fiscal.value = helper.permiss.fiscal_machine_id
})
</script>
