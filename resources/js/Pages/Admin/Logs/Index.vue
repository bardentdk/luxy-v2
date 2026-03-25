<template>
  <AdminLayout>
    <Head title="Logs d'activité" />

    <div style="display:flex; flex-direction:column; gap:24px;">
      <div>
        <h1 style="font-size:24px; font-weight:900; color:#0D1B2A; letter-spacing:-0.02em;">Logs d'activité</h1>
        <p style="font-size:14px; color:rgba(13,27,42,0.45); margin-top:4px;">Historique complet des actions effectuées</p>
      </div>

      <!-- Filtres -->
      <div style="background:white; border-radius:16px; padding:16px 20px; display:flex; gap:12px; align-items:center; box-shadow:0 1px 8px rgba(13,27,42,0.06); flex-wrap:wrap;">
        <select v-model="logNameFilter" @change="doFilter" style="padding:9px 14px; border:1.5px solid rgba(13,27,42,0.1); border-radius:10px; font-size:14px; color:#0D1B2A; outline:none; font-family:inherit; background:white; cursor:pointer;">
          <option value="">Tous les types</option>
          <option value="formation">Formations</option>
          <option value="article">Articles</option>
          <option value="default">Autre</option>
        </select>
      </div>

      <!-- Timeline de logs -->
      <div style="background:white; border-radius:20px; padding:28px; box-shadow:0 1px 8px rgba(13,27,42,0.06); display:flex; flex-direction:column; gap:0;">
        <div v-if="!logs.data?.length" style="text-align:center; padding:60px; color:rgba(13,27,42,0.35); font-size:14px;">
          Aucun log disponible
        </div>
        <div
          v-for="(log, i) in logs.data"
          :key="log.id"
          style="display:flex; gap:20px; padding:16px 0;"
          :style="i < logs.data.length - 1 ? 'border-bottom:1px solid rgba(13,27,42,0.05);' : ''"
        >
          <!-- Icône type -->
          <div style="flex-shrink:0; display:flex; flex-direction:column; align-items:center; gap:8px;">
            <div :style="`width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; ${getLogColor(log.log_name)}`">
              <PhActivity style="width:16px; height:16px;" />
            </div>
          </div>
          <!-- Détails -->
          <div style="flex:1; min-width:0;">
            <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:12px; flex-wrap:wrap;">
              <div>
                <span style="font-size:14px; font-weight:700; color:#0D1B2A;">{{ log.description }}</span>
                <span v-if="log.causer" style="font-size:13px; color:rgba(13,27,42,0.5); margin-left:8px;">par {{ log.causer.full_name }}</span>
              </div>
              <span style="font-size:12px; color:rgba(13,27,42,0.35); flex-shrink:0;">{{ log.created_at }}</span>
            </div>
            <div v-if="log.log_name" style="margin-top:4px;">
              <span :style="`font-size:11px; font-weight:700; padding:2px 8px; border-radius:4px; ${getLogColor(log.log_name)}`">
                {{ log.log_name }}
              </span>
            </div>
            <div v-if="log.properties?.attributes" style="margin-top:8px; padding:10px 14px; background:#FAF7F2; border-radius:8px; font-size:12px; font-family:monospace; color:rgba(13,27,42,0.6); overflow:auto; max-height:80px;">
              {{ JSON.stringify(log.properties.attributes, null, 2) }}
            </div>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="logs.last_page > 1" style="display:flex; justify-content:center; gap:8px;">
        <button
          v-for="page in Math.min(logs.last_page, 10)"
          :key="page"
          @click="goToPage(page)"
          :style="page === logs.current_page ? 'padding:8px 14px; border-radius:10px; font-size:13px; font-weight:700; border:none; background:#0D1B2A; color:white; cursor:pointer;' : 'padding:8px 14px; border-radius:10px; font-size:13px; font-weight:600; border:1.5px solid rgba(13,27,42,0.12); background:white; color:rgba(13,27,42,0.6); cursor:pointer;'"
        >
          {{ page }}
        </button>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { PhActivity } from '@phosphor-icons/vue'

const props = defineProps({ logs: Object })

const logNameFilter = ref('')

function getLogColor(name) {
  const map = {
    formation: 'background:rgba(59,130,246,0.1); color:#1D4ED8;',
    article:   'background:rgba(139,92,246,0.1); color:#6D28D9;',
    default:   'background:rgba(13,27,42,0.08); color:rgba(13,27,42,0.6);',
  }
  return map[name] ?? map.default
}

function doFilter() {
  router.get(route('admin.logs.index'), { log_name: logNameFilter.value || undefined }, { preserveState:true, replace:true })
}

function goToPage(page) {
  router.get(route('admin.logs.index'), { page }, { preserveState:true })
}
</script>