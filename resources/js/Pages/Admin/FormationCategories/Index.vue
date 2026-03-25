<template>
  <AdminLayout>
    <Head title="Catégories de formation" />

    <div style="max-width:1000px; display:flex; flex-direction:column; gap:24px;">

      <!-- Header -->
      <div style="display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px;">
        <div>
          <h1 style="font-size:24px; font-weight:900; color:#0D1B2A; letter-spacing:-0.02em; margin:0 0 4px;">
            Catégories de formation
          </h1>
          <p style="font-size:14px; color:rgba(13,27,42,0.45); margin:0;">
            {{ categories.length }} catégorie{{ categories.length > 1 ? 's' : '' }} — elles apparaissent sur le Bento Grid public
          </p>
        </div>
        <button
          @click="openCreate"
          style="display:inline-flex; align-items:center; gap:8px; background:#0D1B2A; color:white; font-weight:700; font-size:13px; padding:10px 18px; border-radius:12px; border:none; cursor:pointer; font-family:inherit; transition:all 0.2s; flex-shrink:0;"
          class="add-btn"
        >
          <PhPlus style="width:15px; height:15px;" />
          Nouvelle catégorie
        </button>
      </div>

      <!-- Explication icônes -->
      <div style="background:rgba(201,168,76,0.08); border:1px solid rgba(201,168,76,0.2); border-radius:14px; padding:16px 20px; display:flex; align-items:flex-start; gap:12px;">
        <PhInfo style="width:18px; height:18px; color:#C9A84C; flex-shrink:0; margin-top:1px;" weight="fill" />
        <p style="font-size:13px; color:rgba(13,27,42,0.65); line-height:1.6; margin:0;">
          Les icônes utilisent les noms <strong>Phosphor Icons</strong> (ex: <code style="background:rgba(13,27,42,0.07); padding:1px 6px; border-radius:5px; font-size:12px;">PhBriefcase</code>, <code style="background:rgba(13,27,42,0.07); padding:1px 6px; border-radius:5px; font-size:12px;">PhBooks</code>, <code style="background:rgba(13,27,42,0.07); padding:1px 6px; border-radius:5px; font-size:12px;">PhMonitor</code>, <code style="background:rgba(13,27,42,0.07); padding:1px 6px; border-radius:5px; font-size:12px;">PhGlobe</code>, <code style="background:rgba(13,27,42,0.07); padding:1px 6px; border-radius:5px; font-size:12px;">PhChalkboardTeacher</code>, <code style="background:rgba(13,27,42,0.07); padding:1px 6px; border-radius:5px; font-size:12px;">PhCode</code>...).
          Consultez <a href="https://phosphoricons.com" target="_blank" style="color:#C9A84C; font-weight:600;">phosphoricons.com</a> pour trouver le nom exact.
        </p>
      </div>

      <!-- Liste vide -->
      <div v-if="!categories.length" style="background:white; border-radius:20px; padding:72px 40px; text-align:center; border:2px dashed rgba(13,27,42,0.1);">
        <div style="width:72px; height:72px; border-radius:20px; background:rgba(201,168,76,0.08); display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
          <PhTag style="width:32px; height:32px; color:rgba(201,168,76,0.5);" weight="fill" />
        </div>
        <h3 style="font-size:20px; font-weight:800; color:#0D1B2A; margin:0 0 8px;">Aucune catégorie</h3>
        <p style="font-size:14px; color:rgba(13,27,42,0.45); margin:0 0 28px; line-height:1.6;">
          Créez des catégories pour organiser vos formations par domaine.<br>
          Elles s'affichent en Bento Grid sur la page publique.
        </p>
        <button
          @click="openCreate"
          style="display:inline-flex; align-items:center; gap:8px; background:#C9A84C; color:#0D1B2A; font-weight:800; font-size:14px; padding:12px 28px; border-radius:100px; border:none; cursor:pointer; font-family:inherit;"
        >
          <PhPlus style="width:15px; height:15px;" />
          Créer une catégorie
        </button>
      </div>

      <!-- Grille des catégories -->
      <div v-else style="display:grid; grid-template-columns:repeat(2,1fr); gap:16px;">
        <div
          v-for="cat in categories"
          :key="cat.id"
          style="background:white; border-radius:20px; border:1.5px solid rgba(13,27,42,0.07); overflow:hidden; transition:all 0.25s;"
          class="category-card"
        >
          <!-- Bande colorée top -->
          <div
            style="height:6px;"
            :style="{ background: getCategoryGradient(cat) }"
          />

          <div style="padding:20px 24px;">
            <div style="display:flex; align-items:flex-start; gap:16px;">

              <!-- Icône preview -->
              <div
                style="width:52px; height:52px; border-radius:14px; display:flex; align-items:center; justify-content:center; flex-shrink:0;"
                :style="{ background: getCategoryBg(cat) }"
              >
                <component
                  :is="getPhosphorIcon(cat.icon)"
                  style="width:26px; height:26px;"
                  :style="{ color: getCategoryColor(cat) }"
                  weight="fill"
                />
              </div>

              <!-- Infos -->
              <div style="flex:1; min-width:0;">
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:4px; flex-wrap:wrap;">
                  <h3 style="font-size:16px; font-weight:800; color:#0D1B2A; margin:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                    {{ cat.name }}
                  </h3>
                  <span style="background:#F1F3F7; color:rgba(13,27,42,0.5); font-size:12px; font-weight:700; padding:3px 10px; border-radius:6px; flex-shrink:0;">
                    {{ cat.formations_count }} formation{{ cat.formations_count > 1 ? 's' : '' }}
                  </span>
                </div>

                <p v-if="cat.description" style="font-size:13px; color:rgba(13,27,42,0.5); margin:0 0 10px; line-height:1.5; overflow:hidden; text-overflow:ellipsis; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;">
                  {{ cat.description }}
                </p>
                <p v-else style="font-size:13px; color:rgba(13,27,42,0.3); margin:0 0 10px; font-style:italic;">
                  Aucune description
                </p>

                <!-- Tags techniques -->
                <div style="display:flex; gap:8px; flex-wrap:wrap;">
                  <span v-if="cat.icon" style="display:inline-flex; align-items:center; gap:5px; background:#F8F9FB; border:1px solid rgba(13,27,42,0.08); color:rgba(13,27,42,0.5); font-size:11px; font-weight:600; padding:3px 8px; border-radius:6px;">
                    <PhPuzzlePiece style="width:11px; height:11px;" />
                    {{ cat.icon }}
                  </span>
                  <span style="display:inline-flex; align-items:center; gap:5px; background:#F8F9FB; border:1px solid rgba(13,27,42,0.08); color:rgba(13,27,42,0.5); font-size:11px; font-weight:600; padding:3px 8px; border-radius:6px;">
                    <PhArrowsDownUp style="width:11px; height:11px;" />
                    Ordre : {{ cat.sort_order }}
                  </span>
                </div>
              </div>
            </div>

            <!-- Actions -->
            <div style="display:flex; align-items:center; justify-content:flex-end; gap:8px; margin-top:16px; padding-top:16px; border-top:1px solid rgba(13,27,42,0.05);">
              <a
                :href="route('formations.index') + '?categorie=' + cat.slug"
                target="_blank"
                style="display:inline-flex; align-items:center; gap:6px; padding:7px 12px; border-radius:8px; border:1.5px solid rgba(13,27,42,0.1); background:transparent; font-size:12px; font-weight:700; color:rgba(13,27,42,0.5); text-decoration:none; transition:all 0.2s;"
                class="icon-btn"
              >
                <PhArrowSquareOut style="width:13px; height:13px;" />
                Voir
              </a>
              <button
                @click="openEdit(cat)"
                style="display:inline-flex; align-items:center; gap:6px; padding:7px 12px; border-radius:8px; border:1.5px solid rgba(13,27,42,0.1); background:transparent; font-size:12px; font-weight:700; color:rgba(13,27,42,0.5); cursor:pointer; font-family:inherit; transition:all 0.2s;"
                class="icon-btn"
              >
                <PhPencil style="width:13px; height:13px;" />
                Modifier
              </button>
              <button
                @click="confirmDelete(cat)"
                style="display:inline-flex; align-items:center; gap:6px; padding:7px 12px; border-radius:8px; border:1.5px solid rgba(13,27,42,0.1); background:transparent; font-size:12px; font-weight:700; color:rgba(13,27,42,0.5); cursor:pointer; font-family:inherit; transition:all 0.2s;"
                class="icon-btn-danger"
                :disabled="cat.formations_count > 0"
                :title="cat.formations_count > 0 ? 'Impossible : contient des formations' : 'Supprimer'"
              >
                <PhTrash style="width:13px; height:13px;" />
                Supprimer
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ══ Modal création / édition ══════════════════════════ -->
    <div
      v-if="showForm"
      style="position:fixed; inset:0; background:rgba(10,22,40,0.6); z-index:1000; display:flex; align-items:center; justify-content:center; padding:20px; backdrop-filter:blur(4px);"
      @click.self="showForm = false"
    >
      <div style="background:white; border-radius:24px; padding:36px; width:100%; max-width:540px; box-shadow:0 32px 80px rgba(0,0,0,0.3); max-height:90vh; overflow-y:auto;">

        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px;">
          <h2 style="font-size:20px; font-weight:900; color:#0D1B2A; margin:0; letter-spacing:-0.02em;">
            {{ editing ? 'Modifier la catégorie' : 'Nouvelle catégorie' }}
          </h2>
          <button
            @click="showForm = false"
            style="width:32px; height:32px; border-radius:8px; border:1.5px solid rgba(13,27,42,0.1); background:transparent; cursor:pointer; display:flex; align-items:center; justify-content:center; color:rgba(13,27,42,0.4);"
            class="icon-btn"
          >
            <PhX style="width:16px; height:16px;" />
          </button>
        </div>

        <!-- Preview en temps réel -->
        <div
          style="border-radius:16px; padding:20px; margin-bottom:24px; display:flex; align-items:center; gap:16px; transition:all 0.3s;"
          :style="{ background: getPreviewGradient() }"
        >
          <div
            style="width:52px; height:52px; border-radius:14px; background:rgba(255,255,255,0.2); display:flex; align-items:center; justify-content:center; flex-shrink:0; border:1px solid rgba(255,255,255,0.3);"
          >
            <component
              :is="getPhosphorIcon(form.icon)"
              style="width:26px; height:26px; color:white;"
              weight="fill"
            />
          </div>
          <div>
            <div style="font-size:16px; font-weight:800; color:white; margin-bottom:3px;">
              {{ form.name || 'Nom de la catégorie' }}
            </div>
            <div style="font-size:13px; color:rgba(255,255,255,0.6);">
              {{ form.description || 'Description de la catégorie...' }}
            </div>
          </div>
        </div>

        <form @submit.prevent="submitForm" style="display:flex; flex-direction:column; gap:18px;">

          <!-- Nom -->
          <div>
            <label class="f-label">Nom <span style="color:#C9A84C;">*</span></label>
            <input
              v-model="form.name"
              type="text"
              placeholder="Ex: Formation professionnelle"
              required
              class="f-input"
              :class="{ 'f-input-error': errors.name }"
            />
            <p v-if="errors.name" class="f-error">{{ errors.name }}</p>
          </div>

          <!-- Description -->
          <div>
            <label class="f-label">Description</label>
            <textarea
              v-model="form.description"
              rows="2"
              placeholder="Une courte description affichée sur le Bento Grid..."
              class="f-input"
              style="resize:vertical;"
            />
          </div>

          <!-- Icône -->
          <div>
            <label class="f-label">Icône Phosphor</label>
            <input
              v-model="form.icon"
              type="text"
              placeholder="Ex: PhBriefcase, PhBooks, PhMonitor..."
              class="f-input"
            />
            <!-- Suggestions rapides -->
            <div style="display:flex; gap:8px; flex-wrap:wrap; margin-top:10px;">
              <button
                v-for="suggestion in iconSuggestions"
                :key="suggestion.name"
                type="button"
                @click="form.icon = suggestion.name"
                style="display:inline-flex; align-items:center; gap:6px; padding:6px 10px; border-radius:8px; font-size:11px; font-weight:700; cursor:pointer; transition:all 0.2s; border:1.5px solid;"
                :style="form.icon === suggestion.name
                  ? 'background:#0D1B2A; color:white; border-color:#0D1B2A;'
                  : 'background:#F8F9FB; color:rgba(13,27,42,0.6); border-color:rgba(13,27,42,0.1);'"
              >
                <component :is="suggestion.icon" style="width:13px; height:13px;" />
                {{ suggestion.label }}
              </button>
            </div>
          </div>

          <!-- Couleur -->
          <div>
            <label class="f-label">Thème couleur</label>
            <div style="display:grid; grid-template-columns:repeat(5,1fr); gap:8px;">
              <button
                v-for="theme in colorThemes"
                :key="theme.value"
                type="button"
                @click="form.color = theme.value"
                style="height:44px; border-radius:10px; cursor:pointer; transition:all 0.2s; border:3px solid transparent; position:relative; overflow:hidden;"
                :style="{
                  background: theme.gradient,
                  borderColor: form.color === theme.value ? 'white' : 'transparent',
                  boxShadow: form.color === theme.value ? `0 0 0 2px ${theme.accent}, 0 4px 12px rgba(0,0,0,0.15)` : '0 2px 8px rgba(0,0,0,0.1)',
                }"
                :title="theme.label"
              >
                <PhCheckCircle
                  v-if="form.color === theme.value"
                  style="width:18px; height:18px; color:white; position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);"
                  weight="fill"
                />
              </button>
            </div>
          </div>

          <!-- Ordre -->
          <div>
            <label class="f-label">Ordre d'affichage</label>
            <input
              v-model.number="form.sort_order"
              type="number"
              min="0"
              placeholder="0"
              class="f-input"
              style="max-width:120px;"
            />
            <p style="font-size:11px; color:rgba(13,27,42,0.4); margin-top:5px;">Plus petit = affiché en premier</p>
          </div>

          <!-- Boutons -->
          <div style="display:flex; gap:12px; padding-top:8px;">
            <button
              type="button"
              @click="showForm = false"
              style="flex:1; padding:12px; border-radius:100px; border:2px solid rgba(13,27,42,0.15); background:transparent; font-size:14px; font-weight:700; color:#0D1B2A; cursor:pointer; font-family:inherit; transition:all 0.2s;"
              class="cancel-btn"
            >
              Annuler
            </button>
            <button
              type="submit"
              :disabled="submitting"
              style="flex:2; padding:12px; border-radius:100px; border:none; background:#0D1B2A; color:white; font-size:14px; font-weight:700; cursor:pointer; font-family:inherit; transition:all 0.2s; display:flex; align-items:center; justify-content:center; gap:8px;"
              class="submit-btn"
            >
              <PhCircleNotch v-if="submitting" style="width:16px; height:16px;" class="spin" />
              <PhFloppyDisk v-else style="width:16px; height:16px;" />
              {{ submitting ? 'Enregistrement...' : (editing ? 'Mettre à jour' : 'Créer la catégorie') }}
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- ══ Modal suppression ══════════════════════════════════ -->
    <div
      v-if="toDelete"
      style="position:fixed; inset:0; background:rgba(10,22,40,0.6); z-index:1000; display:flex; align-items:center; justify-content:center; padding:20px; backdrop-filter:blur(4px);"
      @click.self="toDelete = null"
    >
      <div style="background:white; border-radius:24px; padding:36px; max-width:420px; width:100%; box-shadow:0 32px 80px rgba(0,0,0,0.25);">
        <div style="width:52px; height:52px; border-radius:14px; background:#FEE2E2; display:flex; align-items:center; justify-content:center; margin-bottom:20px;">
          <PhTrash style="width:24px; height:24px; color:#EF4444;" />
        </div>
        <h3 style="font-size:20px; font-weight:900; color:#0D1B2A; margin-bottom:8px;">Supprimer la catégorie ?</h3>
        <p style="font-size:14px; color:rgba(13,27,42,0.55); margin-bottom:28px; line-height:1.6;">
          La catégorie <strong>{{ toDelete.name }}</strong> sera supprimée définitivement. Cette action est irréversible.
        </p>
        <div style="display:flex; gap:12px;">
          <button
            @click="toDelete = null"
            style="flex:1; padding:12px; border-radius:100px; border:2px solid rgba(13,27,42,0.15); background:transparent; font-size:14px; font-weight:700; color:#0D1B2A; cursor:pointer; font-family:inherit;"
          >
            Annuler
          </button>
          <button
            @click="deleteCategory"
            style="flex:1; padding:12px; border-radius:100px; border:none; background:#EF4444; color:white; font-size:14px; font-weight:700; cursor:pointer; font-family:inherit; transition:all 0.2s;"
            class="delete-btn"
          >
            Supprimer
          </button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import {
  PhPlus, PhPencil, PhTrash, PhX, PhTag, PhInfo,
  PhArrowSquareOut, PhPuzzlePiece, PhArrowsDownUp,
  PhCircleNotch, PhFloppyDisk, PhCheckCircle,
  PhBriefcase, PhBooks, PhMonitor, PhUsers,
  PhTranslate, PhCertificate, PhChalkboardTeacher,
  PhCode, PhTrendUp, PhGlobe, PhGraduationCap,
  PhPalette, PhWrench, PhHeartbeat, PhLeaf,
  PhCamera, PhMusicNote, PhPaintBrush,
} from '@phosphor-icons/vue'

