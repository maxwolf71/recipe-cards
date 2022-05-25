<template>
  <section>
    <form @submit="checkInputs">
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
  flex-flow: column wrap;
  align-items: center;
  border-radius: $border-radius;
  padding: $gutter;
  margin: 5rem auto;
  width: 450px;

  label {
    color: #1976d2;
    width: 70%;
    display: flex;
    justify-content: space-between;
  
    input {
      border: 1px solid white;
      border-radius: 15px;
      margin-bottom: 15px;
      margin-left: 15px;
      padding: 5px;
    }
  }
  button {
    color: $dark-blue;
    border-radius: 10px;
    width: 40%;
    background-color: white;
    margin-top: 40px;
    padding: $gutter;
  }
}
</style>