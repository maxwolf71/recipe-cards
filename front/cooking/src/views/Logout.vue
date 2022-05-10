<template>
  <section>Vous êtes à présent déconnecté.</section>
</template>

<script>

export default {
  name: "LogoutView",
  created() {
    this.$store.state.services.user.logout();
    this.$store.commit('clearUser');
  }
};
</script>

<style lang="scss" scoped>
@import "../assets/scss/main.scss";
section {
  background-color: lightblue;
  color: white;
  border: $borderStyle;
  border-radius: $border-radius;
  padding: $gutter;
  margin: $gutter;
}
</style>