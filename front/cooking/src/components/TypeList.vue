<template>
  <select
    v-if="recipeTypes.length"
    v-model="selectedOption"
    @change="selectType"
  >
    <option value="0">Choisir un type</option>
    <option 
        v-for="type in recipeTypes" 
        :key="type.id" 
        :value="type.id">
        
        {{ type.name }}
    </option>
  </select>
</template>

<script>
import recipeService from "../services/recipeService.js";

export default {
  async created() {
    this.recipeTypes = await recipeService.loadRecipeTypes();
  },
  name: "TypeList",
  data() {
    return {
      recipeTypes: [],
      selectedOption: null,
    };
  },
  methods: {
    selectType(event) {
      event.preventDefault();
      this.$emit("recipe-type-selected", this.selectedOption);
    },
  },
};
</script>
