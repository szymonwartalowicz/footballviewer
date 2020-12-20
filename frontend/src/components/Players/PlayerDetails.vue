<template>
  <div>
    <md-card class="md-card-profile">
      <md-card-content>
        <md-list-item>
          <md-card-media>
            <img src="/assets/examples/card-media.png" alt="Photo" />
          </md-card-media>
        </md-list-item>
        <md-list>
          <md-list-item>
            <div class="md-subhead md-list-item-text">
              Name:
            </div>
            <div v-if="edit">
              <input
                v-model="editedDetails.name"
                class="md-header md-list-item-text"
              />
            </div>
            <div v-else>
              <label class="md-list-item-text">{{ playerDetails.name }}</label>
            </div>
          </md-list-item>
          <md-list-item>
            <div class="md-subhead md-list-item-text">
              Team:
            </div>
            <div v-if="edit">
              <select v-model="selectedTeamName">
                <option :value="null" disabled hidden>Choose Team</option>
                <option v-for="option in teams" :key="option.value">
                  {{ option.name }}
                </option>
              </select>
              <!-- <input
                v-model="editedDetails.team_name"
                class="md-header md-list-item-text"
              /> -->
            </div>
            <div v-else>
              <label class="md-list-item-text">{{
                playerDetails.team_name
              }}</label>
            </div>
          </md-list-item>

          <md-list-item>
            <div class="md-subhead md-list-item-text">
              Date of birth:
            </div>
            <div v-if="edit">
              <input v-model="editedDetails.dob" class="md-list-item-text" />
            </div>
            <div v-else>
              <label class="md-list-item-text">{{ this.timeStampToDate(playerDetails.dob)}}</label>
            </div>
          </md-list-item>
          <md-list-item>
            <div class="md-list-item-text">Assist:</div>
            <div>
              <label class="md-list-item-text">{{
                playerDetails.assists
              }}</label>
            </div>
          </md-list-item>
          <md-list-item>
            <div class="md-list-item-text">Red cards:</div>
            <div>
              <label class="md-list-item-text">{{
                playerDetails.cards_red
              }}</label>
            </div>
          </md-list-item>
          <md-list-item>
            <div class="md-list-item-text">Yellow cards:</div>
            <div>
              <label class="md-list-item-text">{{
                playerDetails.cards_yellow
              }}</label>
            </div>
          </md-list-item>
          <md-list-item>
            <div class="md-list-item-text">Fouls:</div>
            <div>
              <label class="md-list-item-text">{{ playerDetails.fouls }}</label>
            </div>
          </md-list-item>
          <md-list-item>
            <div class="md-list-item-text">Goals:</div>
            <div>
              <label class="md-list-item-text">{{ playerDetails.goals }}</label>
            </div>
          </md-list-item>
        </md-list>
      </md-card-content>
      <md-card-actions v-if="isAdminOn">
        <div v-if="edit" class="btn">
          <button
            @click="saveDetails"
            class="md-button md-dense md-raised md-primary"
          >
            Save
          </button>
          <button
            @click="editOff"
            class="md-button md-dense md-raised md-primary"
          >
            Cancel
          </button>
        </div>
        <div v-else class="btn">
          <button
            @click="editOn"
            class="md-button md-dense md-raised md-primary"
          >
            Edit
          </button>
        </div>
        <div class="btn">
          <button
            @click="deletePlayer"
            class="md-button md-dense md-raised md-primary"
          >
            Delete
          </button>
        </div>
      </md-card-actions>
    </md-card>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  name: "players-details",
  data() {
    return {
      selectedTeamName: null,
      editedDetails: null,
      edit: null
    };
  },
  // watch: {
  //   selectedTeamName: "saveNewTeam"
  // },
  computed: {
    ...mapGetters({
      isAdminOn: "adminOn",
      playerDetails: "playerDetails",
      teams: "teams"
    })
  },
  beforeMount() {
    this.editedDetails = JSON.parse(JSON.stringify(this.playerDetails));
  },
  methods: {
    ...mapActions({
      getPlayerDetails: "getPlayerDetails",
      updateTeamPlayers: "getPlayersByTeam"
    }),
    saveNewTeam() {
      this.editedDetails.team_name = this.selectedTeamName;
    },
    editOn() {
      this.edit = true;
    },
    editOff() {
      this.edit = false;
    },
    timeStampToDate(timestamp) {
      let newDateFormat = new Date(Number(timestamp) * 1000);
      let newDate =
        newDateFormat.getDate() +
        "-" +
        newDateFormat.getMonth() +
        "-" +
        newDateFormat.getFullYear();

      return newDate;
    },
    async saveDetails() {
      this.saveNewTeam();
      await this.$fetch("", {
        method: "PUT",
        body: JSON.stringify({ updatedDetails: this.editedDetails })
      });
      this.getPlayerDetails(this.editedDetails);
      this.editOff();
    },
    async deletePlayer() {
      if (confirm("Sure that you want to delete player details?")) {
        await this.$fetch("", {
          method: "DELETE",
          body: JSON.stringify({ deletePlayer: this.editedDetails })
        })
          .then(response => {
            console.log(response);
          })
          .catch(error => {
            console.log(error);
          });
        alert("Player details deleted.");
        this.updateTeamPlayers(this.editedDetails["team_name"]);
        this.$store.commit("updatePlayerDetails", null);
        this.$router.push({ name: "Players" });
      } else {
        alert("Delete cancelled.");
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.md-list-item {
  display: inline;
}
.btn {
  padding: 2px;
}
</style>
