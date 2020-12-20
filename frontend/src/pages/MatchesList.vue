<template>
  <div class="content">
    <div class="md-layout">
      <div
        class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100"
      >
        <md-card>
          <md-card-header data-background-color="green">
            <h4 class="title">Matches</h4>
            <p class="category"></p>
          </md-card-header>
          <md-card-content>
            <Matches table-header-color="green"></Matches>
          </md-card-content>
        </md-card>
      </div>
    </div>
  </div>
</template>

<script>
import { Matches } from "@/components";

export default {
  components: {
    Matches
  }
};
</script>
