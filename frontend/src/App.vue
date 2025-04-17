<template>
  <NavBar />
  <main class="p-mt-6">
    <router-view></router-view>
  </main>
  <FooterSection />
  <ScrollToTop />
</template>

<script setup lang="ts">
import NavBar from './components/NavBar.vue';
import FooterSection from './components/FooterSection.vue';
import ScrollToTop from './components/ScrollToTop.vue';
</script>

<style>
html {
  scroll-behavior: smooth;
}
</style>
