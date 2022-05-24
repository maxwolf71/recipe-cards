<template>
  <section>
    <form @submit="checkInputs">
      <h1>Se connecter</h1>
      <Label>
        Login
        <input v-model="login" name="login"
      /></Label>
      <div class="error" v-if="loginEmpty">Vous devez saisir un identifiant !</div>
      <Label>
        Mot de passe
        <input v-model="password" name="password" type="password"
      /></Label>
      <div class="error" v-if="passwordEmpty">Vous devez saisir un mot de passe !</div>
      <div class="error" v-if="loginFailed">Echec de connexion !</div>
      <button>Se connecter</button>
    </form>
  </section>
</template>

<script>

export default {
  name: "loginView",
  data() {
    return {
      login: "",
      password: "",
      loginEmpty: false,
      passwordEmpty: false,
      loginFailed: false
    };
  },
  methods: {
    async checkInputs(event) {
      event.preventDefault();
      if (this.login == '') {
        this.loginEmpty = true;
      }
      if (this.password == '') {
        this.passwordEmpty = true;
      }
      // If no errors
      if (!this.passwordEmpty && !this.loginEmpty) {
        let userData = await this.$store.state.services.user.login(this.login, this.password);

        // Verify if connected
        if(userData) { // if yes
          // store it
          this.loginFailed = false
          this.$store.state.services.storage.set('userData', userData);
          this.$router.push('profile');

          this.$store.commit('saveUser', userData);

        } else {
          this.loginFailed = true
          console.log('loginFailed');
        }
        
      }
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../assets/scss/main.scss";
form {
  background-color: lightblue;
  box-shadow: 8px 8px 12px #aaa;
  display: flex;
  flex-direction: column;
  align-items: center;
  border: $borderStyle;
  border-radius: $border-radius;
  padding: $gutter;
  margin: 5rem;

  label {
    margin-bottom: $gutter;
  }
  button {
    border-radius: 10px;
    width: 40%;
  }
}
</style>