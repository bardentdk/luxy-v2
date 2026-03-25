<template>
  <AdminLayout>
    <Head :title="`Sessions — ${formation.title}`" />

    <div style="max-width:1000px; display:flex; flex-direction:column; gap:24px;">

      <!-- Header -->
      <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap;">
        <Link
          :href="route('admin.formations.index')"
          style="width:36px; height:36px; border-radius:10px; border:1.5px solid rgba(13,27,42,0.12); display:flex; align-items:center; justify-content:center; color:rgba(13,27,42,0.5); text-decoration:none; flex-shrink:0; transition:all 0.2s;"
          class="back-btn"
        >
          <PhArrowLeft style="width:16px; height:16px;" />
        </Link>
        <div style="flex:1; min-width:0;">
          <h1 style="font-size:22px; font-weight:900; color:#0D1B2A; letter-spacing:-0.02em; margin:0 0 2px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
            Sessions — {{ formation.title }}
          </h1>
          <p style="font-size:13px; color:rgba(13,27,42,0.4); margin:0;">
            {{ sessions.length }} session{{ sessions.length > 1 ? 's' : '' }} configurée{{ sessions.length > 1 ? 's' : '' }}
          </p>
        </div>
        <button
          @click="openForm(null)"
          style="display:inline-flex; align-items:center; gap:8px; background:#0D1B2A; color:white; font-weight:700; font-size:13px; padding:10px 18px; border-radius:12px; border:none; cursor:pointer; font-family:inherit; transition:all 0.2s; flex-shrink:0;"
          class="add-btn"
        >
          <PhPlus style="width:15px; height:15px;" />
          Nouvelle session
        </button>
      </div>

      <!-- Alertes si aucune session -->
      <div v-if="!sessions.length" style="background:white; border-radius:20px; padding:60px; text-align:center; border:2px dashed rgba(13,27,42,0.1);">
        <div style="width:64px; height:64px; border-radius:18px; background:rgba(201,168,76,0.1); display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
          <PhCalendarPlus style="width:28px; height:28px; color:rgba(201,168,76,0.6);" />
        </div>
        <h3 style="font-size:18px; font-weight:800; color:#0D1B2A; margin:0 0 8px;">Aucune session configurée</h3>
        <p style="font-size:14px; color:rgba(13,27,42,0.45); margin:0 0 24px;">
          Créez des sessions pour que les apprenants puissent s'inscrire à des dates précises.
        </p>
        <button
          @click="openForm(null)"
          style="display:inline-flex; align-items:center; gap:8px; background:#C9A84C; color:#0D1B2A; font-weight:800; font-size:14px; padding:12px 24px; border-radius:100px; border:none; cursor:pointer; font-family:inherit;"
        >
          <PhPlus style="width:15px; height:15px;" />
          Créer la première session
        </button>
      </div>

      <!-- Liste des sessions -->
      <div v-else style="display:flex; flex-direction:column; gap:12px;">
        <div
          v-for="session in sessions"
          :key="session.id"
          style="background:white; border-radius:16px; padding:20px 24px; border:1.5px solid rgba(13,27,42,0.06); display:flex; align-items:center; gap:20px; transition:all 0.2s;"
          class="session-row"
          :style="!session.is_published ? 'opacity:0.65;' : ''"
        >
          <!-- Indicateur modalité -->
          <div
            style="width:4px; height:56px; border-radius:2px; flex-shrink:0;"
            :style="{ background: session.modality_color }"
          />

          <!-- Infos principales -->
          <div style="flex:1; min-width:0;">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:6px; flex-wrap:wrap;">
              <span style="font-size:15px; font-weight:800; color:#0D1B2A;">
                {{ session.label ?? session.formatted_start_date }}
              </span>
              <span
                style="font-size:11px; font-weight:700; padding:3px 10px; border-radius:100px;"
                :style="getStatusStyle(session.status)"
              >
                {{ getStatusLabel(session.status) }}
              </span>
              <span
                style="font-size:11px; font-weight:600; padding:3px 10px; border-radius:100px;"
                :style="`background:${session.modality_color}18; color:${session.modality_color};`"
              >
                {{ session.modality_label }}
              </span>
            </div>

            <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap;">
              <span style="font-size:13px; color:rgba(13,27,42,0.6); display:flex; align-items:center; gap:5px;">
                <PhCalendarBlank style="width:13px; height:13px;" />
                {{ session.formatted_start_date }}
                <span v-if="session.formatted_end_date"> → {{ session.formatted_end_date }}</span>
              </span>
              <span v-if="session.schedule" style="font-size:13px; color:rgba(13,27,42,0.6); display:flex; align-items:center; gap:5px;">
                <PhClock style="width:13px; height:13px;" />
                {{ session.schedule }}
              </span>
              <span v-if="session.location" style="font-size:13px; color:rgba(13,27,42,0.6); display:flex; align-items:center; gap:5px;">
                <PhMapPin style="width:13px; height:13px;" />
                {{ session.location }}
              </span>
            </div>
          </div>

          <!-- Places -->
          <div v-if="session.seats_total" style="text-align:center; flex-shrink:0;">
            <div style="font-size:18px; font-weight:900; color:#0D1B2A; line-height:1;">
              {{ session.seats_available }}
              <span style="font-size:12px; font-weight:600; color:rgba(13,27,42,0.4);">/{{ session.seats_total }}</span>
            </div>
            <div style="font-size:11px; color:rgba(13,27,42,0.4); margin-top:2px;">places libres</div>
            <!-- Barre de remplissage -->
            <div style="width:60px; height:4px; background:rgba(13,27,42,0.1); border-radius:2px; margin:6px auto 0; overflow:hidden;">
              <div
                style="height:100%; border-radius:2px; transition:width 0.3s;"
                :style="{
                  width: `${(session.seats_taken / session.seats_total) * 100}%`,
                  background: session.is_full ? '#EF4444' : '#22C55E',
                }"
              />
            </div>
          </div>
          <div v-else style="font-size:12px; color:rgba(13,27,42,0.35); flex-shrink:0; text-align:center;">
            Places<br>illimitées
          </div>

          <!-- Prix -->
          <div v-if="session.price_override" style="text-align:right; flex-shrink:0;">
            <div style="font-size:18px; font-weight:900; color:#C9A84C; line-height:1;">{{ session.price_override }}€</div>
            <div style="font-size:11px; color:rgba(13,27,42,0.4);">prix session</div>
          </div>

          <!-- Actions -->
          <div style="display:flex; align-items:center; gap:8px; flex-shrink:0;">
            <button
              @click="toggleSession(session)"
              style="width:32px; height:32px; border-radius:8px; border:1.5px solid; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all 0.2s;"
              :style="session.is_open ? 'background:rgba(34,197,94,0.08); border-color:rgba(34,197,94,0.3); color:#16A34A;' : 'background:rgba(239,68,68,0.08); border-color:rgba(239,68,68,0.2); color:#DC2626;'"
              :title="session.is_open ? 'Fermer les inscriptions' : 'Ouvrir les inscriptions'"
            >
              <PhLockOpen v-if="session.is_open" style="width:14px; height:14px;" />
              <PhLock v-else style="width:14px; height:14px;" />
            </button>
            <button
              @click="openForm(session)"
              style="width:32px; height:32px; border-radius:8px; border:1.5px solid rgba(13,27,42,0.1); background:white; display:flex; align-items:center; justify-content:center; cursor:pointer; color:rgba(13,27,42,0.5); transition:all 0.2s;"
              class="icon-btn"
            >
              <PhPencil style="width:14px; height:14px;" />
            </button>
            <button
              @click="confirmDelete(session)"
              style="width:32px; height:32px; border-radius:8px; border:1.5px solid rgba(13,27,42,0.1); background:white; display:flex; align-items:center; justify-content:center; cursor:pointer; color:rgba(13,27,42,0.5); transition:all 0.2s;"
              class="icon-btn-danger"
            >
              <PhTrash style="width:14px; height:14px;" />
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal formulaire session -->
    <div
      v-if="showForm"
      style="position:fixed; inset:0; background:rgba(10,22,40,0.6); z-index:1000; display:flex; align-items:center; justify-content:center; padding:20px; backdrop-filter:blur(4px);"
      @click.self="showForm = false"
    >
      <div style="background:white; border-radius:24px; padding:36px; width:100%; max-width:580px; max-height:90vh; overflow-y:auto; box-shadow:0 32px 80px rgba(0,0,0,0.3);">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px;">
          <h2 style="font-size:20px; font-weight:900; color:#0D1B2A; margin:0; letter-spacing:-0.02em;">
            {{ editingSession ? 'Modifier la session' : 'Nouvelle session' }}
          </h2>
          <button @click="showForm = false" style="width:32px; height:32px; border-radius:8px; border:1.5px solid rgba(13,27,42,0.1); background:transparent; cursor:pointer; display:flex; align-items:center; justify-content:center; color:rgba(13,27,42,0.4);" class="icon-btn">
            <PhX style="width:16px; height:16px;" />
          </button>
        </div>

        <form @submit.prevent="submitForm" style="display:flex; flex-direction:column; gap:18px;">

          <!-- Label -->
          <div>
            <label class="f-label">Titre de la session</label>
            <input v-model="sessionForm.label" type="text" placeholder="Ex: Session printemps 2026" class="f-input" />
          </div>

          <!-- Dates -->
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
            <div>
              <label class="f-label">Date de début <span style="color:#C9A84C;">*</span></label>
              <input v-model="sessionForm.start_date" type="date" required class="f-input" />
            </div>
            <div>
              <label class="f-label">Date de fin</label>
              <input v-model="sessionForm.end_date" type="date" class="f-input" />
            </div>
          </div>

          <!-- Horaires + Lieu -->
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
            <div>
              <label class="f-label">Horaires</label>
              <input v-model="sessionForm.schedule" type="text" placeholder="Ex: Lun/Mer 18h-20h" class="f-input" />
            </div>
            <div>
              <label class="f-label">Lieu</label>
              <input v-model="sessionForm.location" type="text" placeholder="Ex: Saint-Denis ou En ligne" class="f-input" />
            </div>
          </div>

          <!-- Modalité -->
          <div>
            <label class="f-label">Modalité <span style="color:#C9A84C;">*</span></label>
            <div style="display:flex; gap:10px;">
              <button
                v-for="m in modalities"
                :key="m.value"
                type="button"
                @click="sessionForm.modality = m.value"
                style="flex:1; padding:10px; border-radius:10px; font-size:13px; font-weight:700; cursor:pointer; transition:all 0.2s; border:2px solid;"
                :style="sessionForm.modality === m.value
                  ? `background:${m.color}15; border-color:${m.color}; color:${m.color};`
                  : 'background:transparent; border-color:rgba(13,27,42,0.12); color:rgba(13,27,42,0.5);'"
              >
                {{ m.label }}
              </button>
            </div>
          </div>

          <!-- Places + Prix -->
          <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:14px;">
            <div>
              <label class="f-label">Nb de places</label>
              <input v-model.number="sessionForm.seats_total" type="number" min="1" placeholder="Illimité" class="f-input" />
            </div>
            <div v-if="editingSession">
              <label class="f-label">Places prises</label>
              <input v-model.number="sessionForm.seats_taken" type="number" min="0" class="f-input" />
            </div>
            <div>
              <label class="f-label">Prix spécifique (€)</label>
              <input v-model.number="sessionForm.price_override" type="number" step="0.01" min="0" placeholder="Prix formation" class="f-input" />
            </div>
          </div>

          <!-- Notes -->
          <div>
            <label class="f-label">Notes internes</label>
            <textarea v-model="sessionForm.notes" rows="2" placeholder="Notes visibles uniquement en admin..." class="f-input" style="resize:vertical;" />
          </div>

          <!-- Toggles -->
          <div style="display:flex; gap:12px; flex-wrap:wrap; padding-top:4px;">
            <label style="display:flex; align-items:center; gap:10px; cursor:pointer; padding:10px 14px; background:#F8F9FB; border-radius:10px; flex:1;">
              <div class="toggle" :class="{ active: sessionForm.is_open }" @click="sessionForm.is_open = !sessionForm.is_open">
                <div class="toggle-thumb" />
              </div>
              <div>
                <div style="font-size:13px; font-weight:700; color:#0D1B2A; line-height:1.2;">Inscriptions ouvertes</div>
                <div style="font-size:11px; color:rgba(13,27,42,0.4);">Visible et réservable</div>
              </div>
            </label>
            <label style="display:flex; align-items:center; gap:10px; cursor:pointer; padding:10px 14px; background:#F8F9FB; border-radius:10px; flex:1;">
              <div class="toggle" :class="{ active: sessionForm.is_published }" @click="sessionForm.is_published = !sessionForm.is_published">
                <div class="toggle-thumb" />
              </div>
              <div>
                <div style="font-size:13px; font-weight:700; color:#0D1B2A; line-height:1.2;">Publier la session</div>
                <div style="font-size:11px; color:rgba(13,27,42,0.4);">Affichée sur la fiche</div>
              </div>
            </label>
          </div>

          <!-- Boutons -->
          <div style="display:flex; gap:12px; padding-top:8px;">
            <button
              type="button"
              @click="showForm = false"
              style="flex:1; padding:12px; border-radius:100px; border:2px solid rgba(13,27,42,0.15); background:transparent; font-size:14px; font-weight:700; color:#0D1B2A; cursor:pointer; font-family:inherit;"
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
              {{ submitting ? 'Enregistrement...' : (editingSession ? 'Mettre à jour' : 'Créer la session') }}
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal suppression -->
    <div
      v-if="toDelete"
      style="position:fixed; inset:0; background:rgba(10,22,40,0.6); z-index:1000; display:flex; align-items:center; justify-content:center; padding:20px;"
      @click.self="toDelete = null"
    >
      <div style="background:white; border-radius:24px; padding:36px; max-width:420px; width:100%;">
        <div style="width:52px; height:52px; border-radius:14px; background:#FEE2E2; display:flex; align-items:center; justify-content:center; margin-bottom:20px;">
          <PhTrash style="width:24px; height:24px; color:#EF4444;" />
        </div>
        <h3 style="font-size:20px; font-weight:900; color:#0D1B2A; margin-bottom:8px;">Supprimer cette session ?</h3>
        <p style="font-size:14px; color:rgba(13,27,42,0.55); margin-bottom:28px; line-height:1.6;">
          La session du <strong>{{ toDelete.formatted_start_date }}</strong> sera supprimée définitivement.
        </p>
        <div style="display:flex; gap:12px;">
          <button @click="toDelete = null" style="flex:1; padding:12px; border-radius:100px; border:2px solid rgba(13,27,42,0.15); background:transparent; font-size:14px; font-weight:700; color:#0D1B2A; cursor:pointer; font-family:inherit;">
            Annuler
          </button>
          <button @click="deleteSession" style="flex:1; padding:12px; border-radius:100px; border:none; background:#EF4444; color:white; font-size:14px; font-weight:700; cursor:pointer; font-family:inherit;" class="delete-btn">
            Supprimer
          </button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import {
  PhArrowLeft, PhPlus, PhPencil, PhTrash, PhX,
  PhCalendarBlank, PhClock, PhMapPin, PhCalendarPlus,
  PhLock, PhLockOpen, PhCircleNotch, PhFloppyDisk,
} from '@phosphor-icons/vue'

