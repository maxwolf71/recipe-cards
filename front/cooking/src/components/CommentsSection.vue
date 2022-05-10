<template>
  <section>
    <CommentForm v-if="user" :recipe="recipe" />
    <CommentCard 
      :comment="comment"
      v-for="comment in comments" 
      :key="comment.id" 
    />
  </section>
</template>

<script>
import CommentForm from "../components/CommentForm";
import CommentCard from "../components/CommentCard";

export default {
  name: "CommentsSection",
  async created() {
    if (this.$store.state.comments) {
      // is there data in store ?
      this.comments = this.$store.state.comments; // yes then retrieve data
    } else {
      // otherwise call api
      this.comments = await this.$store.state.services.recipe.loadComments();
      this.$store.commit("saveComment", this.comments);
    }
  },
  data() {
    return {
      comments: [],
    };
  },
  components: {
    CommentForm,
    CommentCard,
  },
  computed: {
    user() {
      return this.$store.state.user;
    },
  },
  props: {
    recipe: Object,
  },
};
</script>