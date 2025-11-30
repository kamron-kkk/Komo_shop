<template>
  <div>
    <h2>Checkout</h2>
    <form @submit.prevent="submit">
      <div><input v-model="shipping.name" placeholder="Full name" required /></div>
      <div><input v-model="shipping.phone" placeholder="Phone" required /></div>
      <div><input v-model="shipping.address" placeholder="Address" required /></div>
      <div>
        <label>Payment method</label>
        <select v-model="payment_method">
          <option value="card">Card (Stripe)</option>
          <option value="payme">Payme</option>
        </select>
      </div>
      <button type="submit">Pay</button>
    </form>
  </div>
</template>
<script setup>
import { reactive } from 'vue'
import axios from 'axios'
const shipping = reactive({ name:'', phone:'', address:'' })
let payment_method = 'card'
async function submit(){
  try {
    const res = await axios.post('/api/checkout', { shipping, payment_method, cart_id: null })
    alert('Order created. Payment link: ' + (res.data.payment_link || 'n/a'))
  } catch(e) {
    alert('Checkout failed: ' + (e.response?.data?.message || e.message))
  }
}
</script>
