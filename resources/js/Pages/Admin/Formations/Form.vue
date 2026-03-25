<template>
  <AdminLayout>
    <Head :title="isEdit ? 'Modifier la formation' : 'Nouvelle formation'" />

    <div style="max-width:900px;">

      <!-- Header -->
      <div style="display:flex; align-items:center; gap:16px; margin-bottom:32px;">
        <Link :href="route('admin.formations.index')" style="width:36px; height:36px; border-radius:10px; border:1.5px solid rgba(13,27,42,0.12); display:flex; align-items:center; justify-content:center; color:rgba(13,27,42,0.5); text-decoration:none;" class="back-btn">
          <PhArrowLeft style="width:16px; height:16px;" />
        </Link>
        <div>
          <h1 style="font-size:22px; font-weight:900; color:#0D1B2A; letter-spacing:-0.02em;">
            {{ isEdit ? 'Modifier la formation' : 'Nouvelle formation' }}
          </h1>
          <p style="font-size:13px; color:rgba(13,27,42,0.4); margin-top:2px;">
            {{ isEdit ? `Mise à jour de : ${formation?.title}` : 'Créer une nouvelle formation au catalogue' }}
          </p>
        </div>
      </div>

      <form @submit.prevent="submit" style="display:flex; flex-direction:column; gap:24px;">

        <!-- Section 1 : Informations principales -->
        <div style="background:white; border-radius:20px; padding:32px; box-shadow:0 1px 8px rgba(13,27,42,0.06);">
          <h2 style="font-size:16px; font-weight:800; color:#0D1B2A; margin-bottom:24px; padding-bottom:16px; border-bottom:1.5px solid rgba(13,27,42,0.06);">
            Informations principales
          </h2>
          <div style="display:flex; flex-direction:column; gap:20px;">

            <!-- Titre -->
            <div>
              <label class="form-label">Titre de la formation <span class="required">*</span></label>
              <input v-model="form.title" type="text" placeholder="Ex: Formation Excel avancé" required class="form-input" :class="{ error: form.errors.title }" />
              <p v-if="form.errors.title" class="form-error">{{ form.errors.title }}</p>
            </div>

            <!-- Description courte -->
            <div>
              <label class="form-label">Description courte</label>
              <textarea v-model="form.short_description" rows="3" placeholder="Une description concise de la formation..." class="form-input" style="resize:vertical;" />
            </div>

            <!-- Catégorie + Niveau -->
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
              <div>
                <label class="form-label">Catégorie</label>
                <select v-model="form.category_id" class="form-input">
                  <option value="">Sélectionner une catégorie</option>
                  <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                </select>
              </div>
              <div>
                <label class="form-label">Niveau</label>
                <select v-model="form.level" class="form-input">
                  <option value="tous">Tous niveaux</option>
                  <option value="debutant">Débutant</option>
                  <option value="intermediaire">Intermédiaire</option>
                  <option value="avance">Avancé</option>
                </select>
              </div>
            </div>

            <!-- Durée + Prix -->
            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
              <div>
                <label class="form-label">Durée</label>
                <input v-model="form.duration" type="text" placeholder="Ex: 3 mois, 40h..." class="form-input" />
              </div>
              <div>
                <label class="form-label">Prix (€)</label>
                <input v-model="form.price" type="number" step="0.01" min="0" placeholder="0.00" class="form-input" />
              </div>
              <div>
                <label class="form-label">Prix promo (€)</label>
                <input v-model="form.price_promo" type="number" step="0.01" min="0" placeholder="0.00" class="form-input" />
              </div>
            </div>
          </div>
        </div>

        <!-- Section 2 : Médias -->
        <div style="background:white; border-radius:20px; padding:32px; box-shadow:0 1px 8px rgba(13,27,42,0.06);">
          <h2 style="font-size:16px; font-weight:800; color:#0D1B2A; margin-bottom:24px; padding-bottom:16px; border-bottom:1.5px solid rgba(13,27,42,0.06);">
            Images
          </h2>
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div>
              <label class="form-label">Miniature (800×600)</label>
              <div
                class="upload-zone"
                @click="$refs.thumbnailInput.click()"
                @dragover.prevent
                @drop.prevent="e => handleFileDrop(e, 'thumbnail')"
              >
                <img v-if="thumbnailPreview || formation?.thumbnail_url" :src="thumbnailPreview ?? formation?.thumbnail_url" style="width:100%; height:140px; object-fit:cover; border-radius:10px; display:block;" />
                <div v-else style="padding:32px 20px; text-align:center; color:rgba(13,27,42,0.4);">
                  <PhImage style="width:28px; height:28px; margin:0 auto 8px; display:block;" />
                  <span style="font-size:13px;">Cliquer ou glisser une image</span>
                </div>
              </div>
              <input ref="thumbnailInput" type="file" accept="image/*" style="display:none;" @change="e => handleFileChange(e, 'thumbnail')" />
            </div>
            <div>
              <label class="form-label">Bannière (1920×600)</label>
              <div
                class="upload-zone"
                @click="$refs.bannerInput.click()"
                @dragover.prevent
                @drop.prevent="e => handleFileDrop(e, 'banner')"
              >
                <img v-if="bannerPreview || formation?.banner_url" :src="bannerPreview ?? formation?.banner_url" style="width:100%; height:140px; object-fit:cover; border-radius:10px; display:block;" />
                <div v-else style="padding:32px 20px; text-align:center; color:rgba(13,27,42,0.4);">
                  <PhImage style="width:28px; height:28px; margin:0 auto 8px; display:block;" />
                  <span style="font-size:13px;">Cliquer ou glisser une image</span>
                </div>
              </div>
              <input ref="bannerInput" type="file" accept="image/*" style="display:none;" @change="e => handleFileChange(e, 'banner')" />
            </div>
          </div>
        </div>

        <!-- Section 3 : Contenu pédagogique -->
        <div style="background:white; border-radius:20px; padding:32px; box-shadow:0 1px 8px rgba(13,27,42,0.06);">
          <h2 style="font-size:16px; font-weight:800; color:#0D1B2A; margin-bottom:24px; padding-bottom:16px; border-bottom:1.5px solid rgba(13,27,42,0.06);">
            Contenu pédagogique
          </h2>

          <!-- Objectifs -->
          <div style="margin-bottom:24px;">
            <label class="form-label">Objectifs d'apprentissage</label>
            <div style="display:flex; flex-direction:column; gap:8px; margin-bottom:10px;">
              <div v-for="(obj, i) in objectives" :key="i" style="display:flex; gap:8px;">
                <input v-model="objectives[i]" type="text" placeholder="Un objectif..." class="form-input" style="flex:1;" />
                <button type="button" @click="objectives.splice(i, 1)" class="admin-icon-btn admin-icon-btn-danger" style="flex-shrink:0;">
                  <PhMinus style="width:14px; height:14px;" />
                </button>
              </div>
            </div>
            <button type="button" @click="objectives.push('')" style="display:inline-flex; align-items:center; gap:6px; font-size:13px; font-weight:600; color:#C9A84C; background:rgba(201,168,76,0.08); border:1px solid rgba(201,168,76,0.2); padding:8px 16px; border-radius:10px; cursor:pointer; border-style:dashed;">
              <PhPlus style="width:14px; height:14px;" />
              Ajouter un objectif
            </button>
          </div>

          <!-- Prérequis -->
          <div style="margin-bottom:24px;">
            <label class="form-label">Prérequis</label>
            <div style="display:flex; flex-direction:column; gap:8px; margin-bottom:10px;">
              <div v-for="(pre, i) in prerequisites" :key="i" style="display:flex; gap:8px;">
                <input v-model="prerequisites[i]" type="text" placeholder="Un prérequis..." class="form-input" style="flex:1;" />
                <button type="button" @click="prerequisites.splice(i, 1)" class="admin-icon-btn admin-icon-btn-danger" style="flex-shrink:0;">
                  <PhMinus style="width:14px; height:14px;" />
                </button>
              </div>
            </div>
            <button type="button" @click="prerequisites.push('')" style="display:inline-flex; align-items:center; gap:6px; font-size:13px; font-weight:600; color:#C9A84C; background:rgba(201,168,76,0.08); border:1px solid rgba(201,168,76,0.2); padding:8px 16px; border-radius:10px; cursor:pointer; border-style:dashed;">
              <PhPlus style="width:14px; height:14px;" />
              Ajouter un prérequis
            </button>
          </div>

          <!-- Description longue -->
          <div>
            <label class="form-label">Description complète (HTML)</label>
            <textarea v-model="form.content" rows="10" placeholder="<p>Contenu de la formation...</p>" class="form-input" style="resize:vertical; font-family:monospace; font-size:13px;" />
          </div>
        </div>

        <!-- Section 4 : Options -->
        <div style="background:white; border-radius:20px; padding:32px; box-shadow:0 1px 8px rgba(13,27,42,0.06);">
          <h2 style="font-size:16px; font-weight:800; color:#0D1B2A; margin-bottom:24px; padding-bottom:16px; border-bottom:1.5px solid rgba(13,27,42,0.06);">
            Options de publication
          </h2>
          <div style="display:flex; flex-direction:column; gap:16px;">
            <label class="toggle-label">
              <span>
                <div style="font-size:14px; font-weight:700; color:#0D1B2A;">Publier la formation</div>
                <div style="font-size:12px; color:rgba(13,27,42,0.45);">La formation sera visible sur le site</div>
              </span>
              <div class="toggle" :class="{ active: form.is_published }" @click="form.is_published = !form.is_published">
                <div class="toggle-thumb" />
              </div>
            </label>
            <label class="toggle-label">
              <span>
                <div style="font-size:14px; font-weight:700; color:#0D1B2A;">Mettre en vedette</div>
                <div style="font-size:12px; color:rgba(13,27,42,0.45);">Affichée sur la page d'accueil</div>
              </span>
              <div class="toggle" :class="{ active: form.is_featured }" @click="form.is_featured = !form.is_featured">
                <div class="toggle-thumb" />
              </div>
            </label>
            <label class="toggle-label">
              <span>
                <div style="font-size:14px; font-weight:700; color:#0D1B2A;">Formation certifiante</div>
                <div style="font-size:12px; color:rgba(13,27,42,0.45);">Un badge certification sera affiché</div>
              </span>
              <div class="toggle" :class="{ active: form.has_certification }" @click="form.has_certification = !form.has_certification">
                <div class="toggle-thumb" />
              </div>
            </label>
          </div>
        </div>

        <!-- Boutons de soumission -->
        <div style="display:flex; gap:12px; justify-content:flex-end; padding-bottom:40px;">
          <Link :href="route('admin.formations.index')" style="display:inline-flex; align-items:center; gap:8px; padding:12px 24px; border-radius:12px; border:2px solid rgba(13,27,42,0.15); background:transparent; font-size:14px; font-weight:700; color:#0D1B2A; text-decoration:none; transition:all 0.2s;" class="cancel-btn">
            Annuler
          </Link>
          <button
            type="submit"
            :disabled="form.processing"
            style="display:inline-flex; align-items:center; gap:8px; padding:12px 28px; border-radius:12px; border:none; background:#0D1B2A; color:white; font-size:14px; font-weight:700; cursor:pointer; font-family:inherit; transition:all 0.2s;"
            class="submit-btn"
          >
            <PhCircleNotch v-if="form.processing" style="width:16px; height:16px;" class="spin" />
            <PhFloppyDisk v-else style="width:16px; height:16px;" />
            {{ form.processing ? 'Enregistrement...' : (isEdit ? 'Mettre à jour' : 'Créer la formation') }}
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import {
  PhArrowLeft, PhImage, PhPlus, PhMinus,
  PhCircleNotch, PhFloppyDisk,
} from '@phosphor-icons/vue'

