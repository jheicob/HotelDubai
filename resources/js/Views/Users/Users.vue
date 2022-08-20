<template>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <users-data-table
        :create="create"
        :deletet="deletet"
        :updated="updated"
      />
    </div>
  </div>
</template>

<script>
import UsersDataTable from "./Table/UsersDataTable.vue";

export default {
  name: "Roles",
  components: {
    UsersDataTable,
  },
  props: {
    create: {
      type: String,
      default: 0,
    },
    deletet: {
      type: String,
      default: 0,
    },
    updated: {
      type: String,
      default: 0,
    },
  },
};
</script>