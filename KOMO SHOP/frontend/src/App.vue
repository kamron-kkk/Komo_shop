<template>
  <div>
    <nav style="padding:12px;border-bottom:1px solid #eee">
      <a href="/">KOMO SHOP</a> |
      <router-link to="/catalog">Catalog</router-link> |
      <router-link to="/cart">Cart</router-link> |
      <router-link to="/profile">Profile</router-link> |
      <router-link to="/admin">Admin</router-link>
    </nav>
    <main style="padding:16px">
      <router-view />
    </main>
  </div>
</template>
