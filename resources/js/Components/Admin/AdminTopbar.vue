<template>
  <header style="height:64px; background:white; border-bottom:1px solid rgba(13,27,42,0.06); display:flex; align-items:center; padding:0 28px; gap:16px; position:sticky; top:0; z-index:20; flex-shrink:0;">

    <!-- Burger mobile -->
    <button
      @click="$emit('open-mobile')"
      style="width:34px; height:34px; border-radius:9px; border:1.5px solid rgba(13,27,42,0.1); background:transparent; display:none; align-items:center; justify-content:center; color:rgba(13,27,42,0.5); cursor:pointer; flex-shrink:0; transition:all 0.2s;"
      class="mobile-burger topbar-btn"
      aria-label="Menu"
    >
      <PhList style="width:16px; height:16px;" />
    </button>

    <!-- Breadcrumb -->
    <div style="display:flex; align-items:center; gap:8px; flex:1; min-width:0; overflow:hidden;">
      <span style="font-size:13px; color:rgba(13,27,42,0.4);">Admin</span>
      <span style="font-size:13px; color:rgba(13,27,42,0.25);">/</span>
      <span style="font-size:13px; font-weight:700; color:#0D1B2A; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
        {{ pageTitle }}
      </span>
    </div>

    <!-- Actions -->
    <div style="display:flex; align-items:center; gap:8px; flex-shrink:0;">

      <!-- Notifications -->
      <Link
        :href="route('admin.contacts.index')"
        style="position:relative; width:34px; height:34px; border-radius:9px; border:1.5px solid rgba(13,27,42,0.1); display:flex; align-items:center; justify-content:center; color:rgba(13,27,42,0.5); text-decoration:none; transition:all 0.2s;"
        class="topbar-btn"
      >
        <PhBell style="width:16px; height:16px;" />
        <span
          v-if="unreadContacts > 0"
          style="position:absolute; top:-5px; right:-5px; min-width:16px; height:16px; background:#EF4444; color:white; font-size:9px; font-weight:800; border-radius:100px; display:flex; align-items:center; justify-content:center; padding:0 4px; border:2px solid white; line-height:1;"
        >
          {{ unreadContacts > 9 ? '9+' : unreadContacts }}
        </span>
      </Link>

      <!-- Divider -->
      <div style="width:1px; height:24px; background:rgba(13,27,42,0.08);" />

      <!-- Voir le site -->
      <a
        :href="route('home')"
        target="_blank"
        style="display:flex; align-items:center; gap:6px; height:34px; padding:0 14px; border-radius:9px; border:1.5px solid rgba(13,27,42,0.1); color:rgba(13,27,42,0.6); font-size:12px; font-weight:700; text-decoration:none; transition:all 0.2s; white-space:nowrap;"
        class="topbar-btn view-site"
      >
        <PhArrowSquareOut style="width:14px; height:14px;" />
        Voir le site
      </a>

      <!-- Avatar -->
      <Link
        :href="route('admin.profile.edit')"
        style="display:flex; align-items:center; gap:8px; height:34px; padding:0 10px 0 6px; border-radius:9px; border:1.5px solid rgba(13,27,42,0.08); text-decoration:none; transition:all 0.2s;"
        class="topbar-btn user-pill"
      >
        <img
          :src="$page.props.auth?.user?.avatar_url"
          :alt="$page.props.auth?.user?.full_name"
          style="width:24px; height:24px; border-radius:50%; object-fit:cover;"
        />
        <span style="font-size:12px; font-weight:700; color:#0D1B2A; max-width:100px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
          {{ $page.props.auth?.user?.first_name }}
        </span>
        <PhCaretDown style="width:11px; height:11px; color:rgba(13,27,42,0.3);" />
      </Link>
    </div>
  </header>
</template>

<script setup>
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { PhList, PhBell, PhArrowSquareOut, PhCaretDown } from '@phosphor-icons/vue'

defineEmits(['open-mobile'])

const page = usePage()

const pageTitles = {
  'Admin/Dashboard':        'Tableau de bord',
  'Admin/Formations/Index': 'Formations',
  'Admin/Formations/Form':  'Formations',
  'Admin/Articles/Index':   'Articles',
  'Admin/Articles/Form':    'Articles',
  'Admin/Reviews/Index':    'Avis clients',
  'Admin/Contacts/Index':   'Formulaires',
  'Admin/Contacts/Show':    'Message',
  'Admin/Users/Index':      'Utilisateurs',
  'Admin/Users/Form':       'Utilisateurs',
  'Admin/Roles/Index':      'Rôles',
  'Admin/Roles/Form':       'Rôles',
  'Admin/Logs/Index':       'Logs',
  'Admin/Profile':          'Mon profil',
}

const pageTitle      = computed(() => pageTitles[page.component] ?? 'Administration')
const unreadContacts = computed(() => page.props.stats?.unread_contacts ?? 0)
</script>

<style scoped>
.topbar-btn:hover { background:#F4F6FA !important; color:#0D1B2A !important; border-color:rgba(13,27,42,0.18) !important; }
.user-pill:hover  { background:#F4F6FA !important; }
.view-site:hover  { background:#F4F6FA !important; color:#0D1B2A !important; }

@media (max-width:1023px) {
  .mobile-burger { display:flex !important; }
  .view-site     { display:none !important; }
}
</style>