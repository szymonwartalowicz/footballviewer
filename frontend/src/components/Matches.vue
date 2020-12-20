<template>
  <div>
    <h1>Matches</h1>
    <table>
        <tr class="result" :key="item.id" v-for="item of matches['data']">
            <td>
                <tr>
                    <td v-html="item.match_date"></td>
                </tr>
                <tr>
                <td>
                    <tr>
                        <td v-html="item.home"></td><td v-html="item.home_team_goals"></td>
                    </tr>
                    <tr>
                        <td v-html="item.away"></td><td v-html="item.away_team_goals"></td>
                    </tr>
                </td>
                    <td>{{  getStatus(item.match_date) }}</td>
                </tr>
            </td>
        </tr>
    </table>

  </div>
</template>

<script>
export default {
  name: 'Matches', //this is the name of the component
  data () {
      return {
          matches: [],
          error: null,
      }
  },
  mounted() {
      this.getMatches();
  },
  beforeRouteUpdate(to, from, next) {
      this.getMatches();
      next();
  },
  methods: {
    getMatches() {
            fetch('http://localhost/footballapi/index.php?matches_by_league=Premier league&matches_by_season=2020/2021')
                .then((resp) => resp.json())
                .then((data) => {
                    this.matches = data;
                } )


    },
    getStatus(date) {
        let today = new Date();

        date = date.replace(/\D/g, " ");

        let dtcomps = date.split(" ");

        let convdt = new Date(Date.UTC(dtcomps[0], dtcomps[1], dtcomps[2], dtcomps[3], dtcomps[4], dtcomps[5]));

        if(today.getTime() > convdt.getTime()){
            return "Koniec"
        }
        return date;
    }
  },

    }

</script>
<style>
table,td {
    border: solid;
}
</style>
