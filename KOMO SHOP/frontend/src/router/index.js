import { createRouter, createWebHistory } from 'vue-router'
import Home from '../pages/Home.vue'
import Catalog from '../pages/Catalog.vue'
import Product from '../pages/Product.vue'
import Cart from '../pages/Cart.vue'
import Checkout from '../pages/Checkout.vue'
import Profile from '../pages/Profile.vue'
import Admin from '../pages/Admin.vue'

const routes = [
  { path: '/', component: Home },
  { path: '/catalog', component: Catalog },
  { path: '/product/:slug', component: Product },
  { path: '/cart', component: Cart },
  { path: '/checkout', component: Checkout },
  { path: '/profile', component: Profile },
  { path: '/admin', component: Admin },
]
export default createRouter({ history: createWebHistory(), routes })
