<template>
  <v-card
    :loading="loading"
    class="mx-auto my-12"
    max-width="374"
  >

    <v-img
      height="250"
      :src="getImageUrl"
    ></v-img>

    <v-card-title>{{ recipe.title.rendered }}</v-card-title>

    <v-card-text>
      <v-row
        align="center"
        class="mx-0"
      >
        <v-rating
          :value="4"
          color="blue"
          dense
          half-increments
          readonly
          size="14"
        ></v-rating>

        <div class="grey--text ms-4">
          4.5 (413)
        </div>
      </v-row>

      <div class="my-4 text-subtitle-1">
        {{ recipe._embedded['wp:term'][1][0].name}}
      </div>

      <div v-html="recipe.excerpt.rendered"></div>
    </v-card-text>

    <v-divider class="mx-4"></v-divider>

    <v-card-title>Ingrédients</v-card-title>

    <v-card-text>
      <v-chip-group
        v-model="selection"
        active-class="deep-purple accent-4 white--text"
        column
      >
        <v-chip
          v-for="ingredient in recipe._embedded['wp:term'][0]"
          :key="ingredient.id"
        >{{ingredient.name}}</v-chip>
        
      </v-chip-group>
    </v-card-text>

    <v-card-actions>
      <v-btn
        color="deep-purple lighten-2"
        elevation="2"
        text
        @click="reserve"
      >
        Reserve
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
  export default {
    data: () => ({
      loading: false,
      selection: 1,
    }),

    props: {
      recipe: Object
    },

    methods: {
      reserve () {
        this.loading = true

        setTimeout(() => (this.loading = false), 2000)
      },
    },
    computed: {
        getImageUrl() {
            if (this.recipe._embedded['wp:featuredmedia'] && this.recipe._embedded['wp:featuredmedia'][0].media_details && this.recipe._embedded['wp:featuredmedia'][0].media_details.sizes){
                return this.recipe._embedded['wp:featuredmedia'][0].source_url;
            } else {
                return 'https://picsum.photos/seed/picsum/400/300'
            }
        }
    },
  }
</script>