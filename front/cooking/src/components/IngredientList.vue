<template>
    <select 
    v-if="recipeIngredients.length" 
    v-model="selectedOption"
    @change="selectIngredient">
        <option value="0" selected>Choisir un ingrédient</option>
        <option 
            v-for="ingredient in recipeIngredients" 
            :key="ingredient.id"
            :value="ingredient.id"
        >
            {{ingredient.name}}
        </option>
    </select>
</template>

<script>

export default {
    async created() {
        this.recipeIngredients = await this.$store.state.services.recipe.loadRecipeIngredients();
    },
    name: 'IngredientsList',
    data() {
        return {
            recipeIngredients: [],
            selectedOption: null
        }
    },
    methods: {
        selectIngredient(event) {
            event.preventDefault()
            this.$emit('recipe-ingredient-selected', this.selectedOption)
        }
    }
}
</script>