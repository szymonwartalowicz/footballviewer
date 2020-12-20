<template>
  <div>
    <md-table v-model="players" :table-header-color="tableHeaderColor">
      <md-table-row slot="md-table-row" slot-scope="{ item }">
        <md-table-cell md-label="Name">{{ item.name }}</md-table-cell>
        <md-table-cell md-label="DoB">{{ item.dob }}</md-table-cell>
      </md-table-row>
    </md-table>
  </div>
</template>

<script>
export default {
  name: "players",
  props: {
    tableHeaderColor: {
      type: String,
      default: ""
    },
    players: {
      type: Array
    }
  },
  data() {
    return {};
  }
};
</script>
