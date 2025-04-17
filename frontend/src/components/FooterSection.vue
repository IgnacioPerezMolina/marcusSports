<template>
  <footer class="p-4 bg-gray-100 border-top-1 border-gray-300 text-center">
    <div class="mx-auto" style="max-width: 600px;">
      <!-- Contact Info -->
      <h5 class="text-xl font-semibold mb-2 text-gray-900">Contact Us</h5>
      <p class="mb-1 text-gray-800">123 Bike Street, Cycling City, Country</p>
      <p class="mb-1 text-gray-800">Phone: 123-456-7890</p>
      <p class="text-gray-800 mb-4">
        Email:
        <a href="mailto:info@bikeshop.com" class="text-primary hover:underline">
          info@bikeshop.com
        </a>
      </p>

      <!-- Social Media Buttons -->
      <div class="flex justify-content-center gap-2 mb-4">
        <Button icon="pi pi-facebook" class="p-button-rounded p-button-primary" aria-label="Facebook" />
        <Button icon="pi pi-twitter" class="p-button-rounded p-button-primary" aria-label="Twitter" />
        <Button icon="pi pi-instagram" class="p-button-rounded p-button-primary" aria-label="Instagram" />
      </div>

      <!-- Extra Footer Menu -->
      <div class="flex justify-content-center flex-wrap gap-3 mb-3 text-sm text-gray-700">
        <a href="#" class="hover:underline">About Us</a>
        <a href="#" class="hover:underline">Terms of Service</a>
        <a href="#" class="hover:underline">Privacy Policy</a>
        <a href="#" class="hover:underline">FAQs</a>
      </div>

      <!-- Copyright -->
      <p class="text-sm text-gray-700">© 2025 BikeShop</p>
    </div>
  </footer>
</template>

<script setup lang="ts">
// No script required
</script>
