<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="container">
                <div class="row">
                    <h3>Configuracion General</h3>
                </div>

                <!-- <div class="row">
                    <div class="col-5">
                        <hr class="border border-3 border-danger" />
                    </div>
                    <div class="col-2 text-center mb-2">Factura Fiscal</div>
                    <div class="col-5">
                        <hr class="border border-3 border-danger" />
                    </div>
                    <div class="form-floating mb-3 col-6">
                        <input
                            type="text"
                            class="form-control"
                            id="machine_fiscal"
                            placeholder="AXZ-123"
                            v-model="config.fiscal_machine_serial"
                        />
                        <label for="machine_fiscal" class="mx-3"
                            >Serial de Máquina Fiscal</label
                        >
                    </div>
                    <div class="form-floating mb-3 col-6">
                        <input
                            type="text"
                            class="form-control"
                            id="env"
                            placeholder="ED"
                            v-model="config.env"
                        />
                        <label class="mx-3" for="env"
                            >Código de ambiente para impresión</label
                        >
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-5">
                        <hr class="border border-3 border-danger" />
                    </div>
                    <div class="col-2 text-center mb-2">Financias</div>
                    <div class="col-5">
                        <hr class="border border-3 border-danger" />
                    </div>
                    <div class="form-floating mb-3 col-6 mx-auto">
                        <input
                            type="text"
                            min="0"
                            class="form-control"
                            id="exchange"
                            placeholder="8.5"
                            v-model="config.exchange_rate"
                        />
                        <label for="exchange" class="mx-3"
                            >Tasa de cambio Bs/USD</label
                        >
                    </div>
                </div>
                <div class="row">
                    <div class="col-5">
                        <hr class="border border-3 border-danger" />
                    </div>
                    <div class="col-2 text-center mb-2">Tiempos</div>
                    <div class="col-5">
                        <hr class="border border-3 border-danger" />
                    </div>
                    <div class="form-floating mb-3 col-6 mx-auto">
                        <input
                            type="text"
                            class="form-control"
                            id="warning_time"
                            v-model="config.warning_time"
                            @blur="verifyWarningTime"
                        />
                        <label for="warning_time" class="mx-3"
                            >Tiempo de Aviso (HH:mm:ss)</label
                        >
                    </div>

                    <div class="form-floating mb-3 col-6 mx-auto">
                        <input
                            type="text"
                            min="0"
                            class="form-control"
                            id="cancel_time"
                            placeholder="8.5"
                            v-model="config.cancel_time"

                            @blur="verifyCancelTime"
                        />
                        <label for="cancel_time" class="mx-3"
                            >Tiempo de Cancelación (HH:mm:ss)</label
                        >
                    </div>

                    <div class=" mb-3 col-6 mx-auto">
                        <ColorPicker
                            id="color_warning_time"
                            v-model="config.color_warning_time"
                            mode="solid"
                            @colorChanged="getColorW"

                            />
                        <label for="cancel_time" class="mx-3"
                            >Color Marca de Aviso</label
                        >
                        <div style="margin:1px;height:20px;" :style="config.color_warning_time?.css ?? ''" >

                        </div>
                    </div>
                    <div class="mb-3 col-6 mx-auto">
                        <ColorPicker
                            mode="solid"
                            @colorChanged="getColorC"

                            id="color_past_time"

                            v-model="config.color_past_time"
                            />

                            <label for="color_past_time" class="mx-3"
                            >Color Tiempo Pasado</label
                            >
                            <div style="margin:1px;height:20px; ;" :style="config.color_past_time?.css ?? ''" >
                        </div>
                    </div>
                </div>


                <hr class="border border-3 border-danger" />
                <div class="row my-4">
                    <div class="col text-center">
                        <button
                            class="btn btn-info col-1"
                            type="button"
                            v-if="useHelper.permiss.upsert"
                            @click="store.putConfig"
                        >
                            Actualizar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ConfigurationStore } from "./ConfigurationStore.js";
import { HelperStore } from "../../HelperStore";
import { onMounted, computed, watch, ref } from "vue";
import { storeToRefs } from "pinia";
import ColorPicker from "@mcistudio/vue-colorpicker";
import InputMask from "vue-input-mask";


const useHelper = HelperStore();
const store = ConfigurationStore();
const props = defineProps({
    upsert: {
        type: Boolean,
        default: false,
    },
});

const verifyLength = (type, event) => {
    console.log("evento", event);
    if (type == "Cancel") {
        if (config.value.cancel_time.length > 8) {
            e.preventDefault();
            return;
        }
    }
    if (type == "Warning") {
        if (config.value.warning_time.length > 8) {
            e.preventDefault();
            return;
        }
    }
};

const verifyCancelTime = () => {
    let times = config.value.cancel_time.split(":", 3);
    console.log("times", times);
    let result = "";
    times.map((time) => time.replace(/\Aa-Zz+/, ""));

    console.log("nuevo", times);
    config.value.cancel_time = times.join(":");
};

const verifyWarningTime = () => {
    let times = config.value.cancel_time.split(":", 3);
    console.log("times", times);
    let result = "";
    times.map((time) => time.replace(/\Aa-Zz+/, ""));

    console.log("nuevo", times);
    config.value.cancel_time = times.join(":");
};
const { config } = storeToRefs(store);
// const warning_time = ref(config.value.warning_time);
useHelper.permiss = props;

const getColorC = (color) => {
    config.value.color_past_time = color
}
const getColorW = (color) => {
    config.value.color_warning_time = color
}
onMounted(() => {
    store.getConfiguration();
});
</script>
