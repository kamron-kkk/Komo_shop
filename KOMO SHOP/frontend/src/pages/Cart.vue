<template>
  <div>
    <h2>Cart</h2>
    <div v-if="!cart || cart.items.length===0">Your cart is empty</div>
    <div v-else>
      <div v-for="item in cart.items" :key="item.id" style="border-bottom:1px solid #eee;padding:8px">
        <div>{{ item.product.name }} x {{ item.qty }}</div>
        <div>{{ item.price }} so'm</div>
        <button @click="update(item.id, item.qty+1)">+</button>
        <button @click="update(item.id, item.qty-1)">-</button>
      </div>
      <div style="margin-top:12px">
        <router-link to="/checkout"><button>Proceed to checkout</button></router-link>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
const cart = ref(null)
async function fetchCart(){ try{ const res = await axios.get('/api/cart'); cart.value = res.data }catch(e){ console.warn(e) } }
onMounted(fetchCart)
async function update(id, qty){ try{ await axios.patch('/api/cart/items/'+id, { qty }); fetchCart(); }catch(e){console.warn(e)} }
</script>
