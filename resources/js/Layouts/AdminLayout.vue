<template>
  <div style="min-height:100vh; background:#F1F3F7; display:flex; overflow:hidden;">

    <!-- Sidebar desktop -->
    <AdminSidebar
      :collapsed="collapsed"
      :mobile-open="mobileOpen"
      @toggle="collapsed = !collapsed"
      @close-mobile="mobileOpen = false"
    />

    <!-- Overlay mobile uniquement -->
    <Transition name="overlay">
      <div
        v-if="mobileOpen"
        style="position:fixed; inset:0; background:rgba(10,22,40,0.55); z-index:35; backdrop-filter:blur(2px);"
        @click="mobileOpen = false"
      />
    </Transition>

    <!-- Zone principale : margin dynamique selon état sidebar -->
    <div
      style="flex:1; display:flex; flex-direction:column; min-width:0; transition:margin-left 0.3s cubic-bezier(0.4,0,0.2,1);"
      :style="{ marginLeft: isMobile ? '0' : (collapsed ? '64px' : '260px') }"
    >
      <!-- Topbar -->
      <AdminTopbar
        :collapsed="collapsed"
        @open-mobile="mobileOpen = true"
      />

      <!-- Flash messages -->
      <FlashMessages />

      <!-- Contenu de la page -->
      <main style="flex:1; padding:28px 32px 40px; overflow-y:auto; min-height:0;">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import AdminSidebar from '@/Components/Admin/AdminSidebar.vue'
import AdminTopbar from '@/Components/Admin/AdminTopbar.vue'
import FlashMessages from '@/Components/Shared/FlashMessages.vue'

const collapsed   = ref(false)
const mobileOpen  = ref(false)
const isMobile    = ref(false)

function checkMobile() {
  isMobile.value = window.innerWidth < 1024
  if (!isMobile.value) mobileOpen.value = false
}

onMounted(() => {
  checkMobile()
  window.addEventListener('resize', checkMobile)

  // Restaurer l'état collapsed depuis localStorage
  const saved = localStorage.getItem('luxy_sidebar_collapsed')
  if (saved !== null) collapsed.value = saved === 'true'
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', checkMobile)
})

// Persister l'état
import { watch } from 'vue'
watch(collapsed, (val) => localStorage.setItem('luxy_sidebar_collapsed', val))
</script>

<style scoped>
.overlay-enter-active, .overlay-leave-active { transition: opacity 0.25s ease; }
.overlay-enter-from, .overlay-leave-to       { opacity: 0; }
</style>