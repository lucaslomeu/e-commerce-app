<script setup>
import { useCartStore } from "~/stores/cart";
import { useRouter } from "vue-router";

const config = useRuntimeConfig();
const {
  data: products,
  pending,
  error,
} = await useFetch(`${config.public.apiBase}/api/products`);

const router = useRouter();

const cart = useCartStore();

function addToCart(product) {
  cart.add(product);
}

function buyNow(product) {
  cart.add(product);
  router.push("/cart");
}

function capitalize(str) {
  if (!str) return "";
  return str.charAt(0).toUpperCase() + str.slice(1);
}
</script>

<template>
  <div>
    <main class="container">
      <h2 class="main-title">Produtos</h2>
      <ul class="product-list">
        <li
          v-for="product in filteredProducts"
          :key="product.id"
          class="product-card">
          ...
        </li>
      </ul>
      <div v-if="pending" class="loading">Carregando...</div>
      <div v-else-if="error" class="error">Erro ao carregar produtos.</div>
      <div v-else>
        <ul class="product-list">
          <li
            v-for="product in products"
            :key="product.id"
            class="product-card">
            <NuxtLink :to="`/products/${product.id}`" class="product-link">
              <img
                v-if="product.image_url"
                :src="product.image_url"
                :alt="product.name"
                class="product-image" />
              <div class="product-price-info">
                <div class="product-price-vista">
                  À vista:
                  <span class="valor"
                    >R$
                    {{
                      product.price
                        ? product.price.toLocaleString("pt-BR", {
                            minimumFractionDigits: 2,
                          })
                        : "--"
                    }}</span
                  >
                </div>
                <div class="product-price-parcela">
                  ou até 3x de
                  <span class="parcela"
                    >R$
                    {{
                      product.price
                        ? (product.price / 3).toLocaleString("pt-BR", {
                            minimumFractionDigits: 2,
                          })
                        : "--"
                    }}</span
                  >
                </div>
              </div>
            </NuxtLink>
            <div class="product-actions">
              <button
                class="cart-btn-min"
                @click="addToCart(product)"
                title="Adicionar ao carrinho">
                +
              </button>
              <button class="buy-btn-min" @click="buyNow(product)">
                Comprar
              </button>
            </div>
          </li>
        </ul>
        <div v-if="products.length === 0" class="empty">
          Nenhum produto encontrado.
        </div>
      </div>
      <NuxtLink to="/cart" class="cart-fab" title="Ver carrinho"> 🛒 </NuxtLink>
    </main>
  </div>
</template>

<style scoped>
.main-header {
  position: fixed;
  top: 0;
  width: 100vw;
  left: 0;
  background: #fff;
  border-bottom: 1px solid #ececec;
  box-shadow: 0 2px 10px 0 rgba(145, 154, 175, 0.04);
  z-index: 999;
  height: 62px;
  display: flex;
  align-items: center;
}
.header-content {
  width: 100%;
  max-width: 1120px;
  margin: 0 auto;
  padding: 0 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.main-header h1 {
  margin: 0;
  font-size: 2rem;
  color: #222;
  font-weight: 800;
  letter-spacing: 1px;
}

.container {
  max-width: 1100px;
  margin: 90px auto 40px auto;
  padding: 0 16px;
  font-family: "Segoe UI", "Arial", sans-serif;
}
.main-title {
  text-align: center;
  font-size: 1.45rem;
  font-weight: 700;
  color: #7f55b1;
  letter-spacing: 0.5px;
  margin-bottom: 24px;
  margin-top: 0;
  line-height: 1.2;
  position: relative;
  font-family: "Segoe UI", "Arial", sans-serif;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
}

.main-title .emoji {
  font-size: 1.2em;
  vertical-align: -2px;
}

.main-title::after {
  content: "";
  display: block;
  width: 100%;
  height: 2px;
  background: linear-gradient(90deg, #9b7ebd 0%, #7f55b1 100%);
  border-radius: 4px;
  margin: 9px auto 0 auto;
  opacity: 0.75;
}
.loading,
.error,
.empty {
  text-align: center;
  margin: 40px 0;
  font-size: 1.3rem;
  color: #888;
}
.error {
  color: #e53935;
}
.product-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 18px;
  list-style: none;
  padding: 0;
}
.product-card {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(31, 53, 103, 0.06);
  transition: box-shadow 0.17s, transform 0.17s;
  display: flex;
  flex-direction: column;
  padding: 16px;
  border: 1px solid #f2f2f2;
  min-width: 0;
  height: 100%;
}

.product-link {
  text-decoration: none;
  color: inherit;
  display: flex;
  flex-direction: column;
  flex: 1 1 auto;
  gap: 8px;
  min-width: 0;
  height: 100%;
  min-height: 230px;
}
.product-image {
  width: 100%;
  height: 150px;
  object-fit: contain;
  background: #f7f8fa;
  border-bottom: 1px solid #f2f2f2;
  margin: 0;
}
.product-info {
  padding: 10px 10px 6px 10px;
  display: flex;
  flex-direction: column;
  gap: 4px;
  flex: 1 1 auto;
}
.product-price-info {
  margin-top: 6px;
  display: flex;
  flex-direction: column;
  gap: 1px;
  padding: 6px 0 0 0;
}

.product-price-vista {
  font-size: 1rem;
  color: #7f55b1;
  font-weight: 700;
  padding: 0 0 1px 0;
}

.product-price-parcela {
  font-size: 0.7rem;
  color: #555;
  font-weight: 500;
  padding: 0;
}

.valor {
  color: #9b7ebd;
  font-weight: bold;
  margin-left: 3px;
}

.parcela {
  color: #7f55b1;
  font-weight: 600;
  margin-left: 3px;
}
.product-name {
  font-size: 1rem;
  margin: 0 0 2px 0;
  font-weight: 600;
  color: #23272f;
  display: -webkit-box;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
  min-height: 2.5em;
}
.product-category {
  font-size: 0.93rem;
  color: #5e626d;
  margin: 0 0 2px 0;
  letter-spacing: 0.2px;
}
.product-price {
  font-size: 1.04rem;
  color: #9b7ebd;
  font-weight: 700;
  margin: 4px 0 0 0;
}
.product-actions {
  display: flex;
  gap: 8px;
  margin-top: 8px;
}
.cart-btn-min {
  width: 38px;
  height: 38px;
  border-radius: 8px;
  border: 2px solid #9b7ebd;
  background: transparent;
  color: #9b7ebd;
  font-size: 1.5rem;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.17s, color 0.17s, border 0.17s;
}
.cart-btn-min:hover {
  color: #7f55b1;
  border-color: #7f55b1;
}

.buy-btn-min {
  flex: 1 1 0;
  border: none;
  border-radius: 7px;
  background: #9b7ebd;
  color: #fff;
  padding: 0 22px;
  height: 38px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.17s, transform 0.15s;
}
.buy-btn-min:hover {
  background: #7f55b1;
  transform: scale(1.04);
}
@media (max-width: 600px) {
  .main-header {
    height: 54px;
  }
  .header-content {
    padding: 0 8px;
  }
  .container {
    margin: 70px auto 30px auto;
    padding: 0 6px;
  }
  .cart-fab {
    bottom: 18px;
    right: 18px;
    width: 48px;
    height: 48px;
    font-size: 1.5rem;
  }
}
</style>
