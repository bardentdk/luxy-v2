<template>
  <AdminLayout>
    <Head title="Formations" />

    <div style="display:flex; flex-direction:column; gap:24px;">

      <!-- Header -->
      <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px;">
        <div>
          <h1 style="font-size:24px; font-weight:900; color:#0D1B2A; letter-spacing:-0.02em;">Formations</h1>
          <p style="font-size:14px; color:rgba(13,27,42,0.45); margin-top:4px;">{{ formations.total }} formation{{ formations.total > 1 ? 's' : '' }} au total</p>
        </div>
        <Link :href="route('admin.formations.create')" class="admin-btn-primary">
          <PhPlus style="width:16px; height:16px;" />
          Nouvelle formation
        </Link>
      </div>

      <!-- Filtres -->
      <div style="background:white; border-radius:16px; padding:16px 20px; display:flex; align-items:center; gap:12px; box-shadow:0 1px 8px rgba(13,27,42,0.06); flex-wrap:wrap;">
        <div style="position:relative; flex:1; min-width:180px;">
          <PhMagnifyingGlass style="width:16px; height:16px; color:rgba(13,27,42,0.35); position:absolute; left:12px; top:50%; transform:translateY(-50%);" />
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Rechercher..."
            style="width:100%; padding:9px 12px 9px 36px; border:1.5px solid rgba(13,27,42,0.1); border-radius:10px; font-size:14px; color:#0D1B2A; outline:none; font-family:inherit; background:#FAF7F2; box-sizing:border-box;"
            @input="doSearch"
          />
        </div>
        <select v-model="statusFilter" @change="doSearch" style="padding:9px 14px; border:1.5px solid rgba(13,27,42,0.1); border-radius:10px; font-size:14px; color:#0D1B2A; outline:none; font-family:inherit; background:white; cursor:pointer;">
          <option value="">Tous les statuts</option>
          <option value="published">Publiées</option>
          <option value="draft">Brouillons</option>
        </select>
      </div>

      <!-- Tableau -->
      <div style="background:white; border-radius:20px; overflow:hidden; box-shadow:0 1px 8px rgba(13,27,42,0.06);">
        <table style="width:100%; border-collapse:collapse;">
          <thead>
            <tr style="border-bottom:1.5px solid rgba(13,27,42,0.07);">
              <th style="padding:14px 20px; text-align:left; font-size:12px; font-weight:700; color:rgba(13,27,42,0.4); letter-spacing:0.06em; text-transform:uppercase;">Formation</th>
              <th style="padding:14px 20px; text-align:left; font-size:12px; font-weight:700; color:rgba(13,27,42,0.4); letter-spacing:0.06em; text-transform:uppercase;">Catégorie</th>
              <th style="padding:14px 20px; text-align:left; font-size:12px; font-weight:700; color:rgba(13,27,42,0.4); letter-spacing:0.06em; text-transform:uppercase;">Prix</th>
              <th style="padding:14px 20px; text-align:left; font-size:12px; font-weight:700; color:rgba(13,27,42,0.4); letter-spacing:0.06em; text-transform:uppercase;">Vues</th>
              <th style="padding:14px 20px; text-align:left; font-size:12px; font-weight:700; color:rgba(13,27,42,0.4); letter-spacing:0.06em; text-transform:uppercase;">Statut</th>
              <th style="padding:14px 20px; text-align:right; font-size:12px; font-weight:700; color:rgba(13,27,42,0.4); letter-spacing:0.06em; text-transform:uppercase;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-if="!formations.data?.length"
            >
              <td colspan="6" style="padding:60px; text-align:center; color:rgba(13,27,42,0.35); font-size:14px;">
                Aucune formation trouvée
              </td>
            </tr>
            <tr
              v-for="f in formations.data"
              :key="f.id"
              style="border-bottom:1px solid rgba(13,27,42,0.05); transition:background 0.15s;"
              class="table-row"
            >
              <td style="padding:16px 20px;">
                <div style="display:flex; align-items:center; gap:14px;">
                  <img :src="f.thumbnail_url" :alt="f.title" style="width:52px; height:40px; object-fit:cover; border-radius:10px; flex-shrink:0;" />
                  <div>
                    <div style="font-size:14px; font-weight:700; color:#0D1B2A; margin-bottom:2px;">{{ f.title }}</div>
                    <div style="font-size:12px; color:rgba(13,27,42,0.4);">{{ f.created_at }}</div>
                  </div>
                </div>
              </td>
              <td style="padding:16px 20px;">
                <span v-if="f.category" style="background:#FAF7F2; color:rgba(13,27,42,0.6); font-size:12px; font-weight:600; padding:4px 10px; border-radius:6px;">
                  {{ f.category.name }}
                </span>
                <span v-else style="color:rgba(13,27,42,0.3); font-size:13px;">—</span>
              </td>
              <td style="padding:16px 20px; font-size:14px; font-weight:700; color:#0D1B2A;">
                {{ f.current_price ? f.current_price + '€' : '—' }}
              </td>
              <td style="padding:16px 20px;">
                <span style="display:flex; align-items:center; gap:6px; font-size:13px; color:rgba(13,27,42,0.55);">
                  <PhEye style="width:14px; height:14px;" />
                  {{ f.view_count?.toLocaleString() }}
                </span>
              </td>
              <td style="padding:16px 20px;">
                <span :style="f.is_published ? publishedStyle : draftStyle">
                  {{ f.is_published ? 'Publiée' : 'Brouillon' }}
                </span>
              </td>
              <td style="padding:16px 20px;">
                <div style="display:flex; align-items:center; justify-content:flex-end; gap:8px;">
                  <a :href="route('formations.show', f.slug)" target="_blank" class="admin-icon-btn" title="Voir">
                    <PhArrowSquareOut style="width:15px; height:15px;" />
                  </a>
                  <button @click="togglePublish(f)" class="admin-icon-btn" :title="f.is_published ? 'Dépublier' : 'Publier'">
                    <PhEye v-if="!f.is_published" style="width:15px; height:15px; color:#22c55e;" />
                    <PhEyeSlash v-else style="width:15px; height:15px; color:rgba(13,27,42,0.4);" />
                  </button>
                  <Link :href="route('admin.formations.edit', f.id)" class="admin-icon-btn" title="Modifier">
                    <PhPencil style="width:15px; height:15px;" />
                  </Link>
                  <button @click="confirmDelete(f)" class="admin-icon-btn admin-icon-btn-danger" title="Supprimer">
                    <PhTrash style="width:15px; height:15px;" />
                  </button>
                  <Link
                    :href="route('admin.formations.sessions.index', f.id)"
                    class="admin-icon-btn"
                    title="Sessions"
                  >
                    <PhCalendarBlank style="width:15px; height:15px; color:#8B5CF6;" />
                  </Link>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div v-if="formations.last_page > 1" style="display:flex; justify-content:center; gap:8px;">
        <button
          v-for="page in formations.last_page"
          :key="page"
          @click="goToPage(page)"
          :style="page === formations.current_page ? 'padding:8px 14px; border-radius:10px; font-size:13px; font-weight:700; border:none; background:#0D1B2A; color:white; cursor:pointer;' : 'padding:8px 14px; border-radius:10px; font-size:13px; font-weight:600; border:1.5px solid rgba(13,27,42,0.12); background:white; color:rgba(13,27,42,0.6); cursor:pointer;'"
        >
          {{ page }}
        </button>
      </div>
    </div>

    <!-- Modal confirmation suppression -->
    <div v-if="toDelete" style="position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:1000; display:flex; align-items:center; justify-content:center; padding:20px;" @click.self="toDelete = null">
      <div style="background:white; border-radius:24px; padding:36px; max-width:420px; width:100%; box-shadow:0 24px 80px rgba(0,0,0,0.3);">
        <div style="width:52px; height:52px; border-radius:14px; background:#FEE2E2; display:flex; align-items:center; justify-content:center; margin-bottom:20px;">
          <PhTrash style="width:24px; height:24px; color:#EF4444;" />
        </div>
        <h3 style="font-size:20px; font-weight:900; color:#0D1B2A; margin-bottom:8px;">Supprimer la formation ?</h3>
        <p style="font-size:14px; color:rgba(13,27,42,0.55); line-height:1.6; margin-bottom:28px;">
          La formation <strong>{{ toDelete.title }}</strong> sera définitivement supprimée. Cette action est irréversible.
        </p>
        <div style="display:flex; gap:12px;">
          <button @click="toDelete = null" style="flex:1; padding:12px; border-radius:100px; border:2px solid rgba(13,27,42,0.15); background:transparent; font-size:14px; font-weight:700; color:#0D1B2A; cursor:pointer;">Annuler</button>
          <button @click="deleteFormation" style="flex:1; padding:12px; border-radius:100px; border:none; background:#EF4444; color:white; font-size:14px; font-weight:700; cursor:pointer;" class="delete-btn">Supprimer</button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import {
  PhPlus, PhMagnifyingGlass, PhEye, PhEyeSlash,
  PhPencil, PhTrash, PhArrowSquareOut, PhCalendarBlank
} from '@phosphor-icons/vue'