const props = defineProps({
  formation:  Object,
  categories: Array,
})

const isEdit = computed(() => !!props.formation?.id)

const objectives   = ref(props.formation?.objectives  ?? [])
const prerequisites = ref(props.formation?.prerequisites ?? [])
const thumbnailPreview = ref(null)
const bannerPreview    = ref(null)

const form = useForm({
  title:            props.formation?.title            ?? '',
  short_description:props.formation?.short_description ?? '',
  category_id:      props.formation?.category_id      ?? '',
  level:            props.formation?.level            ?? 'tous',
  duration:         props.formation?.duration         ?? '',
  price:            props.formation?.price            ?? '',
  price_promo:      props.formation?.price_promo      ?? '',
  content:          props.formation?.content          ?? '',
  is_published:     props.formation?.is_published     ?? false,
  is_featured:      props.formation?.is_featured      ?? false,
  has_certification:props.formation?.has_certification ?? false,
  thumbnail:        null,
  banner:           null,
})

function handleFileChange(event, field) {
  const file = event.target.files[0]
  if (!file) return
  form[field] = file
  const url = URL.createObjectURL(file)
  if (field === 'thumbnail') thumbnailPreview.value = url
  else bannerPreview.value = url
}

function handleFileDrop(event, field) {
  const file = event.dataTransfer.files[0]
  if (!file || !file.type.startsWith('image/')) return
  form[field] = file
  const url = URL.createObjectURL(file)
  if (field === 'thumbnail') thumbnailPreview.value = url
  else bannerPreview.value = url
}

