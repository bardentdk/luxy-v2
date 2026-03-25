<template>
  <AdminLayout>
    <Head title="Formulaires de contact" />

    <div style="display:flex; flex-direction:column; gap:24px;">
      <div>
        <h1 style="font-size:24px; font-weight:900; color:#0D1B2A; letter-spacing:-0.02em;">Formulaires de contact</h1>
        <p style="font-size:14px; color:rgba(13,27,42,0.45); margin-top:4px;">{{ contacts.total }} message{{ contacts.total > 1 ? 's' : '' }} reçu{{ contacts.total > 1 ? 's' : '' }}</p>
      </div>

      <!-- Filtres -->
      <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
        <button v-for="s in statuses" :key="s.value" @click="setStatus(s.value)" :style="currentStatus === s.value ? activePillStyle : pillStyle">
          {{ s.label }}
        </button>
        <div style="position:relative; margin-left:auto;">
          <PhMagnifyingGlass style="width:16px; height:16px; position:absolute; left:12px; top:50%; transform:translateY(-50%); color:rgba(13,27,42,0.35);" />
          <input v-model="searchQuery" @input="doSearch" type="text" placeholder="Rechercher..." style="padding:9px 12px 9px 36px; border:1.5px solid rgba(13,27,42,0.1); border-radius:10px; font-size:14px; color:#0D1B2A; outline:none; font-family:inherit; background:white;" />
        </div>
      </div>

      <!-- Tableau -->
      <div style="background:white; border-radius:20px; overflow:hidden; box-shadow:0 1px 8px rgba(13,27,42,0.06);">
        <table style="width:100%; border-collapse:collapse;">
          <thead>
            <tr style="border-bottom:1.5px solid rgba(13,27,42,0.07);">
              <th style="padding:14px 20px; text-align:left; font-size:12px; font-weight:700; color:rgba(13,27,42,0.4); letter-spacing:0.06em; text-transform:uppercase;">Expéditeur</th>
              <th style="padding:14px 20px; text-align:left; font-size:12px; font-weight:700; color:rgba(13,27,42,0.4); letter-spacing:0.06em; text-transform:uppercase;">Objet</th>
              <th style="padding:14px 20px; text-align:left; font-size:12px; font-weight:700; color:rgba(13,27,42,0.4); letter-spacing:0.06em; text-transform:uppercase;">Date</th>
              <th style="padding:14px 20px; text-align:left; font-size:12px; font-weight:700; color:rgba(13,27,42,0.4); letter-spacing:0.06em; text-transform:uppercase;">Statut</th>
              <th style="padding:14px 20px; text-align:right; font-size:12px; font-weight:700; color:rgba(13,27,42,0.4); letter-spacing:0.06em; text-transform:uppercase;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="!contacts.data?.length">
              <td colspan="5" style="padding:60px; text-align:center; color:rgba(13,27,42,0.35); font-size:14px;">Aucun message</td>
            </tr>
            <tr
              v-for="c in contacts.data"
              :key="c.id"
              style="border-bottom:1px solid rgba(13,27,42,0.05);"
              class="table-row"
              :style="!c.is_read ? 'background:#FFFBF0;' : ''"
            >
              <td style="padding:14px 20px;">
                <div>
                  <div style="font-size:14px; font-weight:700; color:#0D1B2A; display:flex; align-items:center; gap:8px;">
                    <span v-if="!c.is_read" style="width:7px; height:7px; border-radius:50%; background:#C9A84C; flex-shrink:0; display:inline-block;" />
                    {{ c.full_name }}
                  </div>
                  <div style="font-size:12px; color:rgba(13,27,42,0.4);">{{ c.email }}</div>
                  <div v-if="c.phone" style="font-size:12px; color:rgba(13,27,42,0.4);">{{ c.phone }}</div>
                </div>
              </td>
              <td style="padding:14px 20px;">
                <div style="font-size:14px; color:#0D1B2A; max-width:260px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ c.subject }}</div>
                <div v-if="c.formation_interest" style="font-size:12px; color:#C9A84C; margin-top:2px;">Formation : {{ c.formation_interest }}</div>
              </td>
              <td style="padding:14px 20px; font-size:13px; color:rgba(13,27,42,0.5);">
                {{ new Date(c.created_at).toLocaleDateString('fr-FR') }}
              </td>
              <td style="padding:14px 20px;">
                <div style="display:flex; flex-direction:column; gap:4px;">
                  <span :style="c.is_read ? 'background:#F1F5F9; color:#64748B; font-size:11px; font-weight:700; padding:3px 8px; border-radius:6px;' : 'background:#FEF9C3; color:#854D0E; font-size:11px; font-weight:700; padding:3px 8px; border-radius:6px;'">
                    {{ c.is_read ? 'Lu' : 'Non lu' }}
                  </span>
                  <span :style="c.is_replied ? 'background:#DCFCE7; color:#166534; font-size:11px; font-weight:700; padding:3px 8px; border-radius:6px;' : 'background:#FEE2E2; color:#991B1B; font-size:11px; font-weight:700; padding:3px 8px; border-radius:6px;'">
                    {{ c.is_replied ? 'Répondu' : 'Sans réponse' }}
                  </span>
                </div>
              </td>
              <td style="padding:14px 20px;">
                <div style="display:flex; align-items:center; justify-content:flex-end; gap:8px;">
                  <Link :href="route('admin.contacts.show', c.id)" class="admin-icon-btn" title="Voir">
                    <PhEye style="width:15px; height:15px;" />
                  </Link>
                  <button @click="markReplied(c)" class="admin-icon-btn" title="Marquer répondu" v-if="!c.is_replied">
                    <PhCheck style="width:15px; height:15px; color:#22c55e;" />
                  </button>
                  <button @click="deleteContact(c)" class="admin-icon-btn admin-icon-btn-danger" title="Supprimer">
                    <PhTrash style="width:15px; height:15px;" />
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { PhMagnifyingGlass, PhEye, PhCheck, PhTrash } from '@phosphor-icons/vue'

