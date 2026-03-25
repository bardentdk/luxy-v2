<template>
  <header
    ref="headerRef"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-500"
    :style="{
      background: scrolled ? 'rgba(255,255,255,0.97)' : 'transparent',
      backdropFilter: scrolled ? 'blur(12px)' : 'none',
      boxShadow: scrolled ? '0 2px 24px rgba(13,27,42,0.08)' : 'none',
      padding: scrolled ? '12px 0' : '20px 0',
    }"
  >
    <nav style="max-width:1280px; margin:0 auto; padding:0 2rem; display:flex; align-items:center; justify-content:space-between; gap:1rem;">

      <!-- Logo -->
      <Link :href="route('home')" style="display:flex; align-items:center; gap:12px; text-decoration:none; flex-shrink:0;">
        <img src="https://luxyformation.re/wp-content/uploads/2024/03/cropped-horizontal_luxy_logo-300x97.png" alt="" class="w-40">
        <!-- <div style="width:40px; height:40px; border-radius:10px; background:#C9A84C; display:flex; align-items:center; justify-content:center;">
          <span style="color:#0D1B2A; font-weight:900; font-size:18px;">L</span>
        </div>
        <div>
          <span
            style="font-weight:800; font-size:17px; display:block; line-height:1.2;"
            :style="{ color: scrolled ? '#0D1B2A' : '#ffffff' }"
          >Luxy</span>
          <span style="color:#C9A84C; font-size:10px; letter-spacing:0.15em; text-transform:uppercase; display:block;">Formation</span>
        </div> -->
      </Link>

      <!-- Menu desktop -->
      <ul style="display:flex; align-items:center; gap:4px; list-style:none; margin:0; padding:0;" class="desktop-menu">
        <li v-for="item in menuItems" :key="item.name">
          <Link
            :href="route(item.route)"
            style="display:block; padding:8px 16px; border-radius:999px; font-size:14px; font-weight:500; text-decoration:none; transition:all 0.3s;"
            :style="{
              color: isActive(item.route)
                ? (scrolled ? '#0D1B2A' : '#ffffff')
                : (scrolled ? 'rgba(13,27,42,0.65)' : 'rgba(255,255,255,0.75)'),
              background: isActive(item.route)
                ? (scrolled ? '#F4F1EC' : 'rgba(255,255,255,0.15)')
                : 'transparent',
            }"
          >
            {{ item.name }}
          </Link>
        </li>
      </ul>

      <!-- Actions -->
      <div style="display:flex; align-items:center; gap:12px; flex-shrink:0;">
        <!-- Lien admin si connecté -->
        <Link
          v-if="$page.props.auth?.user?.is_admin"
          :href="route('admin.dashboard')"
          style="display:flex; align-items:center; gap:6px; font-size:13px; font-weight:600; text-decoration:none; transition:color 0.3s;"
          :style="{ color: scrolled ? '#0D1B2A' : '#ffffff' }"
        >
          <PhShieldCheck style="width:18px; height:18px; color:#C9A84C;" weight="fill" />
          <span>Admin</span>
        </Link>

        <!-- Bouton contact -->
        <Link
          :href="route('contact')"
          style="display:inline-flex; align-items:center; gap:8px; background:#C9A84C; color:#0D1B2A; font-weight:700; font-size:14px; padding:10px 22px; border-radius:999px; text-decoration:none; transition:all 0.3s; white-space:nowrap;"
          class="desktop-only"
        >
          <PhEnvelope style="width:16px; height:16px;" />
          Nous contacter
        </Link>

        <!-- Burger mobile -->
        <button
          @click="mobileMenuOpen = !mobileMenuOpen"
          style="padding:8px; border-radius:10px; border:none; cursor:pointer; transition:all 0.3s; display:none;"
          :style="{
            background: 'transparent',
            color: scrolled ? '#0D1B2A' : '#ffffff',
          }"
          class="mobile-burger"
          aria-label="Menu"
        >
          <PhList v-if="!mobileMenuOpen" style="width:24px; height:24px;" />
          <PhX v-else style="width:24px; height:24px;" />
        </button>
      </div>
    </nav>

    <!-- Menu mobile -->
    <Transition name="mobile-menu">
      <div
        v-if="mobileMenuOpen"
        style="background:white; border-top:1px solid rgba(0,0,0,0.07); box-shadow:0 10px 40px rgba(13,27,42,0.12);"
      >
        <div style="max-width:1280px; margin:0 auto; padding:1.5rem 2rem; display:flex; flex-direction:column; gap:8px;">
          <Link
            v-for="item in menuItems"
            :key="item.name"
            :href="route(item.route)"
            @click="mobileMenuOpen = false"
            style="display:flex; align-items:center; gap:12px; padding:12px 16px; border-radius:12px; font-size:14px; font-weight:500; text-decoration:none; transition:all 0.2s;"
            :style="{
              background: isActive(item.route) ? '#0D1B2A' : 'transparent',
              color: isActive(item.route) ? '#ffffff' : 'rgba(13,27,42,0.7)',
            }"
          >
            <component :is="item.icon" style="width:18px; height:18px;" />
            {{ item.name }}
          </Link>
          <Link
            :href="route('contact')"
            @click="mobileMenuOpen = false"
            style="display:flex; align-items:center; justify-content:center; gap:8px; background:#C9A84C; color:#0D1B2A; font-weight:700; font-size:14px; padding:14px; border-radius:999px; text-decoration:none; margin-top:8px;"
          >
            <PhEnvelope style="width:16px; height:16px;" />
            Nous contacter
          </Link>
        </div>
      </div>
    </Transition>
  </header>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import {
  PhHouse, PhStar, PhBookOpen, PhGraduationCap,
  PhEnvelope, PhList, PhX, PhShieldCheck, PhUsers,
} from '@phosphor-icons/vue'

const page     = usePage()
const scrolled = ref(false)
const mobileMenuOpen = ref(false)

const menuItems = [
  { name: 'Accueil',          route: 'home',             icon: PhHouse },
  { name: 'La vie du centre', route: 'articles.index',   icon: PhUsers },
  { name: 'Nos formations',   route: 'formations.index', icon: PhGraduationCap },
  { name: 'Vos avis',         route: 'reviews.index',    icon: PhStar },
]

function isActive(routeName) {
  try {
    const path = new URL(route(routeName)).pathname
    return window.location.pathname === path || window.location.pathname.startsWith(path + '/')
  } catch {
    return false
  }
}

function handleScroll() {
  scrolled.value = window.scrollY > 30
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll, { passive: true })
  handleScroll()
})

onBeforeUnmount(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped>
@media (max-width: 1023px) {
  .desktop-menu  { display: none !important; }
  .desktop-only  { display: none !important; }
  .mobile-burger { display: flex !important; }
}
@media (min-width: 1024px) {
  .mobile-burger { display: none !important; }
  .desktop-menu  { display: flex !important; }
  .desktop-only  { display: inline-flex !important; }
}

.mobile-menu-enter-active,
.mobile-menu-leave-active { transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
.mobile-menu-enter-from,
.mobile-menu-leave-to     { opacity: 0; transform: translateY(-8px); }
</style>