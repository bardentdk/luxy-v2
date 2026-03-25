<template>
  <!-- Desktop sidebar -->
  <aside
    style="position:fixed; top:0; left:0; bottom:0; z-index:40; display:flex; flex-direction:column; background:#0D1B2A; transition:width 0.3s cubic-bezier(0.4,0,0.2,1); overflow:hidden;"
    :style="{ width: isMobile ? (mobileOpen ? '260px' : '0px') : (collapsed ? '64px' : '260px') }"
    class="admin-sidebar"
  >
    <!-- Logo / Toggle -->
    <div
      style="height:64px; display:flex; align-items:center; justify-content:space-between; padding:0 14px; border-bottom:1px solid rgba(255,255,255,0.06); flex-shrink:0; overflow:hidden;"
    >
      <!-- Logo complet -->
      <div style="display:flex; align-items:center; gap:10px; overflow:hidden;">
        <div style="width:34px; height:34px; border-radius:9px; background:linear-gradient(135deg,#C9A84C,#E2C97E); display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 2px 8px rgba(201,168,76,0.35);">
          <span style="color:#0D1B2A; font-weight:900; font-size:16px; line-height:1;">L</span>
        </div>
        <Transition name="label">
          <div v-if="!collapsed || isMobile" style="overflow:hidden; white-space:nowrap;">
            <span style="font-weight:800; font-size:15px; color:white; display:block; line-height:1.2;">Luxy</span>
            <span style="color:#C9A84C; font-size:9px; letter-spacing:0.2em; text-transform:uppercase;">Administration</span>
          </div>
        </Transition>
      </div>

      <!-- Bouton toggle desktop -->
      <button
        v-if="!isMobile"
        @click="$emit('toggle')"
        style="width:28px; height:28px; border-radius:8px; border:1px solid rgba(255,255,255,0.1); background:rgba(255,255,255,0.05); color:rgba(255,255,255,0.5); cursor:pointer; display:flex; align-items:center; justify-content:center; flex-shrink:0; transition:all 0.2s;"
        class="toggle-btn"
      >
        <PhSidebarSimple style="width:14px; height:14px;" :weight="collapsed ? 'fill' : 'regular'" />
      </button>

      <!-- Bouton fermer mobile -->
      <button
        v-if="isMobile && mobileOpen"
        @click="$emit('close-mobile')"
        style="width:28px; height:28px; border-radius:8px; border:1px solid rgba(255,255,255,0.1); background:rgba(255,255,255,0.05); color:rgba(255,255,255,0.5); cursor:pointer; display:flex; align-items:center; justify-content:center; flex-shrink:0; transition:all 0.2s;"
        class="toggle-btn"
      >
        <PhX style="width:14px; height:14px;" />
      </button>
    </div>

    <!-- Navigation -->
    <nav style="flex:1; overflow-y:auto; overflow-x:hidden; padding:12px 8px; scrollbar-width:none;">
      <template v-for="section in menuSections" :key="section.title">
        <!-- Label section -->
        <div
          style="overflow:hidden; transition:all 0.3s;"
          :style="{ height: !collapsed || isMobile ? '28px' : '8px' }"
        >
          <p
            v-if="!collapsed || isMobile"
            style="font-size:10px; font-weight:700; letter-spacing:0.18em; text-transform:uppercase; color:rgba(255,255,255,0.2); padding:0 10px; margin:0; line-height:28px; white-space:nowrap;"
          >
            {{ section.title }}
          </p>
          <div v-else style="height:8px;" />
        </div>

        <!-- Items -->
        <div style="display:flex; flex-direction:column; gap:1px; margin-bottom:4px;">
          <SidebarItem
            v-for="item in section.items"
            :key="item.route"
            :item="item"
            :active="isActive(item.route)"
            :collapsed="collapsed && !isMobile"
          />
        </div>
      </template>
    </nav>

    <!-- User footer -->
    <div style="border-top:1px solid rgba(255,255,255,0.06); padding:10px 8px; flex-shrink:0; overflow:hidden;">
      <Link
        :href="route('admin.profile.edit')"
        style="display:flex; align-items:center; gap:10px; padding:10px; border-radius:10px; text-decoration:none; transition:background 0.2s; overflow:hidden; white-space:nowrap;"
        class="user-link"
      >
        <img
          :src="$page.props.auth?.user?.avatar_url"
          :alt="$page.props.auth?.user?.full_name"
          style="width:30px; height:30px; border-radius:50%; object-fit:cover; flex-shrink:0; border:2px solid rgba(201,168,76,0.4);"
        />
        <Transition name="label">
          <div v-if="!collapsed || isMobile" style="flex:1; min-width:0;">
            <p style="font-size:12px; font-weight:700; color:white; margin:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; line-height:1.3;">
              {{ $page.props.auth?.user?.full_name }}
            </p>
            <p style="font-size:10px; color:rgba(255,255,255,0.35); margin:0; white-space:nowrap; line-height:1.4;">
              {{ $page.props.auth?.user?.role?.name }}
            </p>
          </div>
        </Transition>
      </Link>

      <form @submit.prevent="logout">
        <button
          type="submit"
          style="width:100%; display:flex; align-items:center; gap:10px; padding:9px 10px; border-radius:10px; border:none; background:transparent; cursor:pointer; font-family:inherit; transition:all 0.2s; overflow:hidden; white-space:nowrap;"
          :style="{ justifyContent: (collapsed && !isMobile) ? 'center' : 'flex-start' }"
          class="logout-btn"
        >
          <PhSignOut style="width:15px; height:15px; flex-shrink:0;" />
          <Transition name="label">
            <span v-if="!collapsed || isMobile" style="font-size:12px; font-weight:600; color:rgba(255,255,255,0.4);">
              Déconnexion
            </span>
          </Transition>
        </button>
      </form>
    </div>
  </aside>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import {
  PhGauge, PhGraduationCap, PhNewspaper, PhStar, PhEnvelope,
  PhUsers, PhShieldStar, PhClipboardText, PhSignOut,
  PhSidebarSimple, PhX, PhTag,
} from '@phosphor-icons/vue'
import SidebarItem from './SidebarItem.vue'

