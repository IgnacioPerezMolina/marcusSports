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
      <h2 class="cart-title">My Cart</h2>
      <div v-if="cartStore.cartItems.length === 0" class="empty-cart">
        <p>Your cart is empty.</p>
      </div>
      <div v-else class="cart-items">
        <div v-for="(item, index) in cartStore.cartItems" :key="index" class="cart-item">
          <img :src="item.image" alt="Product" class="cart-item-image" />
          <div class="cart-item-details">
            <!-- Display Bicycle Details -->
            <template v-if="item.type === 'Bicycle'">
              <h3>Custom Bicycle</h3>
              <p><strong>Frame Type:</strong> {{ item.frameType }}</p>
              <p><strong>Finish:</strong> {{ item.frameFinish }}</p>
              <p><strong>Wheels:</strong> {{ item.wheels }}</p>
              <p><strong>Rim Color:</strong> {{ item.rimColor }}</p>
              <p><strong>Chain:</strong> {{ item.chain }}</p>
            </template>
            <!-- Display Surfboard Details -->
            <template v-if="item.type === 'Surfboard'">
              <h3>Custom Surfboard</h3>
              <p><strong>Board Shape:</strong> {{ item.boardShape }}</p>
              <p><strong>Fin Configuration:</strong> {{ item.finConfiguration }}</p>
              <p><strong>Deck Color:</strong> {{ item.deckColor }}</p>
              <p><strong>Leash:</strong> {{ item.leash }}</p>
              <p><strong>Wax:</strong> {{ item.wax }}</p>
            </template>
            <p><strong>Unit Price:</strong> {{ item.price }}€</p>
            <div class="quantity-control">
              <Button
                icon="pi pi-minus"
                class="p-button-text p-button-rounded"
                @click="cartStore.decreaseQuantity(index)"
                :disabled="item.quantity <= 1"
              />
              <span class="quantity">{{ item.quantity }}</span>
              <Button
                icon="pi pi-plus"
                class="p-button-text p-button-rounded"
                @click="cartStore.increaseQuantity(index)"
              />
            </div>
            <p><strong>Subtotal:</strong> {{ item.price * item.quantity }}€</p>
            <Button
              icon="pi pi-trash"
              class="p-button-text p-button-rounded p-button-danger remove-button"
              @click="cartStore.removeItem(index)"
            />
          </div>
        </div>
        <div class="cart-total">
          <h3>Total: {{ cartStore.calculateTotal }}€</h3>
          <Button label="Checkout" class="p-button-raised p-button-primary checkout-button"
                  @click="proceedToCheckout" />
        </div>
      </div>
    </Sidebar>
  </nav>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import { useRouter } from 'vue-router'; // Import useRouter
import Menubar from 'primevue/menubar';
import Button from 'primevue/button';
import Badge from 'primevue/badge';
import Sidebar from 'primevue/sidebar';
import { useCartStore } from '@/stores/cart';

// Use the cart store
const cartStore = useCartStore();

// Use the router
const router = useRouter();

// Define menu items with a command to handle navigation
const menuItems = ref([
  {
    label: 'Custom Bikes',
    icon: 'pi pi-compass',
    command: () => {
      router.push('/'); // Programmatically navigate to the route
    },
  },
  {
    label: 'Custom Surfboard',
    icon: 'pi pi-compass',
    command: () => {
      router.push('/surfboard'); // Programmatically navigate to the route
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

// Watch for changes in cartItemCount
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

.cart-title {
  font-size: 1.5rem;
  font-weight: bold;
  margin-bottom: 1.5rem;
  text-align: center;
}

.empty-cart {
  text-align: center;
  color: #666;
}

.cart-items {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.cart-item {
  display: flex;
  gap: 1rem;
  padding: 1rem;
  border-bottom: 1px solid #ddd;
}

.cart-item-image {
  width: 100px;
  height: 80px;
  object-fit: contain;
  border-radius: 8px;
}

.cart-item-details {
  flex: 1;
  position: relative;
}

.cart-item-details h3 {
  font-size: 1.2rem;
  margin-bottom: 0.5rem;
}

.cart-item-details p {
  margin: 0.2rem 0;
}

.quantity-control {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin: 0.5rem 0;
}

.quantity {
  font-size: 1rem;
  font-weight: bold;
  min-width: 20px;
  text-align: center;
}

.remove-button {
  position: absolute;
  top: 0;
  right: 0;
}

.cart-total {
  margin-top: 1.5rem;
  text-align: right;
  font-size: 1.2rem;
  font-weight: bold;
}

.checkout-button {
  margin-top: 1rem;
  width: 100%;
}

@media (max-width: 768px) {
  .cart-sidebar {
    width: 100%;
  }
}
</style>
