import Vue from "vue";
import Vuex from "vuex";
Vue.use(Vuex);

import userService from "@/services/userService";
import recipeService from "@/services/recipeService";
import storage from './storage'

const store = new Vuex.Store({
  state: {
    user: null,
    recipes: null,
    recipeIngredients: [],
    termsList: {},
    services: {
      user: userService,
      recipe: recipeService,
      storage: storage
    },
  },
  mutations: {
    saveRecipe(state, recipes) {
      state.recipes = recipes;
    },

    saveComment(state, comments) {
      state.comments = comments;
    },

    saveTermsList(state, data) {
      state.termsList[data.taxonomy] = data.terms;
    },

    saveUser(state, user) {
      state.user = user;
    },

    clearUser(state){
      state.user = false;
    },
  },
});

export default store;
