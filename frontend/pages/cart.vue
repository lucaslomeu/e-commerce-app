<script setup lang="ts">
import { useCartStore } from "~/stores/cart";
import { onMounted } from "vue";

const cart = useCartStore();

function total() {
  return cart.items.reduce((sum, item) => sum + item.price * item.quantity, 0);
}

onMounted(() => {
  cart.loadFromLocalStorage();
});
</script>

<template>
  <main class="cart-container">
    <h2 class="cart-title">Seu Carrinho</h2>
    <div v-if="cart.items.length === 0" class="cart-empty">
      Seu carrinho está vazio.
    </div>
    <ul v-else class="cart-list">
      <li v-for="item in cart.items" :key="item.id" class="cart-item">
        <img :src="item.image_url" class="cart-item-img" />
        <div class="cart-item-info">
          <div class="cart-item-top">
            <span class="cart-item-name">{{ item.name }}</span>
            <button class="cart-remove-btn" @click="cart.remove(item.id)">
              ✕
            </button>
          </div>
          <div class="cart-item-bottom">
            <span class="cart-item-price">
              R$
              {{
                (item.price * item.quantity).toLocaleString("pt-BR", {
                  minimumFractionDigits: 2,
                })
              }}
            </span>
            <div class="cart-item-qtd">
              <label>Qtd.</label>
              <input
                type="number"
                min="1"
                v-model.number="item.quantity"
                @change="cart.updateQuantity(item.id, item.quantity)" />
            </div>
          </div>
        </div>
      </li>
    </ul>
    <div v-if="cart.items.length" class="cart-footer">
      <div class="cart-total">
        <b>Total:</b>
        <span class="cart-total-valor">
          R$ {{ total().toLocaleString("pt-BR", { minimumFractionDigits: 2 }) }}
        </span>
      </div>
      <button class="cart-clear-btn" @click="cart.clear">
        Limpar Carrinho
      </button>
      <button class="cart-finalizar-btn">Finalizar Compra</button>
    </div>
  </main>
</template>

<style scoped>
.cart-container {
  max-width: 600px;
  margin: 60px auto 36px auto;
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 3px 20px 0 rgba(123, 90, 168, 0.11);
  padding: 30px 18px 24px 18px;
  font-family: "Segoe UI", Arial, sans-serif;
}

.cart-title {
  text-align: center;
  color: #7f55b1;
  font-size: 1.4rem;
  font-weight: 700;
  margin-bottom: 26px;
  letter-spacing: 1px;
  position: relative;
}

.cart-title::after {
  content: "";
  display: block;
  width: 48px;
  height: 3px;
  background: linear-gradient(90deg, #9b7ebd 0%, #7f55b1 100%);
  border-radius: 4px;
  margin: 9px auto 0 auto;
  opacity: 0.7;
}

.cart-empty {
  text-align: center;
  color: #a08ec0;
  font-size: 1.1rem;
  margin-top: 50px;
}

.cart-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.cart-item {
  display: flex;
  gap: 18px;
  align-items: flex-start;
  padding: 14px 0;
  border-bottom: 1px solid #f3f0f7;
}

.cart-item:last-child {
  border-bottom: none;
}

.cart-item-img {
  width: 60px;
  height: 60px;
  object-fit: contain;
  border-radius: 7px;
  background: #f6f8fa;
  border: 1px solid #ede7f6;
}

.cart-item-info {
  flex: 1 1 0;
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.cart-item-top {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 10px;
}

.cart-item-name {
  font-size: 1.02rem;
  color: #4b4271;
  font-weight: 600;
  max-width: 230px;
  word-break: break-word;
}

.cart-remove-btn {
  background: transparent;
  border: none;
  color: #c0392b;
  font-size: 1.3rem;
  font-weight: bold;
  cursor: pointer;
  padding: 2px 7px;
  border-radius: 4px;
  transition: background 0.12s;
}
.cart-remove-btn:hover {
  background: #fbeaea;
}

.cart-item-bottom {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 14px;
  margin-top: 7px;
}

.cart-item-price {
  font-size: 1.05rem;
  color: #7f55b1;
  font-weight: 600;
}

.cart-item-qtd {
  display: flex;
  align-items: center;
  gap: 6px;
}
.cart-item-qtd label {
  font-size: 0.93rem;
  color: #9b7ebd;
}
.cart-item-qtd input {
  width: 46px;
  padding: 4px 6px;
  font-size: 1rem;
  border: 1.3px solid #9b7ebd;
  border-radius: 7px;
  outline: none;
  text-align: center;
  color: #614d86;
  background: #f9f6fd;
}

.cart-footer {
  margin-top: 24px;
  display: flex;
  flex-direction: column;
  gap: 16px;
  align-items: center;
}
.cart-total {
  font-size: 1.18rem;
  color: #24292f;
  font-weight: 600;
}
.cart-total-valor {
  color: #9b7ebd;
  font-weight: 700;
  margin-left: 6px;
  font-size: 1.18rem;
}
.cart-clear-btn {
  background: transparent;
  color: #7f55b1;
  border: 1.2px solid #7f55b1;
  padding: 7px 17px;
  border-radius: 8px;
  font-weight: 600;
  font-size: 0.98rem;
  margin-top: 7px;
  cursor: pointer;
  transition: background 0.15s, color 0.15s;
}
.cart-clear-btn:hover {
  background: #f6f1fa;
  color: #6a469d;
}

.cart-finalizar-btn {
  background: #7f55b1;
  color: #fff;
  border: none;
  padding: 10px 28px;
  border-radius: 8px;
  font-weight: 600;
  font-size: 1.04rem;
  margin-top: 3px;
  cursor: pointer;
  transition: background 0.16s, transform 0.13s;
}
.cart-finalizar-btn:hover {
  background: #9b7ebd;
  transform: scale(1.04);
}

@media (max-width: 600px) {
  .cart-container {
    max-width: 99vw;
    padding: 12px 4px 20px 4px;
  }
  .cart-title {
    font-size: 1.15rem;
  }
  .cart-item-img {
    width: 44px;
    height: 44px;
  }
  .cart-item-name {
    max-width: 100px;
    font-size: 0.97rem;
  }
  .cart-total,
  .cart-total-valor {
    font-size: 1rem;
  }
  .cart-clear-btn,
  .cart-finalizar-btn {
    padding: 7px 10px;
    font-size: 0.95rem;
  }
}
</style>
