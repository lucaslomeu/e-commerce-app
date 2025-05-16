import { defineStore } from "pinia";

export const useCartStore = defineStore("cart", {
  state: () => ({
    items: [] as Array<CartItem>,
  }),
  actions: {
    add(product: Product) {
      const item = this.items.find((i) => i.id === product.id);
      if (item) {
        item.quantity++;
      } else {
        this.items.push({ ...product, quantity: 1 });
      }
      this.saveToLocalStorage();
    },
    remove(productId: number) {
      this.items = this.items.filter((i) => i.id !== productId);
      this.saveToLocalStorage();
    },
    updateQuantity(productId: number, quantity: number) {
      const item = this.items.find((i) => i.id === productId);
      if (item) {
        item.quantity = Math.max(1, quantity);
      }
      this.saveToLocalStorage();
    },
    clear() {
      this.items = [];
      this.saveToLocalStorage();
    },
    loadFromLocalStorage() {
      const data = localStorage.getItem("cart");
      if (data) this.items = JSON.parse(data);
    },
    saveToLocalStorage() {
      localStorage.setItem("cart", JSON.stringify(this.items));
    },
  },
});

// Tipos
interface Product {
  id: number;
  name: string;
  price: number;
  category: string;
  image_url?: string;
  description?: string;
}
interface CartItem extends Product {
  quantity: number;
}
