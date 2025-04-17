import { ref, computed, onMounted } from 'vue';
import apiClient from '@/api';
import { useCartStore } from '@/stores/cart';

interface PartItem {
    label: string;
    price: number;
}

interface PartType {
    name: string;
    required: boolean;
    partItems: PartItem[];
}

interface Rule {
    ruleExpression: {
        if: Record<string, string>;
        then: Record<string, string>;
    };
}

interface PriceModifier {
    condition: {
        if: Record<string, string>;
        then: { apply_modifier: boolean };
    };
    adjustment: number;
}

interface Product {
    id: string;
    name: string;
    category: string;
    basePrice: number;
    partTypes: PartType[];
    rules: Rule[];
    priceModifiers: PriceModifier[];
}

export function useProductConfig(category: string) {
    const cartStore = useCartStore();

    // Product and PartTypes data
    const product = ref<Product | null>(null);
    const partTypes = ref<PartType[]>([]);
    const rulesData = ref<Rule[]>([]);
    const priceModifiers = ref<PriceModifier[]>([]);

    // Dropdown options (raw data)
    const optionsData = ref<Record<string, { label: string; value: string; price: number }[]>>({});

    // Selected values
    const selections = ref<Record<string, string | null>>({});

    // Error message and loading state
    const errorMessage = ref<string | null>(null);
    const loading = ref<boolean>(true);

    // Fetch product data from API based on category
    const fetchProductData = async () => {
        try {
            loading.value = true;
            const response = await apiClient.get('/product');
            const products = response.data;

            const selectedProduct = products.find((p: Product) => p.category === category);
            if (!selectedProduct) {
                throw new Error(`No product found for category: ${category}`);
            }

            product.value = selectedProduct;
            partTypes.value = selectedProduct.partTypes;
            rulesData.value = selectedProduct.rules;
            priceModifiers.value = selectedProduct.priceModifiers;

            // Initialize options and selections dynamically
            partTypes.value.forEach((partType) => {
                const key = partType.name.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_]/g, '');
                optionsData.value[key] = partType.partItems.map((item) => ({
                    label: item.label,
                    value: item.label,
                    price: item.price,
                }));
                selections.value[key] = null;
            });
        } catch (error) {
            console.error('Error fetching product data:', error);
            errorMessage.value = `Failed to load product data for category "${category}". Please try again later.`;
        } finally {
            loading.value = false;
        }
    };

    // Validate selections against rules
    const validateSelections = () => {
        errorMessage.value = null;

        rulesData.value.forEach((rule) => {
            const condition = rule.ruleExpression;
            const ifKey = Object.keys(condition.if)[0];
            const ifValue = condition.if[ifKey];
            const thenKey = Object.keys(condition.then)[0];
            const thenValue = condition.then[thenKey];

            const normalizedIfKey = ifKey.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_]/g, '');
            const normalizedThenKey = thenKey.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_]/g, '');

            // Handle "if-then" rules
            if (!thenKey.startsWith('not_allowed_')) {
                if (
                    selections.value[normalizedIfKey] === ifValue &&
                    selections.value[normalizedThenKey] !== thenValue
                ) {
                    selections.value[normalizedThenKey] = thenValue;
                    errorMessage.value = `${ifValue} requires ${thenKey.replace('_', ' ')} to be ${thenValue}.`;
                }
            } else {
                // Handle "not-allowed" rules
                const notAllowedKey = thenKey.replace('not_allowed_', '');
                const notAllowedNormalizedKey = notAllowedKey.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_]/g, '');
                if (
                    selections.value[normalizedIfKey] === ifValue &&
                    selections.value[notAllowedNormalizedKey] === thenValue
                ) {
                    selections.value[notAllowedNormalizedKey] = null;
                    errorMessage.value = `${ifValue} cannot be paired with ${thenValue} ${notAllowedKey.replace('_', ' ')}.`;
                }
            }
        });
    };

    // Compute dropdown options dynamically
    const computedOptions = computed(() => {
        const result: Record<string, { label: string; value: string; price: number }[]> = {};

        Object.keys(optionsData.value).forEach((key) => {
            let filteredOptions = optionsData.value[key] || [];

            // Apply filters based on rules
            rulesData.value.forEach((rule) => {
                const condition = rule.ruleExpression;
                const ifKey = Object.keys(condition.if)[0];
                const ifValue = condition.if[ifKey];
                const thenKey = Object.keys(condition.then)[0];
                const thenValue = condition.then[thenKey];

                const normalizedIfKey = ifKey.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_]/g, '');
                const normalizedThenKey = thenKey.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_]/g, '');

                if (normalizedIfKey === key) return;

                if (thenKey.startsWith('not_allowed_')) {
                    const notAllowedKey = thenKey.replace('not_allowed_', '');
                    const notAllowedNormalizedKey = notAllowedKey.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_]/g, '');
                    if (notAllowedNormalizedKey === key && selections.value[normalizedIfKey] === ifValue) {
                        filteredOptions = filteredOptions.filter((item) => item.value !== thenValue);
                    }
                } else {
                    if (normalizedThenKey === key && selections.value[normalizedIfKey] === ifValue) {
                        filteredOptions = filteredOptions.filter((item) => item.value === thenValue);
                    }
                }
            });

            result[key] = filteredOptions.map((item) => ({
                label: `${item.label} (${item.price.toFixed(2)}€)`,
                value: item.value,
                price: item.price,
            }));
        });

        return result;
    });

    // Compute applied PriceModifiers for display
    const appliedModifiers = computed(() => {
        const modifiers: string[] = [];
        priceModifiers.value.forEach((modifier) => {
            const condition = modifier.condition;
            if (condition.then.apply_modifier) {
                const conditions = condition.if;
                const conditionKeys = Object.keys(conditions);
                const matches = conditionKeys.every((key) => {
                    const normalizedKey = key.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_]/g, '');
                    return selections.value[normalizedKey] === conditions[key];
                });

                if (matches) {
                    const modifierText = conditionKeys
                        .map((key) => `${key.replace('_', ' ')}: ${conditions[key]}`)
                        .join(' and ');
                    modifiers.push(`+${modifier.adjustment.toFixed(2)}€ for ${modifierText}`);
                }
            }
        });
        return modifiers;
    });

    // Compute total price with PriceModifiers
    const totalPrice = computed(() => {
        if (loading.value) return '0.00';

        let price = product.value?.basePrice || 0;

        Object.keys(selections.value).forEach((key) => {
            const selectedValue = selections.value[key];
            const option = optionsData.value[key]?.find((item) => item.value === selectedValue);
            price += option?.price || 0;
        });

        priceModifiers.value.forEach((modifier) => {
            const condition = modifier.condition;
            if (condition.then.apply_modifier) {
                const conditions = condition.if;
                const conditionKeys = Object.keys(conditions);
                const matches = conditionKeys.every((key) => {
                    const normalizedKey = key.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_]/g, '');
                    return selections.value[normalizedKey] === conditions[key];
                });

                if (matches) {
                    price += modifier.adjustment;
                }
            }
        });

        return price.toFixed(2);
    });

    // Determine required fields using the `required` field from partTypes
    const requiredFields = computed(() => {
        return partTypes.value
            .filter((partType) => partType.required)
            .map((partType) => partType.name.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_]/g, ''));
    });

    // Check if all required fields are complete
    const isFormComplete = computed(() => {
        return requiredFields.value.every((key) => selections.value[key] !== null);
    });

    // Add to cart function
    const addToCart = (image: string, type: string) => {
        if (!isFormComplete.value || errorMessage.value || loading.value) return;

        const config = {
            id: Date.now(),
            type,
            ...Object.fromEntries(
                Object.keys(selections.value).map((key) => [key, selections.value[key]])
            ),
            image,
            price: parseFloat(totalPrice.value),
            quantity: 1,
        };

        cartStore.addToCart(config);
    };

    // Fetch data on component mount
    onMounted(() => {
        fetchProductData();
    });

    return {
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
    };
}