<template>
  <div>
    <h2>Catalog</h2>
    <div v-if="products.length===0">No products (seed DB)</div>
    <div v-for="p in products" :key="p.id" style="border:1px solid #ddd;padding:8px;margin:8px 0">
      <router-link :to="'/product/'+p.slug">{{ p.name }}</router-link>
      <div>{{ p.price }} so'm</div>
      <button @click="addToCart(p.id)">Add to cart</button>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
const products = ref([])
onMounted(async ()=> {
  try {
    const res = await axios.get('/api/products')
    products.value = res.data.data || []
  } catch(e) { console.warn('API error', e) }
})
async function addToCart(productId) {
  try {
    await axios.post('/api/cart/items', { product_id: productId, qty: 1 })
    alert('Added to cart')
  } catch(e) { alert('Error adding to cart') }
}
</script>