const props = defineProps({
  categories: Array,
})

// ── State ──────────────────────────────────────────────────
const showForm  = ref(false)
const editing   = ref(null)
const toDelete  = ref(null)
const submitting = ref(false)
const errors    = reactive({})

const form = reactive({
  name:        '',
  description: '',
  icon:        'PhGraduationCap',
  color:       'navy',
  sort_order:  0,
})

// ── Icônes disponibles ─────────────────────────────────────
const iconMap = {
  PhBriefcase:         PhBriefcase,
  PhBooks:             PhBooks,
  PhMonitor:           PhMonitor,
  PhUsers:             PhUsers,
  PhTranslate:         PhTranslate,
  PhCertificate:       PhCertificate,
  PhChalkboardTeacher: PhChalkboardTeacher,
  PhCode:              PhCode,
  PhTrendUp:           PhTrendUp,
  PhGlobe:             PhGlobe,
  PhGraduationCap:     PhGraduationCap,
  PhPalette:           PhPalette,
  PhWrench:            PhWrench,
  PhHeartbeat:         PhHeartbeat,
  PhLeaf:              PhLeaf,
  PhCamera:            PhCamera,
  PhMusicNote:         PhMusicNote,
  PhPaintBrush:        PhPaintBrush,
}

function getPhosphorIcon(name) {
  return iconMap[name] ?? PhGraduationCap
}

