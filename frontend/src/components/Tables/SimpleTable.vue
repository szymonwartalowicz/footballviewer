<template>
  <div>
    <md-table v-model="results" :table-header-color="tableHeaderColor">
      <md-table-row slot="md-table-row" slot-scope="{ item }">
        <md-table-cell md-label="Name">{{ item.team_name }}</md-table-cell>
        <md-table-cell md-label="Wins">{{ item.wins }}</md-table-cell>
        <md-table-cell md-label="Losses">{{ item.losses }}</md-table-cell>
        <md-table-cell md-label="Draws">{{ item.draws }}</md-table-cell>
        <md-table-cell md-label="Points">{{ item.points }}</md-table-cell>
      </md-table-row>
    </md-table>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  name: "simple-table",
  props: {
    tableHeaderColor: {
      type: String,
      default: ""
    }
  },
  data() {
    return {
      selected: []
    };
  },
  computed: {
    ...mapGetters({
      results: "results"
    })
  },
  mounted() {
    this.getTeamsAndResults();
  },
  methods: {
    ...mapActions({ getTeamsAndResults: "getTeamsAndResults" })
  }
};
</script>
