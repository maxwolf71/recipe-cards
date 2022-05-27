<template>
  <section>
    <form @submit="checkInputs">
      <h1>Inscription</h1>
      <label>
        Nom d'utilisateur
        <input v-model="username" name="username" />
      </label>
      <div class="error" v-if="usernameEmpty">
        Vous devez saisir un nom d'utilisateur
      </div>

      <label>
        Email
        <input v-model="email" name="email" />
      </label>
      <div class="error" v-if="emailEmpty">
        Vous devez saisir une adresse e-mail
      </div>

      <label>
        Mot de passe
        <input v-model="password" name="password" type="password" />
      </label>
      <div class="error" v-if="passwordEmpty">
        Vous devez saisir un mot de passe
      </div>
      
      <div class="error" v-if="registerFailed">Echec d'enregistrement</div>

      <button>S'enregister</button>
    </form>
  </section>
</template>

<script>
import userService from '../services/userService';
export default {
  name: "RegisterView",
  data() {
    return {
      username: '',
      email: "",
      password: "",
      usernameEmpty: false,
      emailEmpty: false,
      passwordEmpty: false,
      signInFailed: false,
      registerFailed : false
    };
  },
  methods: {
    async checkInputs(event) {
      event.preventDefault();

       if (this.username == "") {
        this.usernameEmpty = true;
      } else {
          this.usernameEmpty = false;
      }

      if (this.email == "") {
        this.emailEmpty = true;
      } else {
          this.emailEmpty = false;
      }

      if (this.password == "") {
        this.passwordEmpty = true;
      }
      else {
          this.passwordEmpty = false;
      }
      // If no errors -> call to the api
      if (!this.emailEmpty && !this.passwordEmpty) {
        let result = await userService.register(
          this.username,
          this.email,
          this.password
        );

        if(result) {
          if(result.success == true) {
            this.$router.push('register-success');
            // exit the function
            return;
          }
          // registration failed
          this.registerFailed = true
        }
      }
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../assets/scss/main.scss";
form {
  background-color: $light-blue;
  box-shadow: 8px 8px 12px #aaa;
  display: flex;
  flex-flow: column wrap;
  align-items: center;
  border-radius: $border-radius;
  padding: $gutter;
  margin: 5rem auto;
  width: 550px;

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