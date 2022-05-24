<template>
  <div>
    <TermList
      taxonomy="recipe-type"
      label="Choisir par type"
      v-on:recipe-term-selected="handleTermSelection"
    />
    <TermList
      taxonomy="ingredient"
      label="Choisir par ingrédient"
      v-on:recipe-term-selected="handleTermSelection"
    />
    <TermList
      taxonomy="difficulty"
      label="Choisir par difficulté"
      v-on:recipe-term-selected="handleTermSelection"
    />
  </div>
</template>

<script>
import TermList from "../components/TermList.vue";
import recipeService from "../services/recipeService.js";

export default {
  name: "FiltersView",

  components: {
    TermList,
  },
  data() {
    return {
      filters: {},
    };
  },

  methods: {
    async handleTermSelection(data) {
      if (parseInt(data.termId)) { // convert string to number
        this.$emit(
          "recipe-type-term", // name of event
          data //info in the event
        );

        this.filters[data.taxonomy] = data.termId

      } else {
        this.filters[data.taxonomy] = false
      }
      
      const recipes = await recipeService.getRecipesByTerms(
          this.filters
        );
        this.$emit("recipes-loaded", recipes);
    },
  },
};
</script>

