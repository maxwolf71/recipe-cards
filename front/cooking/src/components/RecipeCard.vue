<template>
    <article class="card">
        <img :src="getImageUrl">
        <h2>{{recipe.title.rendered}}</h2>
        <div class="card__content" v-html="recipe.excerpt.rendered">
        </div>
        <div>
            <router-link 
            :to="{
                name: 'recipe',
                params: {
                    id: recipe.id
                }
            }">
                Lire la suite
            </router-link>
        </div>
    </article>
</template>

<script>
export default {
    name: 'RecipeCard',
    props: {
        recipe: Object,
    },

    computed: {
        getImageUrl() {
            if (this.recipe._embedded['wp:featuredmedia']){
                return this.recipe._embedded['wp:featuredmedia'][0].source_url;
            } else {
                return 'https://picsum.photos/seed/picsum/400/300'
            }
        }
    }
}
</script>

<style scoped lang=scss>


</style>