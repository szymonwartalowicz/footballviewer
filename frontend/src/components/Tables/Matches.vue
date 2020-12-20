<template>
  <div>
    <md-table v-model="matches" md-fixed-header>
      <md-table-row slot="md-table-row" slot-scope="{ item }">
        <md-table-cell md-label="Date">{{
          matchDateFormat(item.match_date)
        }}</md-table-cell>
        <md-table-cell md-label="Home Team">{{ item.home_team }}</md-table-cell>
        <md-table-cell md-label="">{{ item.home_team_goals }}</md-table-cell>
        <md-table-cell md-label="">{{ item.away_team_goals }}</md-table-cell>
        <md-table-cell md-label="Away Team">{{ item.away_team }}</md-table-cell>
      </md-table-row>
    </md-table>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  name: "matches-table",
  data() {
    return {};
  },
  created() {
    this.getMatches();
  },
  computed: {
    ...mapGetters({
      matches: "matches"
    })
  },
  updated() {
    this.scrollToCurrentTime(this.findClosestDate(this.matches));
  },
  methods: {
    ...mapActions({
      getMatches: "getMatches"
    }),
    scrollToCurrentTime(callback) {
      let currentElems = document.getElementsByClassName(
        "md-table-cell-container"
      );
      let tempElemDate = null;
      let closestDate = callback;

      for (let i = 0; i < currentElems.length; i++) {
        tempElemDate = currentElems[i].innerHTML;
        if (tempElemDate === closestDate) {
          currentElems[i].scrollIntoView();
          break;
        }
      }
    },
    
    daysDiff(d1, d2) {
      return (
        Math.floor(d1 / 1000 / 60 / 60 / 24) -
        Math.floor(d2 / 1000 / 60 / 60 / 24)
      );
    },
    findClosestDate(matches) {
      const minDiff = 0;
      const currentTime = Date.now();
      let minDate = null;
      let diff = null;   
      for (let i = 0; i < matches.length; i++) {
        diff = this.daysDiff(new Date(matches[i]["match_date"]), currentTime);
        if (diff >= minDiff) {
          return matches[i]["match_date"];
        }
      }
    },
    matchDateFormat(date) {
      const dateInput = new Date(date);
      const dateNow = new Date(Date.now());

      if (this.daysDiff(dateInput, dateNow) == 0) {
        return "Today";
      } else if (this.daysDiff(dateInput, dateNow) == -1) {
        return "Yesterday";
      } else if (this.daysDiff(dateInput, dateNow) == 1) {
        return "Tomorrow";
      }
      return date;
    }
  }
};
</script>
