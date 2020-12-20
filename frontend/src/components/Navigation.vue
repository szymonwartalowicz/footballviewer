<template>
  <div>
    <nav>
      <router-link v-for="routes in links"
      v-bind:key="routes.id"
      :to="`${routes.page}`">{{routes.text}}</router-link>
    </nav>
  </div>
</template>

<script>
export default {
  name: 'Navigation',
  data() {
    return {
        links: [
         {
           id: 0,
           text: 'Matches',
           page:'/Matches'
         },
         {
           id: 1,
           text: 'Tables',
           page:'/Tables'
         },
         {
           id: 2,
           text: 'Players',
           page:'/Players'
        },
          {
           id: 3,
           text: 'Login',
           page:'/Login'
       }
       ]
    }
  }
}
</script>
<style>
nav {
    border:solid;
    display: inline;
}
</style>
