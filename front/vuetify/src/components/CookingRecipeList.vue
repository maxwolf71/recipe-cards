<template>
    <section>
        <h1>Recettes</h1>
        <ul>
            <li
                v-for="recipe in recipes"
                :key="recipe.id">

                <CardView :recipe="recipe"/>
            </li>
        </ul>
    </section>
</template>

<script>
import CardView  from './CardView.vue'
import recipeService  from '../services/recipeService.js'

export default {
    name: 'CookingRecipeList',
    async created() {
        this.recipes = await recipeService.loadRecipes();
    },
    data() {
        return {
            recipes: [],
        }
    },
    components: {
        CardView
    },

}
</script>
