<template>
  <div style="min-height:100vh; background:white; position:relative;">
    <div id="cursor-dot"  ref="cursorDot" />
    <div id="cursor-ring" ref="cursorRing" />

    <AppNavbar />
    <FlashMessages />
    <main><slot /></main>
    <AppFooter />
    <CookieBanner />
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import Lenis from 'lenis'
import AppNavbar    from '@/Components/Public/AppNavbar.vue'
import AppFooter    from '@/Components/Public/AppFooter.vue'
import FlashMessages from '@/Components/Shared/FlashMessages.vue'
import CookieBanner  from '@/Components/Shared/CookieBanner.vue'

const cursorDot  = ref(null)
const cursorRing = ref(null)
let lenis = null
let rafId = null
let ringX = 0, ringY = 0, dotX = 0, dotY = 0

onMounted(() => {
  lenis = new Lenis({ duration: 1.4, easing: t => Math.min(1, 1.001 - Math.pow(2, -10 * t)), smoothWheel: true })
  function raf(time) { lenis.raf(time); rafId = requestAnimationFrame(raf) }
  rafId = requestAnimationFrame(raf)

  window.addEventListener('mousemove', e => {
    dotX = e.clientX; dotY = e.clientY
    if (cursorDot.value) { cursorDot.value.style.left = dotX + 'px'; cursorDot.value.style.top = dotY + 'px' }
  }, { passive: true })

  ;(function animateRing() {
    ringX += (dotX - ringX) * 0.14; ringY += (dotY - ringY) * 0.14
    if (cursorRing.value) { cursorRing.value.style.left = ringX + 'px'; cursorRing.value.style.top = ringY + 'px' }
    requestAnimationFrame(animateRing)
  })()

  // Reveal on scroll
  const io = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.style.opacity   = '1'
        e.target.style.transform = 'translateY(0) scale(1)'
        io.unobserve(e.target)
      }
    })
  }, { threshold: 0.08 })

  document.querySelectorAll('[data-reveal]').forEach(el => {
    el.style.opacity    = '0'
    el.style.transform  = 'translateY(32px)'
    el.style.transition = 'opacity 0.85s cubic-bezier(0.16,1,0.3,1), transform 0.85s cubic-bezier(0.16,1,0.3,1)'
    el.style.transitionDelay = el.dataset.delay ?? '0s'
    io.observe(el)
  })
})

onBeforeUnmount(() => { lenis?.destroy(); if (rafId) cancelAnimationFrame(rafId) })
</script>