import Vue from 'vue'
import VueRouter from 'vue-router'

import RecipeList from '../views/RecipeList.vue'
import Recipe from '../views/Recipe.vue'
import Login from '../views/Login.vue'
import Logout from '../views/Logout.vue'
import Profile from '../views/Profile.vue'
import Register from '../views/Register.vue'
import RegisterSuccess from '../views/RegisterSuccess.vue'
import RecipeCreate from '../views/RecipeCreate.vue'
import RecipeCreateSuccess from '../views/RecipeCreateSuccess.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: RecipeList
  },
  {
    path: '/recipe/:id',
    name: 'recipe',
    component: Recipe
  },
  {
    path: '/login',
    name: 'login',
    component: Login
  },
  {
    path: '/logout',
    name: 'logout',
    component: Logout
  },
  {
    path: '/profile',
    name: 'profile',
    component: Profile
  },
  {
    path: '/register',
    name: 'register',
    component: Register
  },
  {
    path: '/register-success',
    name: 'register-success',
    component: RegisterSuccess
  },
  {
    path: '/recipe-create',
    name: 'recipe-create',
    component: RecipeCreate
  },
  {
    path: '/recipe-create-success',
    name: 'recipe-create-success',
    component: RecipeCreateSuccess
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
