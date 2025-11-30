<template>
  <div>
    <h2>Product</h2>
    <div v-if="!product">Loading...</div>
    <div v-else>
      <h3>{{ product.name }}</h3>
      <p v-html="product.description"></p>
      <div>{{ product.price }}</div>
      <button @click="addToCart">Add to cart</button>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'
const route = useRoute()
const product = ref(null)
onMounted(async ()=> {
  try {
    const res = await axios.get('/api/products/'+route.params.slug)
    product.value = res.data
  } catch(e) { console.warn(e) }
})
async function addToCart() {
  try {
    await axios.post('/api/cart/items', { product_id: product.value.id, qty:1 })
    alert('Added')
  } catch(e) { alert('Error') }
}
</script>
