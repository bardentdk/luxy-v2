<template>
  <AdminLayout>
    <Head title="Avis clients" />

    <div style="display:flex; flex-direction:column; gap:24px;">
      <div>
        <h1 style="font-size:24px; font-weight:900; color:#0D1B2A; letter-spacing:-0.02em;">Avis clients</h1>
        <p style="font-size:14px; color:rgba(13,27,42,0.45); margin-top:4px;">{{ reviews.total }} avis au total</p>
      </div>

      <!-- Filtres statut -->
      <div style="display:flex; gap:8px; flex-wrap:wrap;">
        <button v-for="s in statuses" :key="s.value" @click="setStatus(s.value)" :style="currentStatus === s.value ? activePillStyle : pillStyle">
          {{ s.label }}
        </button>
      </div>

      <!-- Grille avis -->
      <div v-if="reviews.data?.length" style="display:grid; grid-template-columns:repeat(2,1fr); gap:20px;">
        <div
          v-for="review in reviews.data"
          :key="review.id"
          style="background:white; border-radius:20px; padding:24px; box-shadow:0 1px 8px rgba(13,27,42,0.06); display:flex; flex-direction:column; gap:16px;"
          :style="!review.is_approved ? 'border-left:3px solid #F59E0B;' : ''"
        >
          <!-- Header avis -->
          <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:12px;">
            <div>
              <div style="display:flex; gap:2px; margin-bottom:6px;">
                <PhStar v-for="i in 5" :key="i" style="width:14px; height:14px;" :style="i <= review.rating ? 'color:#C9A84C;' : 'color:rgba(13,27,42,0.1);'" weight="fill" />
              </div>
              <div style="font-size:14px; font-weight:700; color:#0D1B2A;">{{ review.reviewer_name }}</div>
              <div v-if="review.reviewer_job" style="font-size:12px; color:rgba(13,27,42,0.45);">{{ review.reviewer_job }}</div>
              <div v-if="review.formation" style="font-size:12px; color:#C9A84C; margin-top:2px;">{{ review.formation.title }}</div>
            </div>
            <div style="display:flex; flex-direction:column; align-items:flex-end; gap:8px;">
              <span :style="review.is_approved ? 'background:#DCFCE7; color:#166534; font-size:11px; font-weight:700; padding:3px 8px; border-radius:6px;' : 'background:#FEF9C3; color:#854D0E; font-size:11px; font-weight:700; padding:3px 8px; border-radius:6px;'">
                {{ review.is_approved ? 'Approuvé' : 'En attente' }}
              </span>
              <span v-if="review.is_featured" style="background:rgba(201,168,76,0.15); color:#92400E; font-size:11px; font-weight:700; padding:3px 8px; border-radius:6px;">Vedette</span>
            </div>
          </div>

          <!-- Commentaire -->
          <p style="font-size:14px; color:rgba(13,27,42,0.65); line-height:1.65; font-style:italic; border-left:3px solid rgba(201,168,76,0.3); padding-left:14px;">
            "{{ review.comment }}"
          </p>

          <!-- Meta -->
          <div style="font-size:12px; color:rgba(13,27,42,0.35);">{{ review.created_at }}</div>

          <!-- Actions -->
          <div style="display:flex; gap:8px; padding-top:12px; border-top:1px solid rgba(13,27,42,0.06); flex-wrap:wrap;">
            <button
              v-if="!review.is_approved"
              @click="approve(review)"
              style="display:inline-flex; align-items:center; gap:6px; padding:8px 14px; border-radius:8px; border:none; background:#DCFCE7; color:#166534; font-size:13px; font-weight:700; cursor:pointer; transition:all 0.2s;"
              class="approve-btn"
            >
              <PhCheckCircle style="width:14px; height:14px;" />
              Approuver
            </button>
            <button
              v-if="review.is_approved"
              @click="reject(review)"
              style="display:inline-flex; align-items:center; gap:6px; padding:8px 14px; border-radius:8px; border:none; background:#FEF9C3; color:#854D0E; font-size:13px; font-weight:700; cursor:pointer; transition:all 0.2s;"
            >
              <PhX style="width:14px; height:14px;" />
              Retirer
            </button>
            <button
              @click="toggleFeatured(review)"
              style="display:inline-flex; align-items:center; gap:6px; padding:8px 14px; border-radius:8px; border:1.5px solid rgba(201,168,76,0.3); background:transparent; color:rgba(13,27,42,0.6); font-size:13px; font-weight:700; cursor:pointer; transition:all 0.2s;"
              :style="review.is_featured ? 'background:rgba(201,168,76,0.1); border-color:#C9A84C; color:#92400E;' : ''"
            >
              <PhStar style="width:14px; height:14px;" :weight="review.is_featured ? 'fill' : 'regular'" />
              {{ review.is_featured ? 'Retirer vedette' : 'Mettre en vedette' }}
            </button>
            <button
              @click="deleteReview(review)"
              style="display:inline-flex; align-items:center; gap:6px; padding:8px 14px; border-radius:8px; border:none; background:#FEE2E2; color:#EF4444; font-size:13px; font-weight:700; cursor:pointer; margin-left:auto; transition:all 0.2s;"
            >
              <PhTrash style="width:14px; height:14px;" />
              Supprimer
            </button>
          </div>
        </div>
      </div>

      <div v-else style="text-align:center; padding:80px; background:white; border-radius:20px; color:rgba(13,27,42,0.35); font-size:14px;">
        Aucun avis pour ce filtre
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { PhStar, PhCheckCircle, PhX, PhTrash } from '@phosphor-icons/vue'

const props = defineProps({ reviews: Object })

const statuses = [
  { label: 'Tous', value: '' },
  { label: 'En attente', value: 'pending' },
  { label: 'Approuvés', value: 'approved' },
]

const currentStatus = ref('')
const pillStyle       = 'padding:8px 16px; border-radius:100px; font-size:13px; font-weight:600; border:1.5px solid rgba(13,27,42,0.12); background:white; color:rgba(13,27,42,0.6); cursor:pointer; transition:all 0.2s;'
const activePillStyle = 'padding:8px 16px; border-radius:100px; font-size:13px; font-weight:700; border:1.5px solid #0D1B2A; background:#0D1B2A; color:white; cursor:pointer; transition:all 0.2s;'

function setStatus(s) {
  currentStatus.value = s
  router.get(route('admin.reviews.index'), { status: s || undefined }, { preserveState: true, replace: true })
}

function approve(r)        { router.patch(route('admin.reviews.approve', r.id)) }
function reject(r)         { router.patch(route('admin.reviews.reject', r.id)) }
function toggleFeatured(r) { router.patch(route('admin.reviews.featured', r.id)) }
function deleteReview(r)   { if (confirm('Supprimer cet avis ?')) router.delete(route('admin.reviews.destroy', r.id)) }
</script>

<style scoped>
.approve-btn:hover { background:#BBF7D0 !important; }
</style>