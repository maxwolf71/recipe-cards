<template>
    <section>
        <h3>Poster un commentaire</h3>
        <form @submit="saveComment">
            <textarea v-model="comment"></textarea>
            <div class="error" v-if="userDisconnected">
                Vous devez vous connecter
            </div>
            <button>Envoyer</button>
        </form>
    </section>
</template>

<script>
export default {
    name: 'CommentForm',
    data() {
        return {
            comment: '',
            userDisconnected: false
        }
    },
    props: {
        recipe: Object
    },
    methods: {
        saveComment(event) {
            event.preventDefault();
            if(this.$store.state.user) { // send comment only if user is connnected
                this.$store.state.services.recipe.saveComment(
                    this.recipe.id,
                    this.comment,
                ); // api call to save the comment
                this.userDisconnected = false
            } else{
                this.userDisconnected = true
            }
        }
    }
}
</script>