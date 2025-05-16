export default defineNuxtConfig({
  compatibilityDate: "2025-05-15",
  devtools: { enabled: true },
  runtimeConfig: {
    public: {
      apiBase: process.env.API_BASE || "http://app:8000",
    },
  },
  css: ["~/assets/global.css"],
});
