<template>
    <section v-if="isUserConnected">
        <h1>Profile</h1>
        <div>
            {{ user.user_display_name }}
        </div>
    </section>
</template>

<script>
import userService from '../services/userService'

export default {
    name: 'ProfileView',
    computed: {
        user() {
            return this.$store.state.user;
        }
    },
    data() {
        return {
            isUserConnected: false
        }
    },
    async created() {
        const isTokenValid = await userService.isLoggedIn();
        if(!isTokenValid) {
            this.$router.push('login'); // if invalid token -> back to home page
        } else {
            this.isUserConnected = true;
        }
    }
}
</script>

<style lang="scss" scoped>
@import "../assets/scss/main.scss";

section {
    margin-top: 10rem;
    h1 {
        font-size: 2rem;
    }
    div {
        font-size: 2.5rem;
    }
}

</style>