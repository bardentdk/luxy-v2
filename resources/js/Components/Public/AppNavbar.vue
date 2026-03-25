<template>
  <header
    style="position:fixed; top:0; left:0; right:0; z-index:1000; transition:all 0.5s cubic-bezier(0.16,1,0.3,1);"
    :style="scrolled
      ? 'background:rgba(255,255,255,0.94); backdrop-filter:blur(24px); box-shadow:0 1px 0 rgba(13,27,42,0.07), 0 4px 24px rgba(13,27,42,0.06); padding:10px 0;'
      : 'background:transparent; padding:22px 0;'"
  >
    <nav style="max-width:1400px; margin:0 auto; padding:0 3rem; display:flex; align-items:center; gap:40px;">

      <!-- Logo -->
      <Link :href="route('home')" style="display:flex; align-items:center; gap:12px; text-decoration:none; flex-shrink:0;">
        <div style="position:relative;">
          <div style="width:38px; height:38px; border-radius:11px; background:linear-gradient(135deg,#C9A84C,#E2C97E); display:flex; align-items:center; justify-content:center; position:relative; z-index:1; box-shadow:0 4px 16px rgba(201,168,76,0.4);">
            <span style="font-family:'Syne',sans-serif; font-weight:800; font-size:18px; color:#0D1B2A; line-height:1;">L</span>
          </div>
          <div style="position:absolute; inset:-4px; border-radius:16px; background:rgba(201,168,76,0.25); filter:blur(10px); z-index:0;" />
        </div>
        <div>
          <span
            style="font-family:'Syne',sans-serif; font-weight:800; font-size:16px; display:block; line-height:1.1; letter-spacing:-0.02em; transition:color 0.3s;"
            :style="scrolled ? 'color:#0D1B2A;' : 'color:#0D1B2A;'"
          >Luxy</span>
          <span style="font-size:9px; color:#C9A84C; letter-spacing:0.22em; text-transform:uppercase; display:block; font-weight:700;">Formation</span>
        </div>
      </Link>

      <!-- Menu desktop -->
      <ul style="display:flex; align-items:center; gap:2px; list-style:none; flex:1;" class="desktop-nav">
        <li v-for="item in menuItems" :key="item.name">
          <Link
            :href="route(item.route)"
            style="position:relative; display:block; padding:8px 16px; border-radius:100px; font-size:14px; font-weight:500; text-decoration:none; transition:all 0.25s; font-family:'DM Sans',sans-serif; letter-spacing:0.01em;"
            :style="isActive(item.route)
              ? 'background:rgba(201,168,76,0.12); color:#0D1B2A; border:1px solid rgba(201,168,76,0.3);'
              : 'color:rgba(13,27,42,0.6); border:1px solid transparent;'"
            class="nav-link"
          >
            {{ item.name }}
            <span
              v-if="isActive(item.route)"
              style="position:absolute; bottom:-1px; left:50%; transform:translateX(-50%); width:4px; height:4px; border-radius:50%; background:#C9A84C;"
            />
          </Link>
        </li>
      </ul>

      <!-- Actions -->
      <div style="display:flex; align-items:center; gap:12px; flex-shrink:0;">

        <!-- Badge admin -->
        <Link
          v-if="$page.props.auth?.user?.is_admin"
          :href="route('admin.dashboard')"
          style="display:flex; align-items:center; gap:6px; font-size:12px; font-weight:700; color:#A07828; text-decoration:none; padding:6px 12px; border-radius:100px; background:rgba(201,168,76,0.1); border:1px solid rgba(201,168,76,0.25); transition:all 0.2s; font-family:'Syne',sans-serif;"
          class="admin-badge"
        >
          <PhShieldCheck style="width:13px; height:13px;" weight="fill" />
          Admin
        </Link>

        <!-- CTA contact -->
        <Link :href="route('contact')" class="btn-gold" style="font-size:13px; padding:10px 22px;" id="nav-cta">
          <PhEnvelope style="width:14px; height:14px;" />
          Nous contacter
        </Link>

        <!-- Burger mobile -->
        <button
          @click="mobileOpen = !mobileOpen"
          style="width:38px; height:38px; border-radius:10px; border:1.5px solid rgba(13,27,42,0.12); background:white; color:rgba(13,27,42,0.6); display:none; align-items:center; justify-content:center; cursor:none; transition:all 0.2s; flex-shrink:0;"
          class="burger-btn"
          aria-label="Menu"
        >
          <PhList v-if="!mobileOpen" style="width:18px; height:18px;" />
          <PhX v-else style="width:18px; height:18px;" />
        </button>
      </div>
    </nav>

    <!-- Menu mobile -->
    <Transition name="mobile-menu">
      <div
        v-if="mobileOpen"
        style="border-top:1px solid rgba(13,27,42,0.07); background:rgba(255,255,255,0.98); backdrop-filter:blur(20px);"
      >
        <div style="max-width:1400px; margin:0 auto; padding:20px 3rem; display:flex; flex-direction:column; gap:4px;">
          <Link
            v-for="item in menuItems"
            :key="item.name"
            :href="route(item.route)"
            @click="mobileOpen = false"
            style="display:flex; align-items:center; gap:12px; padding:14px 16px; border-radius:12px; font-size:15px; font-weight:500; text-decoration:none; transition:all 0.2s;"
            :style="isActive(item.route)
              ? 'background:rgba(201,168,76,0.1); color:#0D1B2A; border:1px solid rgba(201,168,76,0.2);'
              : 'color:rgba(13,27,42,0.6);'"
          >
            <component :is="item.icon" style="width:18px; height:18px; color:#C9A84C;" />
            {{ item.name }}
          </Link>
          <Link
            :href="route('contact')"
            @click="mobileOpen = false"
            class="btn-gold"
            style="justify-content:center; margin-top:8px;"
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
  PhHouse, PhGraduationCap, PhUsers, PhStar,
  PhEnvelope, PhList, PhX, PhShieldCheck,
} from '@phosphor-icons/vue'

const scrolled   = ref(false)
const mobileOpen = ref(false)

const menuItems = [
  { name: 'Accueil',          route: 'home',             icon: PhHouse },
  { name: 'La vie du centre', route: 'articles.index',   icon: PhUsers },
  { name: 'Nos formations',   route: 'formations.index', icon: PhGraduationCap },
  { name: 'Vos avis',         route: 'reviews.index',    icon: PhStar },
]

function isActive(routeName) {
  try {
    return window.location.pathname.startsWith(new URL(route(routeName)).pathname)
  } catch { return false }
}

function onScroll() { scrolled.value = window.scrollY > 40 }
onMounted(() => { window.addEventListener('scroll', onScroll, { passive: true }); onScroll() })
onBeforeUnmount(() => window.removeEventListener('scroll', onScroll))
</script>

<style scoped>
.nav-link:hover { background:rgba(13,27,42,0.05) !important; color:#0D1B2A !important; border-color:rgba(13,27,42,0.1) !important; }
.admin-badge:hover { background:rgba(201,168,76,0.18) !important; }
.mobile-menu-enter-active, .mobile-menu-leave-active { transition: all 0.35s cubic-bezier(0.16,1,0.3,1); }
.mobile-menu-enter-from, .mobile-menu-leave-to { opacity:0; transform:translateY(-10px); }
@media (max-width:1023px) {
  .desktop-nav { display:none !important; }
  .burger-btn  { display:flex !important; }
  #nav-cta     { display:none !important; }
}
</style>