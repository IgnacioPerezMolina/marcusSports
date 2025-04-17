<template>
  <section id="hero" class="hero-section">
    <div class="hero-container">
      <!-- Left Side: Bike Image -->
      <div class="bike-container">
        <img :src="bikeImage" alt="Bicycle" class="bike-image" />
      </div>

      <!-- Right Side: Selectors and Button -->
      <div class="selectors-container">
        <h2 class="section-title">Customize Your {{ product?.name || 'Bicycle' }}</h2>

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
          <!-- Selector 1: Frame Type -->
          <div class="selector-group">
            <label for="frame-type">Frame Type</label>
            <Dropdown
              id="frame-type"
              v-model="selectedFrameType"
              :options="frameTypesOptions"
              optionLabel="label"
              optionValue="value"
              placeholder="Select a frame type"
              class="w-full"
              @change="validateSelections"
            />
          </div>

          <!-- Selector 2: Frame Finish -->
          <div class="selector-group">
            <label for="frame-finish">Frame Finish</label>
            <Dropdown
              id="frame-finish"
              v-model="selectedFrameFinish"
              :options="frameFinishesOptions"
              optionLabel="label"
              optionValue="value"
              placeholder="Select a frame finish"
              class="w-full"
              @change="validateSelections"
            />
          </div>

          <!-- Selector 3: Wheels -->
          <div class="selector-group">
            <label for="wheels">Wheels</label>
            <Dropdown
              id="wheels"
              v-model="selectedWheels"
              :options="wheelsOptions"
              optionLabel="label"
              optionValue="value"
              placeholder="Select wheels"
              class="w-full"
              @change="validateSelections"
            />
          </div>

          <!-- Selector 4: Rim Color -->
          <div class="selector-group">
            <label for="rim-color">Rim Color</label>
            <Dropdown
              id="rim-color"
              v-model="selectedRimColor"
              :options="rimColorsOptions"
              optionLabel="label"
              optionValue="value"
              placeholder="Select a rim color"
              class="w-full"
              @change="validateSelections"
            />
          </div>

          <!-- Selector 5: Chain -->
          <div class="selector-group">
            <label for="chain">Chain</label>
            <Dropdown
              id="chain"
              v-model="selectedChain"
              :options="chainsOptions"
              optionLabel="label"
              optionValue="value"
              placeholder="Select a chain"
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
import bikeImage from '@/assets/bike.jpg';
import apiClient from '@/api';

// Use the cart store
const cartStore = useCartStore();

// Product and PartTypes data
const product = ref<any>(null);
const partTypes = ref<any[]>([]);
const rules = ref<any[]>([]);
const priceModifiers = ref<any[]>([]);

// Dropdown options (raw data)
const frameTypes = ref<any[]>([]);
const frameFinishes = ref<any[]>([]);
const wheels = ref<any[]>([]);
const rimColors = ref<any[]>([]);
const chains = ref<any[]>([]);

// Selected values
const selectedFrameType = ref(null);
const selectedFrameFinish = ref(null);
const selectedWheels = ref(null);
const selectedRimColor = ref(null);
const selectedChain = ref(null);

// Error message and loading state
const errorMessage = ref<string | null>(null);
const loading = ref<boolean>(true);

