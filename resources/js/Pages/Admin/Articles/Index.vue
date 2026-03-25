<template>
  <AdminLayout>
    <Head title="Articles" />

    <div style="display:flex; flex-direction:column; gap:24px;">
      <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px;">
        <div>
          <h1 style="font-size:24px; font-weight:900; color:#0D1B2A; letter-spacing:-0.02em;">Articles</h1>
          <p style="font-size:14px; color:rgba(13,27,42,0.45); margin-top:4px;">{{ articles.total }} article{{ articles.total > 1 ? 's' : '' }} au total</p>
        </div>
        <Link :href="route('admin.articles.create')" class="admin-btn-primary">
          <PhPlus style="width:16px; height:16px;" />
          Nouvel article
        </Link>
      </div>

      <!-- Filtres -->
      <div style="background:white; border-radius:16px; padding:16px 20px; display:flex; align-items:center; gap:12px; box-shadow:0 1px 8px rgba(13,27,42,0.06); flex-wrap:wrap;">
        <div style="position:relative; flex:1; min-width:180px;">
          <PhMagnifyingGlass style="width:16px; height:16px; color:rgba(13,27,42,0.35); position:absolute; left:12px; top:50%; transform:translateY(-50%);" />
          <input v-model="searchQuery" type="text" placeholder="Rechercher..." style="width:100%; padding:9px 12px 9px 36px; border:1.5px solid rgba(13,27,42,0.1); border-radius:10px; font-size:14px; color:#0D1B2A; outline:none; font-family:inherit; background:#FAF7F2; box-sizing:border-box;" @input="doSearch" />
        </div>
        <select v-model="statusFilter" @change="doSearch" style="padding:9px 14px; border:1.5px solid rgba(13,27,42,0.1); border-radius:10px; font-size:14px; color:#0D1B2A; outline:none; font-family:inherit; background:white; cursor:pointer;">
          <option value="">Tous les statuts</option>
          <option value="published">Publiés</option>
          <option value="draft">Brouillons</option>
        </select>
      </div>

      <!-- Tableau -->
      <div style="background:white; border-radius:20px; overflow:hidden; box-shadow:0 1px 8px rgba(13,27,42,0.06);">
        <table style="width:100%; border-collapse:collapse;">
          <thead>
            <tr style="border-bottom:1.5px solid rgba(13,27,42,0.07);">
              <th style="padding:14px 20px; text-align:left; font-size:12px; font-weight:700; color:rgba(13,27,42,0.4); letter-spacing:0.06em; text-transform:uppercase;">Article</th>
              <th style="padding:14px 20px; text-align:left; font-size:12px; font-weight:700; color:rgba(13,27,42,0.4); letter-spacing:0.06em; text-transform:uppercase;">Auteur</th>
              <th style="padding:14px 20px; text-align:left; font-size:12px; font-weight:700; color:rgba(13,27,42,0.4); letter-spacing:0.06em; text-transform:uppercase;">Lecture</th>
              <th style="padding:14px 20px; text-align:left; font-size:12px; font-weight:700; color:rgba(13,27,42,0.4); letter-spacing:0.06em; text-transform:uppercase;">Statut</th>
              <th style="padding:14px 20px; text-align:right; font-size:12px; font-weight:700; color:rgba(13,27,42,0.4); letter-spacing:0.06em; text-transform:uppercase;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="!articles.data?.length">
              <td colspan="5" style="padding:60px; text-align:center; color:rgba(13,27,42,0.35); font-size:14px;">Aucun article trouvé</td>
            </tr>
            <tr v-for="a in articles.data" :key="a.id" style="border-bottom:1px solid rgba(13,27,42,0.05);" class="table-row">
              <td style="padding:16px 20px;">
                <div style="display:flex; align-items:center; gap:14px;">
                  <img :src="a.thumbnail_url" :alt="a.title" style="width:52px; height:40px; object-fit:cover; border-radius:10px; flex-shrink:0;" />
                  <div>
                    <div style="font-size:14px; font-weight:700; color:#0D1B2A; margin-bottom:2px;">{{ a.title }}</div>
                    <div style="font-size:12px; color:rgba(13,27,42,0.4);">{{ a.created_at }}</div>
                  </div>
                </div>
              </td>
              <td style="padding:16px 20px; font-size:13px; color:rgba(13,27,42,0.6);">{{ a.author?.full_name }}</td>
              <td style="padding:16px 20px; font-size:13px; color:rgba(13,27,42,0.5);">{{ a.read_time }} min</td>
              <td style="padding:16px 20px;">
                <span :style="a.is_published ? publishedStyle : draftStyle">{{ a.is_published ? 'Publié' : 'Brouillon' }}</span>
              </td>
              <td style="padding:16px 20px;">
                <div style="display:flex; align-items:center; justify-content:flex-end; gap:8px;">
                  <a :href="route('articles.show', a.slug)" target="_blank" class="admin-icon-btn">
                    <PhArrowSquareOut style="width:15px; height:15px;" />
                  </a>
                  <Link :href="route('admin.articles.edit', a.id)" class="admin-icon-btn">
                    <PhPencil style="width:15px; height:15px;" />
                  </Link>
                  <button @click="confirmDelete(a)" class="admin-icon-btn admin-icon-btn-danger">
                    <PhTrash style="width:15px; height:15px;" />
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal suppression -->
    <div v-if="toDelete" style="position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:1000; display:flex; align-items:center; justify-content:center; padding:20px;" @click.self="toDelete = null">
      <div style="background:white; border-radius:24px; padding:36px; max-width:420px; width:100%;">
        <div style="width:52px; height:52px; border-radius:14px; background:#FEE2E2; display:flex; align-items:center; justify-content:center; margin-bottom:20px;">
          <PhTrash style="width:24px; height:24px; color:#EF4444;" />
        </div>
        <h3 style="font-size:20px; font-weight:900; color:#0D1B2A; margin-bottom:8px;">Supprimer l'article ?</h3>
        <p style="font-size:14px; color:rgba(13,27,42,0.55); margin-bottom:28px; line-height:1.6;">
          <strong>{{ toDelete.title }}</strong> sera supprimé définitivement.
        </p>
        <div style="display:flex; gap:12px;">
          <button @click="toDelete = null" style="flex:1; padding:12px; border-radius:100px; border:2px solid rgba(13,27,42,0.15); background:transparent; font-size:14px; font-weight:700; color:#0D1B2A; cursor:pointer;">Annuler</button>
          <button @click="deleteArticle" style="flex:1; padding:12px; border-radius:100px; border:none; background:#EF4444; color:white; font-size:14px; font-weight:700; cursor:pointer;">Supprimer</button>
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
import { PhPlus, PhMagnifyingGlass, PhArrowSquareOut, PhPencil, PhTrash } from '@phosphor-icons/vue'