const props = defineProps({
  formation: Object,
  sessions:  Array,
})

const showForm      = ref(false)
const editingSession = ref(null)
const submitting    = ref(false)
const toDelete      = ref(null)

const defaultForm = {
  label:          '',
  start_date:     '',
  end_date:       '',
  schedule:       '',
  location:       '',
  modality:       'presentiel',
  seats_total:    null,
  seats_taken:    0,
  price_override: null,
  is_open:        true,
  is_published:   true,
  notes:          '',
}

const sessionForm = reactive({ ...defaultForm })

const modalities = [
  { value: 'presentiel',  label: 'Présentiel', color: '#0D9488' },
  { value: 'distanciel',  label: 'En ligne',   color: '#3B82F6' },
  { value: 'hybride',     label: 'Hybride',    color: '#8B5CF6' },
]

function getStatusLabel(status) {
  return {
    ouvert:   'Ouvert',
    bientot:  'Bientôt',
    complet:  'Complet',
    en_cours: 'En cours',
  }[status] ?? status
}

function getStatusStyle(status) {
  return {
    ouvert:   'background:rgba(34,197,94,0.1); color:#16A34A;',
    bientot:  'background:rgba(245,158,11,0.1); color:#D97706;',
    complet:  'background:rgba(239,68,68,0.1); color:#DC2626;',
    en_cours: 'background:rgba(59,130,246,0.1); color:#2563EB;',
  }[status] ?? 'background:#F1F3F7; color:rgba(13,27,42,0.5);'
}

