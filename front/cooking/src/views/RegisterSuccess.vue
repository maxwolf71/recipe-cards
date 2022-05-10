<template>
  <section>
    <h1>Registration successful</h1>
    <div>
      <router-link :to="{
        name: 'login'}"
        >Se connecter</router-link> 
    </div>
  </section>
</template>

<script>

export default {
  name: "RegisterSuccess",
};
</script>
