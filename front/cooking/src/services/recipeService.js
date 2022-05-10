import axios from "axios";
import storage from "@/plugins/storage";

const recipeService = {
  baseURI: process.env.VUE_APP_WORDPRESS_API_URL + "/wp/v2", // for GET
  cookingBaseURI: process.env.VUE_APP_WORDPRESS_API_URL + "/cooking/v1", // for POST

  async loadRecipes() {
    const response = await axios.get(
      recipeService.baseURI + "/recipe?_embed=true"
    );
    return response.data;
  },
  async loadRecipeTypes() {
    const response = await axios.get(recipeService.baseURI + "/recipe-type");
    return response.data;
  },
  async loadRecipeIngredients() {
    const response = await axios.get(recipeService.baseURI + "/ingredient");
    return response.data;
  },

  async getRecipeById(recipeId) {
    const response = await axios.get(
      recipeService.baseURI + "/recipe/" + recipeId + "?_embed=true"
    );
    return response.data;
  },
  async loadTerms(taxonomy) {
    const response = await axios.get(recipeService.baseURI + "/" + taxonomy);
    return response.data;
  },
  async getRecipesByTerm(taxonomy, termId) {
    const response = await axios.get(
      recipeService.baseURI + "/recipe?_embed=true&" + taxonomy + "=" + termId
    );
    return response.data;
  },
  async getRecipesByTerms(filters) {
    let url = recipeService.baseURI + "/recipe?_embed=true&";
    for (let taxonomy in filters) {
      let termId = filters[taxonomy];
      if (termId) {
        url += "&" + taxonomy + "=" + termId;
      }
    }
    const response = await axios.get(url);
    return response.data;
  },
  async saveRecipe(title, type, description, ingredients, imageId) {
    const userData = storage.get("userData");

    if (userData != null) {
      // is userData empty ?
      const token = userData.token;

      if (token) {
        const options = {
          headers: {
            Authorization: "Bearer" + token,
          },
        };

        const result = await axios
          .post(
            recipeService.cookingBaseURI + "/recipe-save",
            {
              title: title,
              type: type,
              description: description,
              ingredients: ingredients,
              imageId: imageId,
            },
            options
          )
          .catch((error) => {
            // if invalid token
            return false, console.log(error);
          });
        return result;
      }
    }
    return false;
  },

  async saveComment(recipeId, comment) {
    const userData = storage.get("userData");

    if (userData != null) { // is there userData ?
      
      const token = userData.token;

      if (token) {
        const options = {
          headers: {
            Authorization: "Bearer" + token,
          },
        };

        const result = await axios
          .post(
            recipeService.cookingBaseURI + "/comment-save",
            {
              recipeId: recipeId,
              comment: comment,
            },
            options
          )
          .catch((error) => {
            // if invalid token
            return false, console.log(error);
          });
        return result;
      }
    }
    return false;
  },
  async loadComments() {
    const response = await axios.get(
      recipeService.baseURI + "/comments?_embed=true"
    );
    return response.data;
  },
  async getCommentById(commentId) {
    const response = await axios.get(
      recipeService.baseURI + "/comments/" + commentId + "?_embed=true"
    );
    return response.data;
  },

  async uploadImage(image) {
    let formData = new FormData(); // creates à "fake" form

    formData.append("image", image);

    const userData = storage.get("userData");
    const token = userData.token;

    const result = await axios.post(
      recipeService.cookingBaseURI + "/upload-image",
      formData,
      {
        headers: {
          "Content-Type": "multipart/form-data",
          Authorization: "Bearer " + token,
        },
      }
    );
    return result.data;
  },
};

export default recipeService;