function openForm(session) {
  editingSession.value = session
  if (session) {
    Object.assign(sessionForm, {
      label:          session.label          ?? '',
      start_date:     session.start_date     ?? '',
      end_date:       session.end_date       ?? '',
      schedule:       session.schedule       ?? '',
      location:       session.location       ?? '',
      modality:       session.modality       ?? 'presentiel',
      seats_total:    session.seats_total    ?? null,
      seats_taken:    session.seats_taken    ?? 0,
      price_override: session.price_override ?? null,
      is_open:        session.is_open        ?? true,
      is_published:   session.is_published   ?? true,
      notes:          session.notes          ?? '',
    })
  } else {
    Object.assign(sessionForm, { ...defaultForm })
  }
  showForm.value = true
}

function submitForm() {
  submitting.value = true
  const routeName = editingSession.value
    ? route('admin.formations.sessions.update', [props.formation.id, editingSession.value.id])
    : route('admin.formations.sessions.store', props.formation.id)

  const method = editingSession.value ? 'put' : 'post'

  router[method](routeName, { ...sessionForm }, {
    onFinish: () => {
      submitting.value = false
      showForm.value   = false
    },
  })
}

function toggleSession(session) {
  router.patch(route('admin.formations.sessions.toggle', [props.formation.id, session.id]))
}