const props = defineProps({ articles: Object })

const searchQuery  = ref('')
const statusFilter = ref('')
const toDelete     = ref(null)

const publishedStyle = 'background:#DCFCE7; color:#166534; font-size:12px; font-weight:700; padding:4px 10px; border-radius:6px;'
const draftStyle     = 'background:#FEF9C3; color:#854D0E; font-size:12px; font-weight:700; padding:4px 10px; border-radius:6px;'

function doSearch() {
  router.get(route('admin.articles.index'), { search: searchQuery.value || undefined, status: statusFilter.value || undefined }, { preserveState:true, replace:true })
}

function confirmDelete(a) { toDelete.value = a }

function deleteArticle() {
  router.delete(route('admin.articles.destroy', toDelete.value.id), { onFinish: () => { toDelete.value = null } })
}
</script>

<style scoped>
.table-row:hover { background:#FAF7F2; }
.admin-btn-primary { display:inline-flex; align-items:center; gap:8px; background:#0D1B2A; color:white; font-weight:700; font-size:14px; padding:10px 20px; border-radius:12px; text-decoration:none; transition:all 0.2s; }
.admin-btn-primary:hover { background:#1A2D42; }
.admin-icon-btn { width:32px; height:32px; border-radius:8px; border:1.5px solid rgba(13,27,42,0.1); background:white; display:inline-flex; align-items:center; justify-content:center; color:rgba(13,27,42,0.5); cursor:pointer; transition:all 0.2s; text-decoration:none; }
.admin-icon-btn:hover { background:#FAF7F2; color:#0D1B2A; }
.admin-icon-btn-danger:hover { background:#FEE2E2 !important; color:#EF4444 !important; border-color:#FCA5A5 !important; }
</style>