import { createRouter, createWebHistory } from 'vue-router';
import HeroSection from '@/components/HeroSection.vue';
import SurfSection from '@/components/SurfSection.vue';

const routes = [
  {
    path: '/',
    name: 'CustomBikes',
    component: HeroSection,
  },
  {
    path: '/surfboard',
    name: 'CustomSurfboard',
    component: SurfSection,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
