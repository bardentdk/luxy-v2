<template>
  <div class="public-layout min-h-screen flex flex-col">
    <!-- Bandeau cookie -->
    <CookieBanner />

    <!-- Navigation -->
    <AppNavbar />

    <!-- Flash messages -->
    <FlashMessages />

    <!-- Contenu principal -->
    <main class="flex-1">
      <slot />
    </main>

    <!-- Footer -->
    <AppFooter />
  </div>
</template>

<script setup>
import { onMounted, onBeforeUnmount } from 'vue'
import Lenis from 'lenis'
import AppNavbar from '@/Components/Public/AppNavbar.vue'
import AppFooter from '@/Components/Public/AppFooter.vue'
import FlashMessages from '@/Components/Shared/FlashMessages.vue'
import CookieBanner from '@/Components/Shared/CookieBanner.vue'

let lenis = null

onMounted(() => {
  lenis = new Lenis({
    duration: 1.2,
    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
    orientation: 'vertical',
    gestureOrientation: 'vertical',
    smoothWheel: true,
    wheelMultiplier: 1,
    smoothTouch: false,
    touchMultiplier: 2,
    infinite: false,
  })

  function raf(time) {
    lenis.raf(time)
    requestAnimationFrame(raf)
  }
  requestAnimationFrame(raf)
})

onBeforeUnmount(() => {
  lenis?.destroy()
})
</script>