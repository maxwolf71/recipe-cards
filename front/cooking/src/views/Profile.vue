<template>
    <section v-if="isUserConnected">
        <h1>Profile</h1>
        <div>
            User info
        </div>
    </section>
</template>

<script>
import userService from '../services/userService'

export default {
    data() {
        return {
            isUserConnected: false
        }
    },

    name: 'ProfileView',
    
    async created() {
        const isTokenValid = await userService.isLoggedIn();
        if(!isTokenValid) {
            // if invalid token -> back to home page
            this.$router.push('login');
        } else {
            this.isUserConnected = true;        
        }
    }
}
</script>