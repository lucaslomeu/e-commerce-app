<script setup>
import Header from "~/components/Header.vue";
import Footer from "~/components/Footer.vue";

import { onMounted } from "vue";
import { useCartStore } from "~/stores/cart";

onMounted(() => {
  useCartStore().loadFromLocalStorage();
});
</script>

<template>
  <Header />
  <main class="main-content">
    <NuxtPage />
  </main>
  <Footer />
</template>

<style scoped>
.main-content {
  padding-top: 70px;
  min-height: 80vh;
}
</style>
