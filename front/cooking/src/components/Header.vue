<template>
    <header>
        <router-link 
            :to="{
                name: 'home',
            }">
                <span>10 minutes </span>
                <span>O' four</span>
            </router-link>

        <router-link 
            v-if="user"
            :to="{
                name: 'profile',
            }">
                {{ user.user_display_name }}
            </router-link>

        <router-link 
            v-if="!user"
            :to="{
                name: 'login',
            }">
                Connexion
            </router-link>
    </header>
</template>

<script>
export default {
    name: 'HeaderWiew',
    computed: {
        user() {
            return this.$store.state.user;
        }
    }
}
</script>

<style scoped lang=scss>
@import "../assets/scss/main.scss";
header {
    position: fixed;
    width: 100%;
    z-index: 1;
    background-color: $light-blue;;
    display: flex;
    justify-content: space-around;
    align-items: center;
    padding: $gutter;
}
</style>