// Fetch product data from API
const fetchProductData = async () => {
  try {
    loading.value = true;
    const response = await apiClient.get('/product');
    const products = response.data;

    // Filter the bicycle product
    const bikeProduct = products.find((p: any) => p.id === '11111111-1111-1111-1111-111111111111');
    if (!bikeProduct) {
      throw new Error('Bicycle product not found');
    }

    product.value = bikeProduct;
    partTypes.value = bikeProduct.partTypes;
    rules.value = bikeProduct.rules;
    priceModifiers.value = bikeProduct.priceModifiers;

    frameTypes.value = partTypes.value
      .find((pt: any) => pt.name === 'Frame Type')
      ?.partItems.map((item: any) => ({ label: item.label, value: item.label, price: item.price })) || [];
    frameFinishes.value = partTypes.value
      .find((pt: any) => pt.name === 'Frame Finish')
      ?.partItems.map((item: any) => ({ label: item.label, value: item.label, price: item.price })) || [];
    wheels.value = partTypes.value
      .find((pt: any) => pt.name === 'Wheels')
      ?.partItems.map((item: any) => ({ label: item.label, value: item.label, price: item.price })) || [];
    rimColors.value = partTypes.value
      .find((pt: any) => pt.name === 'Rim Color')
      ?.partItems.map((item: any) => ({ label: item.label, value: item.label, price: item.price })) || [];
    chains.value = partTypes.value
      .find((pt: any) => pt.name === 'Chain')
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

  const rule1 = rules.value.find((rule: any) => rule.ruleExpression.if.wheels === 'Mountain wheels');
  if (rule1 && selectedWheels.value === 'Mountain wheels' && selectedFrameType.value !== 'Full-suspension') {
    selectedFrameType.value = 'Full-suspension';
    errorMessage.value = 'Mountain wheels require a Full-suspension frame type.';
  }

  const rule2 = rules.value.find((rule: any) => rule.ruleExpression.if.wheels === 'Fat bike wheels');
  if (rule2 && selectedWheels.value === 'Fat bike wheels' && selectedRimColor.value === 'Red') {
    selectedRimColor.value = null;
    errorMessage.value = 'Fat bike wheels cannot be paired with Red rim color.';
  }
};

// Dropdown options with base prices only
const frameTypesOptions = computed(() => {
  const filtered = selectedWheels.value === 'Mountain wheels'
    ? frameTypes.value.filter(item => item.value === 'Full-suspension')
    : frameTypes.value;
  return filtered.map(item => ({
    label: `${item.label} (${item.price.toFixed(2)}€)`,
    value: item.value,
    price: item.price,
  }));
});

const frameFinishesOptions = computed(() => {
  return frameFinishes.value.map(item => ({
    label: `${item.label} (${item.price.toFixed(2)}€)`,
    value: item.value,
    price: item.price,
  }));
});

const wheelsOptions = computed(() => {
  return wheels.value.map(item => ({
    label: `${item.label} (${item.price.toFixed(2)}€)`,
    value: item.value,
    price: item.price,
  }));
});

const rimColorsOptions = computed(() => {
  const filtered = selectedWheels.value === 'Fat bike wheels'
    ? rimColors.value.filter(item => item.value !== 'Red')
    : rimColors.value;
  return filtered.map(item => ({
    label: `${item.label} (${item.price.toFixed(2)}€)`,
    value: item.value,
    price: item.price,
  }));
});

const chainsOptions = computed(() => {
  return chains.value.map(item => ({
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
      const { frame_finish, frame_type } = condition.if;
      if (
        selectedFrameFinish.value === frame_finish &&
        selectedFrameType.value === frame_type
      ) {
        modifiers.push(`+${modifier.adjustment.toFixed(2)}€ for ${frame_finish} finish on ${frame_type} frame`);
      }
    }
  });
  return modifiers;
});

// Compute total price with PriceModifiers
const totalPrice = computed(() => {
  if (loading.value) return '0.00';

  let price = product.value?.basePrice || 0;

  const frameTypePrice = frameTypes.value.find((item: any) => item.value === selectedFrameType.value)?.price || 0;
  const frameFinishPrice = frameFinishes.value.find((item: any) => item.value === selectedFrameFinish.value)?.price || 0;
  const wheelsPrice = wheels.value.find((item: any) => item.value === selectedWheels.value)?.price || 0;
  const rimColorPrice = rimColors.value.find((item: any) => item.value === selectedRimColor.value)?.price || 0;
  const chainPrice = chains.value.find((item: any) => item.value === selectedChain.value)?.price || 0;

  price += frameTypePrice + frameFinishPrice + wheelsPrice + rimColorPrice + chainPrice;

  // Apply PriceModifiers to the total price
  priceModifiers.value.forEach((modifier: any) => {
    const condition = modifier.condition;
    if (condition.then.apply_modifier) {
      const { frame_finish, frame_type } = condition.if;
      if (
        selectedFrameFinish.value === frame_finish &&
        selectedFrameType.value === frame_type
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
    selectedFrameType.value !== null &&
    selectedFrameFinish.value !== null &&
    selectedWheels.value !== null &&
    selectedChain.value !== null
  );
});

// Add to cart function
const addToCart = () => {
  if (!isFormComplete.value || errorMessage.value || loading.value) return;

  const bikeConfig = {
    id: Date.now(),
    type: 'Bicycle',
    frameType: selectedFrameType.value,
    frameFinish: selectedFrameFinish.value,
    wheels: selectedWheels.value,
    rimColor: selectedRimColor.value,
    chain: selectedChain.value,
    image: bikeImage,
    price: parseFloat(totalPrice.value),
    quantity: 1,
  };

  cartStore.addToCart(bikeConfig);
};

// Fetch data on component mount
onMounted(() => {
  fetchProductData();
});
</script>

<style scoped>
.hero-section {
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #f5f5f5;
  padding: 1rem;
}

.hero-container {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  max-width: 1200px;
  gap: 1rem;
}

.bike-container {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
}

.bike-image {
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
  .hero-container {
    flex-direction: column;
    gap: 0.5rem;
  }

  .bike-container,
  .selectors-container {
    width: 100%;
  }

  .selectors-container {
    height: auto;
    max-height: 50vh;
  }

  .bike-image {
    max-height: 40vh;
  }
}
</style>
