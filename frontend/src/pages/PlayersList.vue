<template>
  <div class="content">
    <div class="md-layout">
      <div
        class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100"
      >
        <md-card>
          <md-card-header data-background-color="green">
            <h4 class="title">Players</h4>
          </md-card-header>
          <md-card-content>
            <div class="md-layout-item md-medium-size-100 md-size-33">
              <SelectTeam
                :teams="teams"
                v-on:selectedTeam="updateTeamPlayers($event)"
              ></SelectTeam>
            </div>
            <div class="md-layout">
              <div
                class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-33"
              >
                <DisplayPlayers
                  table-header-color="green"
                  :players="teamPlayers"
                  v-on:getPlayer="updatePlayerName($event)"
                ></DisplayPlayers>
              </div>
              <div
                v-if="playerDetails != null"
                class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-66"
              >
                <PlayerDetails :playerDetails="playerDetails"></PlayerDetails>
              </div>
            </div>
          </md-card-content>
        </md-card>
      </div>
    </div>
  </div>
</template>

<script>
import { PlayerDetails, DisplayPlayers, SelectTeam } from "@/components";
import { mapActions, mapGetters } from "vuex";

export default {
  components: {
    PlayerDetails,
    DisplayPlayers,
    SelectTeam
  },
  data() {
    return {
      playerName: null
    };
  },
  computed: {
    ...mapGetters({
      teamPlayers: "teamPlayers",
      playerDetails: "playerDetails",
      teams: "teams"
    })
  },
  beforeMount() {
    this.getTeams();
  },
  methods: {
    ...mapActions({
      getTeams: "getTeams",
      updatePlayerName: "getPlayerDetails",
      updateTeamPlayers: "getPlayersByTeam"
    })
  }
};
</script>
