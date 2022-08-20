<template>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <logs-data-table />
    </div>
  </div>
</template>

<script>
import LogsDataTable from "./Table/LogsDataTable.vue";

export default {
  name: "Tags",
  components: {
    LogsDataTable,
  },
};
</script>