const iconSuggestions = [
  { name: 'PhBriefcase',         label: 'Pro',         icon: PhBriefcase },
  { name: 'PhBooks',             label: 'Scolaire',    icon: PhBooks },
  { name: 'PhMonitor',           label: 'Informatique',icon: PhMonitor },
  { name: 'PhUsers',             label: 'Management',  icon: PhUsers },
  { name: 'PhTranslate',         label: 'Langues',     icon: PhTranslate },
  { name: 'PhCertificate',       label: 'Certification',icon: PhCertificate },
  { name: 'PhChalkboardTeacher', label: 'Pédagogie',   icon: PhChalkboardTeacher },
  { name: 'PhCode',              label: 'Dev',         icon: PhCode },
  { name: 'PhTrendUp',           label: 'Marketing',   icon: PhTrendUp },
  { name: 'PhGlobe',             label: 'International',icon: PhGlobe },
]

// ── Thèmes couleurs ────────────────────────────────────────
const colorThemes = [
  { value: 'navy',   label: 'Marine',    accent: '#0D1B2A', gradient: 'linear-gradient(135deg,#0D1B2A,#1A2D42)' },
  { value: 'gold',   label: 'Or',        accent: '#C9A84C', gradient: 'linear-gradient(135deg,#C9A84C,#E2C97E)' },
  { value: 'teal',   label: 'Sarcelle',  accent: '#0D9488', gradient: 'linear-gradient(135deg,#0D9488,#14B8A6)' },
  { value: 'blue',   label: 'Bleu',      accent: '#2563EB', gradient: 'linear-gradient(135deg,#1A3A5C,#2563EB)' },
  { value: 'forest', label: 'Forêt',     accent: '#16A34A', gradient: 'linear-gradient(135deg,#2D4A3E,#16A34A)' },
  { value: 'purple', label: 'Violet',    accent: '#7C3AED', gradient: 'linear-gradient(135deg,#2B1F3D,#7C3AED)' },
  { value: 'red',    label: 'Rouge',     accent: '#DC2626', gradient: 'linear-gradient(135deg,#3D1F1F,#DC2626)' },
  { value: 'amber',  label: 'Ambre',     accent: '#D97706', gradient: 'linear-gradient(135deg,#3D2B1F,#D97706)' },
  { value: 'indigo', label: 'Indigo',    gradient: 'linear-gradient(135deg,#1E1B4B,#4F46E5)', accent: '#4F46E5' },
  { value: 'slate',  label: 'Ardoise',   gradient: 'linear-gradient(135deg,#1E293B,#475569)', accent: '#475569' },
]

