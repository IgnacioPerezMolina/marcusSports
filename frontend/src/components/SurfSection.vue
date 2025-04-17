<template>
  <section id="surf" class="surf-section">
    <div class="surf-container">
      <!-- Left Side: Surfboard Image -->
      <div class="surfboard-container">
        <img :src="surfboardImage" alt="Surfboard" class="surfboard-image" />
      </div>

      <!-- Right Side: Selectors and Button -->
      <div class="selectors-container">
        <h2 class="section-title">Customize Your {{ product?.name || 'Surfboard' }}</h2>

        <!-- Error Message -->
        <div v-if="errorMessage" class="error-message">
          <p>{{ errorMessage }}</p>
        </div>

        <!-- Loading State -->
        <div v-if="loading" class="loading-message">
          <p>Loading product data...</p>
        </div>

        <!-- Form Container with Scroll -->
        <div v-else class="form-container">
          <!-- Selector 1: Board Shape -->
          <div class="selector-group">
            <label for="board-shape">Board Shape</label>
            <Dropdown
              id="board-shape"
              v-model="selectedBoardShape"
              :options="boardShapesOptions"
              optionLabel="label"
              optionValue="value"
              placeholder="Select a board shape"
              class="w-full"
              @change="validateSelections"
            />
          </div>

          <!-- Selector 2: Fin Configuration -->
          <div class="selector-group">
            <label for="fin-configuration">Fin Configuration</label>
            <Dropdown
              id="fin-configuration"
              v-model="selectedFinConfiguration"
              :options="finConfigurationsOptions"
              optionLabel="label"
              optionValue="value"
              placeholder="Select a fin configuration"
              class="w-full"
              @change="validateSelections"
            />
          </div>

          <!-- Selector 3: Deck Color -->
          <div class="selector-group">
            <label for="deck-color">Deck Color</label>
            <Dropdown
              id="deck-color"
              v-model="selectedDeckColor"
              :options="deckColorsOptions"
              optionLabel="label"
              optionValue="value"
              placeholder="Select a deck color"
              class="w-full"
              @change="validateSelections"
            />
          </div>

          <!-- Selector 4: Leash -->
          <div class="selector-group">
            <label for="leash">Leash</label>
            <Dropdown
              id="leash"
              v-model="selectedLeash"
              :options="leashesOptions"
              optionLabel="label"
              optionValue="value"
              placeholder="Select a leash"
              class="w-full"
              @change="validateSelections"
            />
          </div>
        </div>

        <!-- Price Display and Button (Sticky at the bottom) -->
        <div v-if="!loading" class="footer-container">
          <div class="price-display">
            <p><strong>Total Price:</strong> {{ totalPrice }}€</p>
            <div v-if="appliedModifiers.length" class="modifiers-list">
              <p v-for="(modifier, index) in appliedModifiers" :key="index" class="modifier-item">
                {{ modifier }}
              </p>
            </div>
          </div>
          <Button
            label="Add to Cart"
            icon="pi pi-shopping-cart"
            class="p-button-raised p-button-success add-to-cart-button"
            :disabled="!isFormComplete || errorMessage || loading"
            @click="addToCart"
          />
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import Dropdown from 'primevue/dropdown';
import Button from 'primevue/button';
import { useCartStore } from '@/stores/cart';
import surfboardImage from '@/assets/surfboard.jpg';
import apiClient from '@/api';

// Use the cart store
const cartStore = useCartStore();

// Product and PartTypes data
const product = ref<any>(null);
const partTypes = ref<any[]>([]);
const rules = ref<any[]>([]);
const priceModifiers = ref<any[]>([]);

// Dropdown options (raw data)
const boardShapes = ref<any[]>([]);
const finConfigurations = ref<any[]>([]);
const deckColors = ref<any[]>([]);
const leashes = ref<any[]>([]);

// Selected values
const selectedBoardShape = ref(null);
const selectedFinConfiguration = ref(null);
const selectedDeckColor = ref(null);
const selectedLeash = ref(null);

// Error message and loading state
const errorMessage = ref<string | null>(null);
const loading = ref<boolean>(true);

// Fetch product data from API
const fetchProductData = async () => {
  try {
    loading.value = true;
    const response = await apiClient.get('/product');
    const products = response.data;

    // Filter the surfboard product
    const surfProduct = products.find((p: any) => p.id === '22222222-2222-2222-2222-222222222222');
    if (!surfProduct) {
      throw new Error('Surfboard product not found');
    }

    product.value = surfProduct;
    partTypes.value = surfProduct.partTypes;
    rules.value = surfProduct.rules;
    priceModifiers.value = surfProduct.priceModifiers;

    boardShapes.value = partTypes.value
      .find((pt: any) => pt.name === 'Board Shape')
      ?.partItems.map((item: any) => ({ label: item.label, value: item.label, price: item.price })) || [];
    finConfigurations.value = partTypes.value
      .find((pt: any) => pt.name === 'Fin Configuration')
      ?.partItems.map((item: any) => ({ label: item.label, value: item.label, price: item.price })) || [];
    deckColors.value = partTypes.value
      .find((pt: any) => pt.name === 'Deck Color')
      ?.partItems.map((item: any) => ({ label: item.label, value: item.label, price: item.price })) || [];
    leashes.value = partTypes.value
      .find((pt: any) => pt.name === 'Accessory: Leash')
      ?.partItems.map((item: any) => ({ label: item.label, value: item.label, price: item.price })) || [];
  } catch (error) {
    console.error('Error fetching product data:', error);
    errorMessage.value = 'Failed to load product data. Please try again later.';
  } finally {
    loading.value = false;
  }
};