function submit() {
  // Synchroniser les tableaux dynamiques dans le form
  form.objectives    = objectives.value.filter(o => o.trim() !== '')
  form.prerequisites = prerequisites.value.filter(p => p.trim() !== '')

  if (isEdit.value) {
    form
      .transform((data) => {
        // Inertia détecte automatiquement les File — pas besoin de forceFormData
        const fd = new FormData()

        Object.entries(data).forEach(([key, value]) => {
          if (value === null || value === undefined) return

          if (value instanceof File) {
            fd.append(key, value)
          } else if (Array.isArray(value)) {
            value.forEach((item, i) => {
              if (typeof item === 'object' && item !== null) {
                Object.entries(item).forEach(([k, v]) => {
                  fd.append(`${key}[${i}][${k}]`, v ?? '')
                })
              } else {
                fd.append(`${key}[${i}]`, item ?? '')
              }
            })
          } else if (typeof value === 'boolean') {
            fd.append(key, value ? '1' : '0')
          } else {
            fd.append(key, value)
          }
        })

        // Laravel nécessite _method pour le PUT via FormData
        fd.append('_method', 'PUT')
        return fd
      })
      .post(route('admin.formations.update', props.formation.id))
  } else {
    form
      .transform((data) => {
        const fd = new FormData()

        Object.entries(data).forEach(([key, value]) => {
          if (value === null || value === undefined) return

          if (value instanceof File) {
            fd.append(key, value)
          } else if (Array.isArray(value)) {
            value.forEach((item, i) => {
              if (typeof item === 'object' && item !== null) {
                Object.entries(item).forEach(([k, v]) => {
                  fd.append(`${key}[${i}][${k}]`, v ?? '')
                })
              } else {
                fd.append(`${key}[${i}]`, item ?? '')
              }
            })
          } else if (typeof value === 'boolean') {
            fd.append(key, value ? '1' : '0')
          } else {
            fd.append(key, value)
          }
        })

        return fd
      })
      .post(route('admin.formations.store'))
  }
}
</script>

