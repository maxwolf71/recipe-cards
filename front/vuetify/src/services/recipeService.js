import axios from "axios";

const recipeService = {

  baseURI: 'http://localhost:8080/projet-vue/back/wordpress/wp-json/wp/v2',

  async loadRecipes() {
    const response = await axios.get(recipeService.baseURI + "/recipe?_embed=true");
    return response.data;
  },

  async loadRecipeTypes() {
    const response = await axios.get(recipeService.baseURI + "/recipe-type?_embed=true");
    return response.data;
  }
};

export default recipeService;
