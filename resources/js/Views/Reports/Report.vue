<template>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-clipboard-list"></i>
        <span>Reportes</span>
    </a>
    <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a v-if="client_report" target="_blank" id="client_report" class="dropdown-item text-dark"
                href="{{ route('client.report') }}">Clientes</a>
    </div>
</li>
</template>
<script setup>
    import { ReportStore } from './ReportStore';

    const store = ReportStore()

    const props = defineProps({
        client_report: {
            type: Boolean,
            default: false
        }
    })
</script>
<style>
</style>
