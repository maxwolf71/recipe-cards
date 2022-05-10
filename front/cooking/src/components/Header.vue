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
    top: 0;
    left: 0;
    width: 100%;
    background-color: $light-blue;;
    display: flex;
    justify-content: space-around;
    align-items: center;
    margin-bottom: $gutter;
    padding: $gutter;
}
</style>