function getColorTheme(colorValue) {
  return colorThemes.find(t => t.value === colorValue) ?? colorThemes[0]
}

function getCategoryGradient(cat) {
  return getColorTheme(cat.color).gradient
}

function getCategoryBg(cat) {
  const theme = getColorTheme(cat.color)
  return `${theme.accent}18`
}

function getCategoryColor(cat) {
  return getColorTheme(cat.color).accent
}

function getPreviewGradient() {
  return getColorTheme(form.color).gradient
}

// ── Actions ────────────────────────────────────────────────
function openCreate() {
  editing.value       = null
  Object.assign(form, { name: '', description: '', icon: 'PhGraduationCap', color: 'navy', sort_order: 0 })
  Object.keys(errors).forEach(k => delete errors[k])
  showForm.value = true
}

function openEdit(cat) {
  editing.value = cat
  Object.assign(form, {
    name:        cat.name        ?? '',
    description: cat.description ?? '',
    icon:        cat.icon        ?? 'PhGraduationCap',
    color:       cat.color       ?? 'navy',
    sort_order:  cat.sort_order  ?? 0,
  })
  Object.keys(errors).forEach(k => delete errors[k])
  showForm.value = true
}

function submitForm() {
  submitting.value = true
  Object.keys(errors).forEach(k => delete errors[k])

  const url    = editing.value
    ? route('admin.formations.categories.update', editing.value.id)
    : route('admin.formations.categories.store')
  const method = editing.value ? 'put' : 'post'

  router[method](url, { ...form }, {
    onSuccess: () => {
      showForm.value   = false
      submitting.value = false
    },
    onError: (errs) => {
      Object.assign(errors, errs)
      submitting.value = false
    },
    onFinish: () => {
      submitting.value = false
    },
  })
}

