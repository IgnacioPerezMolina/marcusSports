<template>
  <div class="cart-content">
    <h2 class="cart-title">My Cart</h2>
    <div v-if="cartItems.length === 0" class="empty-cart">
      <p>Your cart is empty.</p>
    </div>
    <div v-else class="cart-items">
      <div v-for="(item, index) in cartItems" :key="index" class="cart-item">
        <!-- Image and Details -->
        <div class="cart-item-content">
          <img :src="item.image" alt="Product" class="cart-item-image" />
          <div class="cart-item-details">
            <!-- Product Type -->
            <h3>{{ item.type }}</h3>
            <!-- Product Specifications -->
            <ul class="item-specifications">
              <li v-for="(value, key) in itemSpecifications(item)" :key="key">
                {{ formatKey(key) }}: {{ value }} ({{ getOptionPrice(key, value, item) }}€)
              </li>
            </ul>
            <!-- Price and Quantity -->
            <div class="price-quantity">
              <p><strong>Unit Price:</strong> {{ item.price.toFixed(2) }}€</p>
              <div class="quantity-control">
                <Button
                    icon="pi pi-minus"
                    class="p-button-text p-button-rounded"
                    @click="decreaseQuantity(index)"
                    :disabled="item.quantity <= 1"
                />
                <span class="quantity">{{ item.quantity }}</span>
                <Button
                    icon="pi pi-plus"
                    class="p-button-text p-button-rounded"
                    @click="increaseQuantity(index)"
                />
              </div>
              <p><strong>Subtotal:</strong> {{ (item.price * item.quantity).toFixed(2) }}€</p>
            </div>
          </div>
        </div>
        <!-- Delete Button -->
        <Button
            icon="pi pi-trash"
            class="p-button-text p-button-rounded p-button-danger remove-button"
            @click="removeItem(index)"
        />
      </div>
      <div class="cart-total">
        <h3>Total: {{ calculateTotal }}€</h3>
        <Button label="Checkout" class="p-button-raised p-button-primary checkout-button" @click="proceedToCheckout" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import Button from 'primevue/button';
import { ref, computed, onMounted } from 'vue';
import { useCartStore } from '@/stores/cart';
import apiClient from '@/api';

defineEmits(['proceed-to-checkout']);

const cartStore = useCartStore();
const cartItems = computed(() => cartStore.cartItems);
const calculateTotal = computed(() => cartStore.calculateTotal);

// Fetch all products to get option prices
const products = ref<any[]>([]);

const fetchProducts = async () => {
  try {
    const response = await apiClient.get('/product');
    products.value = response.data;
  } catch (error) {
    console.error('Error fetching products:', error);
  }
};

onMounted(() => {
  fetchProducts();
});

const removeItem = (index: number) => {
  cartStore.removeItem(index);
};

const increaseQuantity = (index: number) => {
  cartStore.increaseQuantity(index);
};

const decreaseQuantity = (index: number) => {
  cartStore.decreaseQuantity(index);
};

const proceedToCheckout = () => {
  emit('proceed-to-checkout');
};

// Extract specifications (excluding internal fields like id, image, price, quantity, type, category)
const itemSpecifications = (item: any) => {
  const specs: Record<string, string> = {};
  for (const [key, value] of Object.entries(item)) {
    if (['id', 'image', 'price', 'quantity', 'type', 'category'].includes(key) || !value) continue;
    specs[key] = value as string;
  }
  return specs;
};

// Format keys for display (e.g., "frame_type" -> "Frame Type")
const formatKey = (key: string) => {
  return key
      .replace(/_/g, ' ')
      .split(' ')
      .map(word => word.charAt(0).toUpperCase() + word.slice(1))
      .join(' ');
};

// Get the price of a specific option
const getOptionPrice = (key: string, value: string, item: any) => {
  const product = products.value.find(p => p.category === item.category);
  if (!product) return '0.00';

  const partType = product.partTypes.find((pt: any) =>
      pt.name.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_]/g, '') === key
  );

  if (!partType) return '0.00';

  const partItem = partType.partItems.find((pi: any) => pi.label === value);
  return partItem ? partItem.price.toFixed(2) : '0.00';
};
</script>

<style scoped>
.cart-content {
  display: flex;
  flex-direction: column;
  height: 100%;
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
  flex: 1;
  overflow-y: auto;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.cart-item {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  padding: 1rem 0;
  border-bottom: 1px solid #ddd;
}

.cart-item-content {
  display: flex;
  gap: 1rem;
  flex: 1;
}

.cart-item-image {
  width: 100px;
  height: 80px;
  object-fit: contain;
  border-radius: 8px;
}

.cart-item-details {
  flex: 1;
}

.cart-item-details h3 {
  font-size: 1.2rem;
  margin-bottom: 0.5rem;
}

.item-specifications {
  list-style: none;
  padding: 0;
  margin: 0 0 0.5rem 0;
  font-size: 0.85rem;
  color: #555;
}

.item-specifications li {
  margin-bottom: 0.25rem;
}

.price-quantity {
  margin-top: 0.5rem;
}

.price-quantity p {
  margin: 0.25rem 0;
  font-size: 0.9rem;
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
  align-self: flex-start;
  margin-left: 0.5rem;
}

.cart-total {
  margin-top: 1.5rem;
  text-align: right;
  font-size: 1.2rem;
  font-weight: bold;
  border-top: 1px solid #ddd;
  padding-top: 1rem;
}

.checkout-button {
  margin-top: 1rem;
  width: 100%;
  background-color: #00bcd4;
  border: none;
}

.checkout-button:hover {
  background-color: #00acc1;
}
</style>