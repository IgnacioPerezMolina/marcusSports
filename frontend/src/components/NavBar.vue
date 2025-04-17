<template>
  <nav class="menubar-container p-shadow-3">
    <Menubar :model="menuItems">
      <template #start>
        <span class="brand">MarcusSports</span>
      </template>
      <template #end>
        <div class="cart-container">
          <Button
              class="p-button p-button-rounded cart-button"
              :class="{ 'cart-button-active': cartStore.cartItemCount > 0 }"
              @click="toggleCart"
          >
            <i class="pi pi-shopping-cart"></i>
            <Badge v-if="cartStore.cartItemCount > 0" :value="cartStore.cartItemCount"
                   severity="danger" class="cart-badge" />
          </Button>
          <span v-if="cartStore.cartItemCount > 0" class="cart-alert">
            <i class="pi pi-exclamation-circle"></i>
          </span>
        </div>
      </template>
    </Menubar>

    <!-- Cart Sidebar -->
    <Sidebar v-model:visible="showCart" position="right" class="cart-sidebar">
      <Cart @proceed-to-checkout="proceedToCheckout" />
    </Sidebar>
  </nav>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import { useRouter } from 'vue-router';
import Menubar from 'primevue/menubar';
import Button from 'primevue/button';
import Badge from 'primevue/badge';
import Sidebar from 'primevue/sidebar';
import Cart from '@/components/Cart.vue';
import { useCartStore } from '@/stores/cart';

const cartStore = useCartStore();
const router = useRouter();

const menuItems = ref([
  {
    label: 'Custom Bikes',
    icon: 'pi pi-compass',
    command: () => {
      router.push('/');
    },
  },
  {
    label: 'Custom Surfboard',
    icon: 'pi pi-compass',
    command: () => {
      router.push('/surfboard');
    },
  },
]);

const showCart = ref(false);
const triggerAnimation = ref(false);

const toggleCart = () => {
  showCart.value = !showCart.value;
};

const proceedToCheckout = () => {
  console.log('Proceeding to checkout...');
  showCart.value = false;
};

watch(
    () => cartStore.cartItemCount,
    (newCount, oldCount) => {
      if (newCount > oldCount) {
        triggerAnimation.value = true;
      }
    }
);
</script>

<style scoped>
.menubar-container {
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 1000;
}

.brand {
  font-weight: bold;
  font-size: 1.5rem;
  margin-left: 1rem;
}

.cart-container {
  display: flex;
  align-items: center;
  margin-right: 1rem;
  position: relative;
}

.cart-button {
  position: relative;
  z-index: 1;
  background-color: rgba(255, 255, 255, 0.1);
  border: none;
  padding: 0.5rem;
  transition: background-color 0.3s, transform 0.3s;
}

.cart-button i {
  font-size: 1.5rem;
  color: #333;
}

.cart-button:hover {
  background-color: rgba(255, 255, 255, 0.2);
}

.cart-button:hover i {
  color: #000;
}

.cart-button-active {
  background-color: rgba(255, 255, 255, 0.3);
}

.cart-alert {
  position: absolute;
  top: -12px;
  left: 0;
  z-index: 2;
  background-color: #ff9800;
  border-radius: 50%;
  width: 20px;
  height: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 0.9rem;
  animation: pulse 0.5s ease-in-out;
}

.cart-button-active.cart-button {
  animation: pulse 0.5s ease-in-out;
}

@keyframes pulse {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.2);
  }
  100% {
    transform: scale(1);
  }
}

.cart-badge {
  position: absolute;
  top: -8px;
  right: -8px;
  z-index: 2;
}

.cart-sidebar {
  width: 400px;
}

@media (max-width: 768px) {
  .cart-sidebar {
    width: 100%;
  }
}
</style>