const props = defineProps({ contacts: Object })

const currentStatus = ref('')
const searchQuery   = ref('')

const statuses = [
  { label: 'Tous', value: '' },
  { label: 'Non lus', value: 'unread' },
  { label: 'Sans réponse', value: 'unreplied' },
]

const pillStyle       = 'padding:8px 16px; border-radius:100px; font-size:13px; font-weight:600; border:1.5px solid rgba(13,27,42,0.12); background:white; color:rgba(13,27,42,0.6); cursor:pointer; transition:all 0.2s;'
const activePillStyle = 'padding:8px 16px; border-radius:100px; font-size:13px; font-weight:700; border:1.5px solid #0D1B2A; background:#0D1B2A; color:white; cursor:pointer; transition:all 0.2s;'

function setStatus(s) {
  currentStatus.value = s
  router.get(route('admin.contacts.index'), { status: s || undefined, search: searchQuery.value || undefined }, { preserveState:true, replace:true })
}

function doSearch() {
  router.get(route('admin.contacts.index'), { search: searchQuery.value || undefined, status: currentStatus.value || undefined }, { preserveState:true, replace:true })
}

function markReplied(c) { router.patch(route('admin.contacts.replied', c.id)) }
function deleteContact(c) { if (confirm('Supprimer ce message ?')) router.delete(route('admin.contacts.destroy', c.id)) }
</script>

<style scoped>
.table-row:hover { background:#FAF7F2 !important; }
.admin-icon-btn { width:32px; height:32px; border-radius:8px; border:1.5px solid rgba(13,27,42,0.1); background:white; display:inline-flex; align-items:center; justify-content:center; color:rgba(13,27,42,0.5); cursor:pointer; transition:all 0.2s; text-decoration:none; }
.admin-icon-btn:hover { background:#FAF7F2; color:#0D1B2A; }
.admin-icon-btn-danger:hover { background:#FEE2E2 !important; color:#EF4444 !important; border-color:#FCA5A5 !important; }
</style>