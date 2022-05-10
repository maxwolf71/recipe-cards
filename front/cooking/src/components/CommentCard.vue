<template>
  <div>
    <article class="card" v-if="recipeId == commentRecipeId">
      <h3>Commentaire:</h3>
      <div class="card__content" v-html="comment.content.rendered"></div>
    </article>
  </div>
</template>

<script>
export default {
  name: "CommentCard",
  data() {
    return {
      recipeId: this.$route.params.id,
      commentRecipeId: this.comment.post
    };
  },
  props: {
    comment: Object,
  },
};
</script>