// Validate selections against rules
const validateSelections = () => {
  errorMessage.value = null;

  const rule = rules.value.find((rule: any) => rule.ruleExpression.if.fin_configuration === 'Tri-fin');
  if (rule && selectedFinConfiguration.value === 'Tri-fin' && selectedBoardShape.value !== 'Shortboard') {
    selectedBoardShape.value = 'Shortboard';
    errorMessage.value = 'Tri-fin configuration requires a Shortboard shape.';
  }
};

// Dropdown options with base prices only
const boardShapesOptions = computed(() => {
  const filtered = selectedFinConfiguration.value === 'Tri-fin'
    ? boardShapes.value.filter(item => item.value === 'Shortboard')
    : boardShapes.value;
  return filtered.map(item => ({
    label: `${item.label} (${item.price.toFixed(2)}€)`,
    value: item.value,
    price: item.price,
  }));
});

const finConfigurationsOptions = computed(() => {
  return finConfigurations.value.map(item => ({
    label: `${item.label} (${item.price.toFixed(2)}€)`,
    value: item.value,
    price: item.price,
  }));
});

const deckColorsOptions = computed(() => {
  return deckColors.value.map(item => ({
    label: `${item.label} (${item.price.toFixed(2)}€)`,
    value: item.value,
    price: item.price,
  }));
});

const leashesOptions = computed(() => {
  return leashes.value.map(item => ({
    label: `${item.label} (${item.price.toFixed(2)}€)`,
    value: item.value,
    price: item.price,
  }));
});

// Compute applied PriceModifiers for display
const appliedModifiers = computed(() => {
  const modifiers: string[] = [];
  priceModifiers.value.forEach((modifier: any) => {
    const condition = modifier.condition;
    if (condition.then.apply_modifier) {
      const { board_shape, fin_configuration } = condition.if;
      if (
        selectedBoardShape.value === board_shape &&
        selectedFinConfiguration.value === fin_configuration
      ) {
        modifiers.push(`+${modifier.adjustment.toFixed(2)}€ for ${board_shape} with ${fin_configuration}`);
      }
    }
  });
  return modifiers;
});

// Compute total price with PriceModifiers
const totalPrice = computed(() => {
  if (loading.value) return '0.00';

  let price = product.value?.basePrice || 0;

  const boardShapePrice = boardShapes.value.find((item: any) => item.value === selectedBoardShape.value)?.price || 0;
  const finConfigurationPrice = finConfigurations.value.find((item: any) => item.value === selectedFinConfiguration.value)?.price || 0;
  const deckColorPrice = deckColors.value.find((item: any) => item.value === selectedDeckColor.value)?.price || 0;
  const leashPrice = leashes.value.find((item: any) => item.value === selectedLeash.value)?.price || 0;

  price += boardShapePrice + finConfigurationPrice + deckColorPrice + leashPrice;

  // Apply PriceModifiers to the total price
  priceModifiers.value.forEach((modifier: any) => {
    const condition = modifier.condition;
    if (condition.then.apply_modifier) {
      const { board_shape, fin_configuration } = condition.if;
      if (
        selectedBoardShape.value === board_shape &&
        selectedFinConfiguration.value === fin_configuration
      ) {
        price += modifier.adjustment;
      }
    }
  });

  return price.toFixed(2);
});

// Check if all required fields are complete
const isFormComplete = computed(() => {
  return (
    selectedBoardShape.value !== null &&
    selectedFinConfiguration.value !== null
  );
});

// Add to cart function
const addToCart = () => {
  if (!isFormComplete.value || errorMessage.value || loading.value) return;

  const surfboardConfig = {
    id: Date.now(),
    type: 'Surfboard',
    boardShape: selectedBoardShape.value,
    finConfiguration: selectedFinConfiguration.value,
    deckColor: selectedDeckColor.value,
    leash: selectedLeash.value,
    image: surfboardImage,
    price: parseFloat(totalPrice.value),
    quantity: 1,
  };

  cartStore.addToCart(surfboardConfig);
};

// Fetch data on component mount
onMounted(() => {
  fetchProductData();
});
</script>

<style scoped>
.surf-section {
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #f5f5f5;
  padding: 1rem;
}

.surf-container {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  max-width: 1200px;
  gap: 1rem;
}

.surfboard-container {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
}

.surfboard-image {
  max-width: 100%;
  height: auto;
  max-height: 80vh;
}

.selectors-container {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  padding: 1rem;
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  height: 80vh;
}

.section-title {
  font-size: 1.25rem;
  font-weight: bold;
  margin-bottom: 0.5rem;
  text-align: center;
}

.form-container {
  flex: 1;
  overflow-y: auto;
  padding-right: 0.5rem;
}

.selector-group {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
  margin-bottom: 0.5rem;
}

.selector-group label {
  font-weight: 600;
  font-size: 0.9rem;
}

.footer-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem;
  padding-top: 0.5rem;
  border-top: 1px solid #e0e0e0;
}

.price-display {
  text-align: center;
  font-size: 1.1rem;
  font-weight: bold;
}

.modifiers-list {
  margin-top: 0.5rem;
  font-size: 0.9rem;
  color: #555;
}

.modifier-item {
  margin: 0;
}

.add-to-cart-button {
  width: 100%;
}

.error-message {
  background-color: #f8d7da;
  color: #721c24;
  padding: 0.5rem;
  border-radius: 4px;
  text-align: center;
  font-size: 0.9rem;
}

.loading-message {
  text-align: center;
  font-size: 1rem;
  color: #555;
}

@media (max-width: 768px) {
  .surf-container {
    flex-direction: column;
    gap: 0.5rem;
  }

  .surfboard-container,
  .selectors-container {
    width: 100%;
  }

  .selectors-container {
    height: auto;
    max-height: 50vh;
  }

  .surfboard-image {
    max-height: 40vh;
  }
}
</style>
