<template>
    <footer>
        <nav>
            <router-link 
                :to="{
                    name: 'home'
                }"
            >
                Liste des recettes</router-link>
                
            <router-link 
                v-if="user" 
                :to="{
                    name: 'recipe-create'
                }"
            >
                Nouvelle recette</router-link>

            <router-link 
                v-if="!user"
                :to="{
                    name: 'register'
                }"
                >
                Inscription
            </router-link>

            <router-link 
                v-if="user"
                :to="{
                    name: 'logout'
                }"
                >
                Déconnexion
            </router-link>

        </nav>
    </footer>
</template>

<script>
export default {
    name: 'FooterView',
    computed: {
        user() {
            return this.$store.state.user;
        }
    }
}
</script>

<style lang="scss" scoped>
@import "../assets/scss/main.scss";
nav {
    background-color: $light-blue;
    padding: $gutter;
    width: 100%;
    position: fixed;
    bottom: 0;
    left: 0;
    display: flex;
    justify-content: space-around;
}
</style>