<script setup>
const route = useRoute();
const router = useRouter();

const config = useRuntimeConfig();
const productId = route.params.id;

const {
  data: product,
  pending,
  error,
} = await useFetch(`${config.public.apiBase}/api/products/${productId}`);

const {
  data: allProducts,
  pending: pendingAll,
  error: errorAll,
} = await useFetch(`${config.public.apiBase}/api/products`);

function capitalize(str) {
  if (!str) return "";
  return str.charAt(0).toUpperCase() + str.slice(1);
}
</script>

<template>
  <div class="product-detail-container">
    <button class="back-btn" @click="router.back()">← Voltar</button>
    <div v-if="pending" class="loading">Carregando produto...</div>
    <div v-else-if="error || !product">
      <div class="error">Produto não encontrado.</div>
    </div>
    <div v-else class="product-detail-card">
      <img
        v-if="product.image_url"
        :src="product.image_url"
        :alt="product.name"
        class="detail-image" />
      <div class="detail-info">
        <h1>{{ product.name }}</h1>
        <p class="category">Categoria: {{ capitalize(product.category) }}</p>
        <p class="price">
          <b
            >R$
            {{
              product.price
                ? product.price.toLocaleString("pt-BR", {
                    minimumFractionDigits: 2,
                  })
                : "--"
            }}</b
          >
        </p>
        <p class="description">{{ product.description }}</p>
      </div>
    </div>

    <div class="recommendation-section">
      <h3>Você também pode gostar:</h3>
      <div v-if="pendingAll" class="loading">Carregando recomendações...</div>
      <div v-else>
        <ul class="recommendation-list">
          <li
            v-for="p in allProducts
              .filter((p) => p.id != productId)
              .slice(0, 4)"
            :key="p.id"
            class="recommendation-card">
            <NuxtLink :to="`/products/${p.id}`" class="recommendation-link">
              <img
                v-if="p.image_url"
                :src="p.image_url"
                :alt="p.name"
                class="recommendation-img" />
              <div class="recommendation-info">
                <div class="rec-name">{{ p.name }}</div>
                <div class="rec-cat">{{ capitalize(p.category) }}</div>
                <div class="rec-price">
                  R$
                  {{
                    p.price
                      ? p.price.toLocaleString("pt-BR", {
                          minimumFractionDigits: 2,
                        })
                      : "--"
                  }}
                </div>
              </div>
            </NuxtLink>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<style scoped>
.product-detail-container {
  max-width: 850px;
  margin: 40px auto;
  padding: 18px;
  font-family: "Segoe UI", Arial, sans-serif;
}
.back-btn {
  background: none;
  border: none;
  color: #219150;
  font-size: 1rem;
  margin-bottom: 18px;
  cursor: pointer;
  font-weight: bold;
  transition: color 0.2s;
}
.back-btn:hover {
  color: #145a32;
}
.product-detail-card {
  display: flex;
  gap: 32px;
  background: #fff;
  border-radius: 14px;
  box-shadow: 0 4px 24px 0 rgba(31, 53, 103, 0.08);
  padding: 28px;
  margin-bottom: 42px;
}
.detail-image {
  width: 240px;
  height: 240px;
  object-fit: contain;
  border-radius: 8px;
  background: #f6f8fa;
  border: 1px solid #f0f0f0;
}
.detail-info {
  flex: 1 1 0%;
  display: flex;
  flex-direction: column;
  gap: 16px;
}
.detail-info h1 {
  font-size: 2rem;
  margin: 0 0 6px 0;
  font-weight: bold;
  color: #24292f;
}
.category {
  color: #626262;
  font-size: 1.05rem;
  margin-bottom: 10px;
  text-transform: capitalize;
}
.price {
  color: #27ae60;
  font-size: 1.35rem;
  font-weight: bold;
}
.description {
  color: #333;
  margin-top: 14px;
  font-size: 1.13rem;
}

.recommendation-section {
  margin-top: 40px;
}
.recommendation-section h3 {
  margin-bottom: 20px;
  font-size: 1.3rem;
  color: #24292f;
  font-weight: 600;
}
.recommendation-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
  gap: 20px;
  list-style: none;
  padding: 0;
}
.recommendation-card {
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 2px 8px 0 rgba(39, 174, 96, 0.07);
  overflow: hidden;
  transition: box-shadow 0.18s, transform 0.18s;
}
.recommendation-link {
  display: flex;
  flex-direction: column;
  text-decoration: none;
  color: inherit;
  height: 100%;
  align-items: center;
  padding: 10px 10px 14px 10px;
}
.recommendation-img {
  width: 80px;
  height: 80px;
  object-fit: contain;
  margin-bottom: 12px;
  background: #f6f8fa;
}
.recommendation-info {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 3px;
  text-align: center;
}
.rec-name {
  font-size: 1rem;
  font-weight: 600;
  color: #222;
  margin-bottom: 2px;
}
.rec-cat {
  font-size: 0.98rem;
  color: #888;
  margin-bottom: 2px;
  text-transform: capitalize;
}
.rec-price {
  font-size: 1.08rem;
  color: #27ae60;
  font-weight: bold;
}
.recommendation-card:hover {
  box-shadow: 0 6px 20px 0 rgba(39, 174, 96, 0.19);
  transform: translateY(-3px) scale(1.035);
}
@media (max-width: 800px) {
  .product-detail-card {
    flex-direction: column;
    align-items: center;
    gap: 18px;
    padding: 15px;
  }
  .detail-image {
    width: 170px;
    height: 170px;
  }
}
</style>
