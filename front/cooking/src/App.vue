<template>
  <v-app>
    <Header />
    <main>
      <router-view 
        :key="$route.fullPath"/> 
    </main>
  
    <Footer />
  </v-app>
</template>

<script>
import Header from './components/Header.vue'
import Footer from './components/Footer.vue'

export default {
  name: 'App',

  components: {
    Header,
    Footer,
  },
};
</script>