const props = defineProps({
  collapsed:  { type: Boolean, default: false },
  mobileOpen: { type: Boolean, default: false },
})
defineEmits(['toggle', 'close-mobile'])

const isMobile = ref(false)

function checkMobile() {
  isMobile.value = window.innerWidth < 1024
}

onMounted(() => {
  checkMobile()
  window.addEventListener('resize', checkMobile)
})
onBeforeUnmount(() => window.removeEventListener('resize', checkMobile))

const menuSections = [
  {
    title: 'Principal',
    items: [{ name: 'Tableau de bord', route: 'admin.dashboard', icon: PhGauge }],
  },
  {
    title: 'Contenu',
    items: [
      { name: 'Formations',   route: 'admin.formations.index',            icon: PhGraduationCap },
      { name: 'Catégories',   route: 'admin.formations.categories.index', icon: PhTag },
      { name: 'Articles',     route: 'admin.articles.index',              icon: PhNewspaper },
      { name: 'Avis',         route: 'admin.reviews.index',               icon: PhStar },
    ],
  },
  {
    title: 'Communications',
    items: [{ name: 'Formulaires', route: 'admin.contacts.index', icon: PhEnvelope }],
  },
  {
    title: 'Gestion',
    items: [
      { name: 'Utilisateurs', route: 'admin.users.index',  icon: PhUsers },
      { name: 'Rôles',        route: 'admin.roles.index',  icon: PhShieldStar },
      { name: 'Logs',         route: 'admin.logs.index',   icon: PhClipboardText },
    ],
  },
]

function isActive(routeName) {
  try {
    const path = new URL(route(routeName)).pathname
    return window.location.pathname === path
        || window.location.pathname.startsWith(path + '/')
  } catch { return false }
}

function logout() {
  router.post(route('auth.logout'))
}
</script>

<style scoped>
.admin-sidebar::-webkit-scrollbar { display: none; }
nav::-webkit-scrollbar            { display: none; }

.toggle-btn:hover { background:rgba(255,255,255,0.12) !important; color:white !important; }
.user-link:hover  { background:rgba(255,255,255,0.06); }
.logout-btn:hover { background:rgba(239,68,68,0.1) !important; }
.logout-btn:hover span { color:#F87171 !important; }
.logout-btn:hover svg { color:#F87171; }

.label-enter-active { transition: opacity 0.15s ease 0.1s, transform 0.15s ease 0.1s; }
.label-leave-active { transition: opacity 0.1s ease, transform 0.1s ease; }
.label-enter-from, .label-leave-to { opacity: 0; transform: translateX(-8px); }
</style>