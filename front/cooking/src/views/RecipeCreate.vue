<template>
  <section v-if="isUserConnected">
    <h1>Nouvelle Recette</h1>
    <form @submit="saveRecipe">
      <div>
        <label> Titre de la recette <input v-model="title" /> </label>
      </div>

      <div>
        <label> 
          Image d'illustration <input type="file" @change="uploadImage" /> 
          <img v-if="image" :src="image" />
          <input v-model="imageId" type="hidden" />
        </label>
      </div>

      <div>
        <div v-for="type in types" :key="type.id">
          <label> <input type="radio" name="type" :value="type.id" v-model="selectedType" /> {{ type.name }} </label>
        </div>
      </div>

      <div>
        <label for="">
          Description <textarea v-model="description"></textarea>
        </label>
      </div>

      <div>
        <div v-for="ingredient in ingredients" :key="ingredient.id">
          <label> <input type="checkbox" :value="ingredient.id" v-model="selectedIngredients" /> {{ ingredient.name }} </label>
        </div>
      </div>

      <div>
          <button>Enregistrer</button>
      </div>
    </form>
  </section>
</template>

<script>

import userService from "../services/userService";

export default {
  name: "RecipeCreate",
  data() {
    return {
      isUserConnected: false,
      title: "",
      description: "",
      ingredients: [],
      types: [],
      selectedType: null,
      selectedIngredients: [],
      createFail: false,
      image: null,
      imageId: null
    };
  },
  async created() {
    const isTokenValid = await userService.isLoggedIn();
    if (!isTokenValid) {
      this.$router.push("login"); // if invalid token -> back to home page
    } else {
      this.isUserConnected = true;
    }

    this.loadIngredients();
    this.loadType();
  },
  methods: {
    async loadIngredients() {
      this.ingredients = await this.$store.state.services.recipe.loadRecipeIngredients();
    },
    async loadType() {
      this.types = await this.$store.state.services.recipe.loadRecipeTypes();
    },
    async saveRecipe(event) {
        event.preventDefault();
        const result = await this.$store.state.services.recipe.saveRecipe(
            this.title,
            this.selectedType,
            this.description,
            this.selectedIngredients,
            this.imageId
        );

        if(result) {
          this.$router.push('recipe-create-success')
        }
        else {
          this.createFail = true
        }
    },
    async uploadImage(event) {
      event.preventDefault();

      const image = event.currentTarget.files[0];

      let imageResult = await this.$store.state.services.recipe.uploadImage(image);

      this.image = imageResult.image.url
      this.imageId = imageResult.image.id
    }
  }
};
</script>

<style>
img {
  width: 10rem;
}
</style>