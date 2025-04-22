import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

export const useCartStore = defineStore('cart', () => {
  const cartItems = ref<any[]>([]);

  const cartItemCount = computed(() => cartItems.value.length);

  const calculateTotal = computed(() => {
    return cartItems.value.reduce((total: number, item: any) => total + item.price * item.quantity, 0);
  });

  const addToCart = (bikeConfig: any) => {
    cartItems.value.push(bikeConfig);
  };

  const increaseQuantity = (index: number) => {
    cartItems.value[index].quantity += 1;
  };

  const decreaseQuantity = (index: number) => {
    if (cartItems.value[index].quantity > 1) {
      cartItems.value[index].quantity -= 1;
    }
  };

  const removeItem = (index: number) => {
    cartItems.value.splice(index, 1);
  };

  return {
    cartItems,
    cartItemCount,
    calculateTotal,
    addToCart,
    increaseQuantity,
    decreaseQuantity,
    removeItem,
  };
});
