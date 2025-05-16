<template>
  <header class="main-header">
    <div class="header-content">
      <NuxtLink to="/" class="logo">🛒 LomeuStore</NuxtLink>
      <!-- Adicione links de navegação, se quiser -->
    </div>
  </header>
</template>

<style scoped>
.main-header {
  position: fixed;
  top: 0;
  width: 100vw;
  background: #fff;
  border-bottom: 1px solid #ececec;
  box-shadow: 0 2px 10px 0 rgba(145, 154, 175, 0.05);
  z-index: 100;
  height: 60px;
  display: flex;
  align-items: center;
}
.header-content {
  max-width: 1120px;
  margin: 0 auto;
  width: 100%;
  padding: 0 20px;
  display: flex;
  align-items: center;
}
.logo {
  font-size: 1.5rem;
  font-weight: bold;
  color: #9b7ebd;
  text-decoration: none;
}
</style>
