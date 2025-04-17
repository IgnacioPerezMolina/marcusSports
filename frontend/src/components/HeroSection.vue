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
          <!-- Dynamic Selectors -->
          <div v-for="partType in partTypes" :key="partType.name" class="selector-group">
            <label :for="partType.name.toLowerCase().replace(/\s+/g, '-')">
              {{ partType.name }} {{ partType.required ? '*' : '' }}
            </label>
            <Dropdown
                :id="partType.name.toLowerCase().replace(/\s+/g, '-')"
                v-model="selections[partType.name.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_]/g, '')]"
                :options="computedOptions[partType.name.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_]/g, '')]"
                optionLabel="label"
                optionValue="value"
                :placeholder="'Select a ' + partType.name.toLowerCase()"
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
              @click="addToCart(bikeImage, product?.name || 'Bicycle')"
          />
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import Dropdown from 'primevue/dropdown';
import Button from 'primevue/button';
import bikeImage from '@/assets/bike.jpg';
import { useProductConfig } from './composables/useProductConfig';

const {
  product,
  partTypes,
  selections,
  errorMessage,
  loading,
  computedOptions,
  appliedModifiers,
  totalPrice,
  isFormComplete,
  requiredFields,
  validateSelections,
  addToCart,
} = useProductConfig('cycling');
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

.selector-group label::after {
  content: '*';
  color: red;
  margin-left: 0.25rem;
  display: inline;
}

.selector-group label:not(:has(+ .p-dropdown[required]))::after {
  content: none;
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