const props = defineProps({
  formations: Object,
  categories: Array,
})

const searchQuery  = ref(props.formations?.filters?.search ?? '')
const statusFilter = ref(props.formations?.filters?.status ?? '')
const toDelete     = ref(null)

const publishedStyle = 'background:#DCFCE7; color:#166534; font-size:12px; font-weight:700; padding:4px 10px; border-radius:6px;'
const draftStyle     = 'background:#FEF9C3; color:#854D0E; font-size:12px; font-weight:700; padding:4px 10px; border-radius:6px;'

function doSearch() {
  router.get(route('admin.formations.index'), {
    search: searchQuery.value || undefined,
    status: statusFilter.value || undefined,
  }, { preserveState: true, replace: true })
}

function goToPage(page) {
  router.get(route('admin.formations.index'), { page }, { preserveState: true })
}

function togglePublish(formation) {
  router.patch(route('admin.formations.publish', formation.id))
}

function confirmDelete(formation) {
  toDelete.value = formation
}

function deleteFormation() {
  router.delete(route('admin.formations.destroy', toDelete.value.id), {
    onFinish: () => { toDelete.value = null },
  })
}
</script>

<style scoped>
.table-row:hover { background:#FAF7F2; }
.admin-btn-primary { display:inline-flex; align-items:center; gap:8px; background:#0D1B2A; color:white; font-weight:700; font-size:14px; padding:10px 20px; border-radius:12px; text-decoration:none; transition:all 0.2s; border:none; cursor:pointer; }
.admin-btn-primary:hover { background:#1A2D42; transform:translateY(-1px); }
.admin-icon-btn { width:32px; height:32px; border-radius:8px; border:1.5px solid rgba(13,27,42,0.1); background:white; display:inline-flex; align-items:center; justify-content:center; color:rgba(13,27,42,0.5); cursor:pointer; transition:all 0.2s; text-decoration:none; }
.admin-icon-btn:hover { background:#FAF7F2; color:#0D1B2A; border-color:rgba(13,27,42,0.2); }
.admin-icon-btn-danger:hover { background:#FEE2E2 !important; color:#EF4444 !important; border-color:#FCA5A5 !important; }
.delete-btn:hover { background:#DC2626 !important; transform:translateY(-1px); }
</style>