function confirmDelete(cat) {
  toDelete.value = cat
}

function deleteCategory() {
  router.delete(route('admin.formations.categories.destroy', toDelete.value.id), {
    onFinish: () => { toDelete.value = null },
  })
}
</script>

<style scoped>
.add-btn:hover     { background:#1A2D42 !important; transform:translateY(-1px); }
.category-card:hover { box-shadow:0 6px 28px rgba(13,27,42,0.1); transform:translateY(-2px); }
.icon-btn:hover    { background:#F4F6FA !important; color:#0D1B2A !important; border-color:rgba(13,27,42,0.2) !important; }
.icon-btn-danger:hover:not(:disabled) { background:#FEE2E2 !important; color:#EF4444 !important; border-color:#FCA5A5 !important; }
.icon-btn-danger:disabled { opacity:0.4; cursor:not-allowed; }
.cancel-btn:hover  { background:#F4F6FA !important; }
.submit-btn:hover:not(:disabled) { background:#1A2D42 !important; transform:translateY(-1px); }
.delete-btn:hover  { background:#DC2626 !important; transform:translateY(-1px); }
.f-label { display:block; font-size:12px; font-weight:700; color:#0D1B2A; margin-bottom:7px; }
.f-input { width:100%; padding:11px 13px; border:1.5px solid rgba(13,27,42,0.12); border-radius:11px; font-size:14px; color:#0D1B2A; outline:none; font-family:inherit; background:#FAF7F2; transition:border-color 0.2s; box-sizing:border-box; }
.f-input:focus { border-color:rgba(201,168,76,0.6); background:white; }
.f-input-error { border-color:#EF4444 !important; }
.f-error { font-size:12px; color:#EF4444; margin-top:5px; }
.spin { animation:spin 1s linear infinite; }
@keyframes spin { to { transform:rotate(360deg); } }
</style>