import Vue from 'vue'
import App from './App.vue'

import './assets/scss/main.scss';
import router from './plugins/router'
import store from './plugins/vuex'
import vuetify from './plugins/vuetify'

Vue.config.productionTip = false

new Vue({
  router,
  store,
  vuetify,
  render: h => h(App)
}).$mount('#app')
