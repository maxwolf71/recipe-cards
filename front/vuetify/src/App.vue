<template>
  <v-app>
    <CookingRecipeList />
  </v-app>
</template>

<script>
import CookingRecipeList from './components/CookingRecipeList.vue';

export default {
  name: 'App',

  components: {
    CookingRecipeList
  },

  data: () => ({
    //
  }),
};
</script>

<style>
li {
  list-style: none;
}
</style>
