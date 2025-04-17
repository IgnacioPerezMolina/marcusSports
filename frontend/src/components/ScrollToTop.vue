<template>
  <transition name="fade">
    <Button
      v-show="isVisible"
      icon="pi pi-arrow-up"
      class="p-button-rounded p-button-primary scroll-top"
      @click="scrollToTop"
      aria-label="Scroll to Top"
    />
  </transition>
</template>

<script setup lang="ts">
import { ref, onMounted, onBeforeUnmount } from 'vue';

const isVisible = ref(false);

const handleScroll = () => {
  isVisible.value = window.scrollY > 300;
};

const scrollToTop = () => {
  window.scrollTo({ top: 0, behavior: 'smooth' });
};

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
});

onBeforeUnmount(() => {
  window.removeEventListener('scroll', handleScroll);
});
</script>

<style scoped>
.scroll-top {
  position: fixed;
  bottom: 1.5rem;
  right: 1.5rem;
  z-index: 999;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
}

/* Fade-in animation */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>