function confirmDelete(session) {
  toDelete.value = session
}

function deleteSession() {
  router.delete(route('admin.formations.sessions.destroy', [props.formation.id, toDelete.value.id]), {
    onFinish: () => { toDelete.value = null },
  })
}
</script>

<style scoped>
.back-btn:hover   { background:#F4F6FA !important; color:#0D1B2A !important; }
.add-btn:hover    { background:#1A2D42 !important; transform:translateY(-1px); }
.session-row:hover{ box-shadow:0 4px 20px rgba(13,27,42,0.07); transform:translateY(-1px); }
.icon-btn:hover   { background:#F4F6FA !important; color:#0D1B2A !important; }
.icon-btn-danger:hover { background:#FEE2E2 !important; color:#EF4444 !important; border-color:#FCA5A5 !important; }
.delete-btn:hover { background:#DC2626 !important; }
.submit-btn:hover:not(:disabled) { background:#1A2D42 !important; }
.f-label { display:block; font-size:12px; font-weight:700; color:#0D1B2A; margin-bottom:7px; }
.f-input { width:100%; padding:11px 13px; border:1.5px solid rgba(13,27,42,0.12); border-radius:11px; font-size:14px; color:#0D1B2A; outline:none; font-family:inherit; background:#FAF7F2; transition:border-color 0.2s; box-sizing:border-box; }
.f-input:focus { border-color:rgba(201,168,76,0.6); background:white; }
.toggle { width:40px; height:22px; border-radius:100px; background:rgba(13,27,42,0.15); position:relative; transition:background 0.2s; flex-shrink:0; cursor:pointer; }
.toggle.active { background:#0D1B2A; }
.toggle-thumb { width:16px; height:16px; border-radius:50%; background:white; position:absolute; top:3px; left:3px; transition:transform 0.2s; box-shadow:0 1px 4px rgba(0,0,0,0.2); }
.toggle.active .toggle-thumb { transform:translateX(18px); }
.spin { animation:spin 1s linear infinite; }
@keyframes spin { to { transform:rotate(360deg); } }
</style>