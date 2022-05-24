<template>
  <v-card :loading="loading" class="mx-auto my-12" max-width="374">
    <v-img height="250" :src="getImageUrl"></v-img>
    <v-card-title>{{ recipe.title.rendered }}</v-card-title>
    <v-card-text>
      <div class="my-4 text-subtitle-1">
        {{ recipe._embedded["wp:term"][1][0].name }}
      </div>

      <div v-html="recipe.excerpt.rendered"></div>
    </v-card-text>
    <v-card-text>
      <v-chip-group
        v-model="selection"
        active-class="deep-purple accent-4 white--text"
        column
      >
        <v-chip
          v-for="ingredient in recipe._embedded['wp:term'][0]"
          :key="ingredient.id"
          >{{ ingredient.name }}</v-chip
        >
      </v-chip-group>
      <div>
        <router-link
          :to="{
            name: 'recipe',
            params: {
              id: recipe.id,
            },
          }"
        >
          Lire la suite
        </router-link>
      </div>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  name: "RecipeCard",
  data() {
    return {
      selection: 1,
      loading: false,
    };
  },
  props: {
    recipe: Object,
  },

  computed: {
    getImageUrl() {
      if (this.recipe._embedded["wp:featuredmedia"]) {
        return this.recipe._embedded["wp:featuredmedia"][0].source_url;
      } else {
        return "https://picsum.photos/seed/picsum/400/300";
      }
    },
  },
};
</script>