<style scoped>
.form-label { display:block; font-size:13px; font-weight:700; color:#0D1B2A; margin-bottom:8px; }
.required { color:#C9A84C; }
.form-input { width:100%; padding:12px 14px; border:1.5px solid rgba(13,27,42,0.12); border-radius:12px; font-size:14px; color:#0D1B2A; outline:none; font-family:inherit; background:#FAF7F2; transition:border-color 0.2s; box-sizing:border-box; }
.form-input:focus { border-color:rgba(201,168,76,0.6); background:white; }
.form-input.error { border-color:#EF4444; }
.form-error { font-size:12px; color:#EF4444; margin-top:5px; }
.upload-zone { border:2px dashed rgba(13,27,42,0.15); border-radius:14px; overflow:hidden; cursor:pointer; transition:border-color 0.2s; min-height:80px; }
.upload-zone:hover { border-color:rgba(201,168,76,0.4); background:rgba(201,168,76,0.03); }
.toggle-label { display:flex; align-items:center; justify-content:space-between; padding:16px; background:#FAF7F2; border-radius:14px; cursor:pointer; }
.toggle { width:44px; height:24px; border-radius:100px; background:rgba(13,27,42,0.15); position:relative; transition:background 0.2s; flex-shrink:0; }
.toggle.active { background:#0D1B2A; }
.toggle-thumb { width:18px; height:18px; border-radius:50%; background:white; position:absolute; top:3px; left:3px; transition:transform 0.2s; box-shadow:0 1px 4px rgba(0,0,0,0.2); }
.toggle.active .toggle-thumb { transform:translateX(20px); }
.admin-icon-btn { width:32px; height:32px; border-radius:8px; border:1.5px solid rgba(13,27,42,0.1); background:white; display:inline-flex; align-items:center; justify-content:center; color:rgba(13,27,42,0.5); cursor:pointer; transition:all 0.2s; }
.admin-icon-btn-danger:hover { background:#FEE2E2 !important; color:#EF4444 !important; border-color:#FCA5A5 !important; }
.back-btn:hover { background:#FAF7F2; color:#0D1B2A !important; }
.submit-btn:hover:not(:disabled) { background:#1A2D42 !important; transform:translateY(-1px); }
.cancel-btn:hover { background:#FAF7F2; }
.spin { animation:spin 1s linear infinite; }
@keyframes spin { to { transform:rotate(360deg); } }
</style>