<template>
  <PublicLayout>
    <Head :title="formation.title" />

    <!-- Hero formation -->
    <section style="background:#0A1628; padding:140px 0 80px; position:relative; overflow:hidden;">
      <div class="orb orb-1" />
      <div style="max-width:1320px; margin:0 auto; padding:0 3rem; position:relative; z-index:1;">

        <!-- Breadcrumb -->
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:32px; font-size:13px; color:rgba(255,255,255,0.4);">
          <Link :href="route('home')" style="color:inherit; text-decoration:none;" class="hover-gold">Accueil</Link>
          <PhCaretRight style="width:12px; height:12px;" />
          <Link :href="route('formations.index')" style="color:inherit; text-decoration:none;" class="hover-gold">Formations</Link>
          <PhCaretRight style="width:12px; height:12px;" />
          <span style="color:rgba(255,255,255,0.7);">{{ formation.title }}</span>
        </div>

        <div style="display:grid; grid-template-columns:1fr 380px; gap:60px; align-items:start;">

          <!-- Gauche -->
          <div>
            <!-- Badges -->
            <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:24px;">
              <span v-if="formation.category" style="background:rgba(201,168,76,0.15); border:1px solid rgba(201,168,76,0.25); color:#C9A84C; font-size:12px; font-weight:700; padding:6px 14px; border-radius:100px;">
                {{ formation.category.name }}
              </span>
              <span v-if="formation.has_certification" style="background:rgba(201,168,76,0.15); border:1px solid rgba(201,168,76,0.25); color:#C9A84C; font-size:12px; font-weight:700; padding:6px 14px; border-radius:100px; display:inline-flex; align-items:center; gap:6px;">
                <PhCertificate style="width:13px; height:13px;" />
                Certifiante
              </span>
            </div>

            <h1 class="fade-up" style="--d:0.05s; font-size:clamp(32px,4vw,56px); font-weight:900; color:white; letter-spacing:-0.03em; line-height:1.1; margin-bottom:24px;">
              {{ formation.title }}
            </h1>

            <p style="font-size:17px; color:rgba(255,255,255,0.55); line-height:1.8; margin-bottom:36px; max-width:600px;">
              {{ formation.short_description }}
            </p>

            <!-- Méta infos -->
            <div style="display:flex; gap:28px; flex-wrap:wrap;">
              <div v-if="formation.level" style="display:flex; align-items:center; gap:8px; color:rgba(255,255,255,0.5); font-size:14px;">
                <PhChartBar style="width:16px; height:16px; color:#C9A84C;" />
                {{ levelLabel }}
              </div>
              <div v-if="formation.duration" style="display:flex; align-items:center; gap:8px; color:rgba(255,255,255,0.5); font-size:14px;">
                <PhClock style="width:16px; height:16px; color:#C9A84C;" />
                {{ formation.duration }}
              </div>
              <div v-if="formation.average_rating" style="display:flex; align-items:center; gap:8px;">
                <div style="display:flex; gap:2px;">
                  <PhStar v-for="i in 5" :key="i" style="width:14px; height:14px;" :style="i <= Math.round(formation.average_rating) ? 'color:#C9A84C;' : 'color:rgba(255,255,255,0.15);'" weight="fill" />
                </div>
                <span style="font-size:14px; font-weight:700; color:white;">{{ formation.average_rating }}</span>
                <span style="font-size:13px; color:rgba(255,255,255,0.4);">({{ formation.reviews_count }} avis)</span>
              </div>
            </div>
          </div>

          <!-- Droite : Carte inscription -->
          <div style="background:white; border-radius:24px; padding:32px; box-shadow:0 24px 80px rgba(0,0,0,0.3); position:sticky; top:100px;">
            <div v-if="formation.current_price" style="margin-bottom:24px;">
              <div style="font-size:42px; font-weight:900; color:#0D1B2A; line-height:1;">
                {{ formation.current_price }}€
              </div>
              <div v-if="formation.is_on_promo" style="display:flex; align-items:center; gap:8px; margin-top:6px;">
                <span style="font-size:16px; color:rgba(13,27,42,0.4); text-decoration:line-through;">{{ formation.price }}€</span>
                <span style="background:#FEF3C7; color:#92400E; font-size:12px; font-weight:700; padding:3px 10px; border-radius:100px;">Promo</span>
              </div>
            </div>
            <div v-else style="font-size:18px; font-weight:600; color:rgba(13,27,42,0.6); margin-bottom:24px;">
              Prix sur demande
            </div>

            <Link :href="route('contact')" style="display:flex; align-items:center; justify-content:center; gap:10px; background:#C9A84C; color:#0D1B2A; font-weight:800; font-size:15px; padding:16px; border-radius:100px; text-decoration:none; margin-bottom:12px; transition:all 0.3s;" class="cta-hover">
              <PhEnvelope style="width:18px; height:18px;" />
              S'inscrire à cette formation
            </Link>

            <a href="tel:+262262000000" style="display:flex; align-items:center; justify-content:center; gap:10px; background:transparent; color:#0D1B2A; font-weight:700; font-size:14px; padding:14px; border-radius:100px; text-decoration:none; border:2px solid rgba(13,27,42,0.15); transition:all 0.3s;" class="phone-hover">
              <PhPhone style="width:16px; height:16px;" />
              Appeler pour plus d'infos
            </a>
            <button
              @click="downloadPdf"
              style="display:flex; align-items:center; justify-content:center; gap:8px; width:100%; padding:12px; border-radius:100px; border:1.5px solid rgba(13,27,42,0.12); background:transparent; font-size:13px; font-weight:700; color:rgba(13,27,42,0.6); cursor:pointer; font-family:inherit; transition:all 0.2s; margin-top:10px;"
              class="pdf-btn"
            >
              <PhFilePdf style="width:16px; height:16px; color:#EF4444;" />
              Télécharger la fiche PDF
            </button>
            <div style="margin-top:24px; padding-top:24px; border-top:1px solid rgba(13,27,42,0.07); display:flex; flex-direction:column; gap:12px;">
              <div v-if="formation.duration" style="display:flex; align-items:center; justify-content:space-between; font-size:14px;">
                <span style="color:rgba(13,27,42,0.5);">Durée</span>
                <span style="font-weight:700; color:#0D1B2A;">{{ formation.duration }}</span>
              </div>
              <div style="display:flex; align-items:center; justify-content:space-between; font-size:14px;">
                <span style="color:rgba(13,27,42,0.5);">Niveau</span>
                <span style="font-weight:700; color:#0D1B2A;">{{ levelLabel }}</span>
              </div>
              <div v-if="formation.has_certification" style="display:flex; align-items:center; justify-content:space-between; font-size:14px;">
                <span style="color:rgba(13,27,42,0.5);">Certification</span>
                <span style="font-weight:700; color:#C9A84C; display:flex; align-items:center; gap:4px;">
                  <PhCheckCircle style="width:14px; height:14px;" weight="fill" />
                  Incluse
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contenu détaillé -->
    <section style="background:white; padding:80px 0;">
      <div style="max-width:1320px; margin:0 auto; padding:0 3rem;">
        <div style="display:grid; grid-template-columns:1fr 380px; gap:60px; align-items:start;">

          <!-- Gauche : détails -->
          <div>
            <!-- Objectifs -->
            <div v-if="formation.objectives?.length" style="margin-bottom:56px;">
              <h2 style="font-size:26px; font-weight:900; color:#0D1B2A; margin-bottom:28px; letter-spacing:-0.02em;">
                Ce que vous apprendrez
              </h2>
              <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                <div
                  v-for="obj in formation.objectives"
                  :key="obj"
                  style="display:flex; align-items:flex-start; gap:12px; padding:16px; background:#FAF7F2; border-radius:14px; border:1px solid rgba(13,27,42,0.05);"
                >
                  <PhCheckCircle style="width:18px; height:18px; color:#C9A84C; flex-shrink:0; margin-top:1px;" weight="fill" />
                  <span style="font-size:14px; color:#0D1B2A; line-height:1.5;">{{ obj }}</span>
                </div>
              </div>
            </div>

            <!-- Programme -->
            <div v-if="formation.program?.length" style="margin-bottom:56px;">
              <h2 style="font-size:26px; font-weight:900; color:#0D1B2A; margin-bottom:28px; letter-spacing:-0.02em;">
                Programme de la formation
              </h2>
              <div style="display:flex; flex-direction:column; gap:12px;">
                <div
                  v-for="(module, i) in formation.program"
                  :key="i"
                  style="border:1.5px solid rgba(13,27,42,0.08); border-radius:16px; overflow:hidden;"
                >
                  <div style="padding:18px 24px; display:flex; align-items:center; gap:16px; background:#FAF7F2;">
                    <span style="width:28px; height:28px; border-radius:8px; background:#0D1B2A; color:white; font-size:12px; font-weight:900; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                      {{ String(i + 1).padStart(2, '0') }}
                    </span>
                    <span style="font-size:15px; font-weight:700; color:#0D1B2A;">{{ module.title ?? module }}</span>
                  </div>
                  <div v-if="module.description" style="padding:16px 24px 18px;">
                    <p style="font-size:14px; color:rgba(13,27,42,0.6); line-height:1.65; margin:0;">{{ module.description }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Prérequis -->
            <div v-if="formation.prerequisites?.length" style="margin-bottom:56px;">
              <h2 style="font-size:26px; font-weight:900; color:#0D1B2A; margin-bottom:24px; letter-spacing:-0.02em;">
                Prérequis
              </h2>
              <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:10px;">
                <li
                  v-for="pre in formation.prerequisites"
                  :key="pre"
                  style="display:flex; align-items:center; gap:12px; font-size:15px; color:rgba(13,27,42,0.7);"
                >
                  <div style="width:6px; height:6px; border-radius:50%; background:#C9A84C; flex-shrink:0;" />
                  {{ pre }}
                </li>
              </ul>
            </div>

            <!-- Contenu HTML -->
            <div v-if="formation.content" style="margin-bottom:56px;">
              <h2 style="font-size:26px; font-weight:900; color:#0D1B2A; margin-bottom:28px; letter-spacing:-0.02em;">
                Description complète
              </h2>
              <div class="prose-content" v-html="formation.content" />
            </div>

            <!-- Avis -->
            <div v-if="formation.reviews?.length">
              <h2 style="font-size:26px; font-weight:900; color:#0D1B2A; margin-bottom:28px; letter-spacing:-0.02em;">
                Avis des apprenants
              </h2>
              <div style="display:flex; flex-direction:column; gap:20px;">
                <div
                  v-for="review in formation.reviews"
                  :key="review.reviewer_name"
                  style="padding:24px; background:#FAF7F2; border-radius:20px; border:1px solid rgba(13,27,42,0.05);"
                >
                  <div style="display:flex; gap:2px; margin-bottom:12px;">
                    <PhStar v-for="i in 5" :key="i" style="width:14px; height:14px;" :style="i <= review.rating ? 'color:#C9A84C;' : 'color:rgba(13,27,42,0.15);'" weight="fill" />
                  </div>
                  <p style="font-size:15px; color:rgba(13,27,42,0.7); line-height:1.7; margin-bottom:16px; font-style:italic;">
                    "{{ review.comment }}"
                  </p>
                  <div style="display:flex; align-items:center; justify-content:space-between;">
                    <div>
                      <span style="font-size:14px; font-weight:700; color:#0D1B2A;">{{ review.reviewer_name }}</span>
                      <span v-if="review.reviewer_job" style="font-size:13px; color:rgba(13,27,42,0.45); margin-left:8px;">— {{ review.reviewer_job }}</span>
                    </div>
                    <span style="font-size:12px; color:rgba(13,27,42,0.35);">{{ review.created_at }}</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Sessions -->
            <div v-if="formation.sessions?.length" style="margin-bottom:56px;">
              <h2 style="font-size:26px; font-weight:900; color:#0D1B2A; letter-spacing:-0.02em; margin-bottom:28px;">
                Prochaines sessions
              </h2>
              <div style="display:flex; flex-direction:column; gap:14px;">
                <div
                  v-for="session in formation.sessions"
                  :key="session.id"
                  style="border-radius:20px; padding:24px; border:1.5px solid rgba(13,27,42,0.08); display:flex; align-items:center; gap:20px; flex-wrap:wrap; transition:all 0.2s;"
                  :style="session.is_full ? 'background:#FAFAFA; opacity:0.75;' : 'background:white;'"
                  class="session-card"
                >
                  <!-- Indicateur modalité -->
                  <div
                    style="width:4px; height:52px; border-radius:2px; flex-shrink:0;"
                    :style="{ background: session.modality_color }"
                  />

                  <!-- Date -->
                  <div style="flex-shrink:0;">
                    <div style="font-size:18px; font-weight:900; color:#0D1B2A; line-height:1.2; letter-spacing:-0.01em;">
                      {{ session.formatted_start_date }}
                    </div>
                    <div v-if="session.formatted_end_date" style="font-size:13px; color:rgba(13,27,42,0.45); margin-top:2px;">
                      → {{ session.formatted_end_date }}
                    </div>
                  </div>

                  <!-- Infos -->
                  <div style="flex:1; min-width:0; display:flex; flex-direction:column; gap:6px;">
                    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                      <span
                        style="font-size:12px; font-weight:700; padding:3px 10px; border-radius:100px;"
                        :style="`background:${session.modality_color}15; color:${session.modality_color};`"
                      >
                        {{ session.modality_label }}
                      </span>
                      <span
                        style="font-size:12px; font-weight:700; padding:3px 10px; border-radius:100px;"
                        :style="getSessionStatusStyle(session.status)"
                      >
                        {{ getSessionStatusLabel(session.status) }}
                      </span>
                    </div>
                    <div style="display:flex; gap:16px; flex-wrap:wrap;">
                      <span v-if="session.schedule" style="font-size:13px; color:rgba(13,27,42,0.55); display:flex; align-items:center; gap:5px;">
                        <PhClock style="width:13px; height:13px;" />
                        {{ session.schedule }}
                      </span>
                      <span v-if="session.location" style="font-size:13px; color:rgba(13,27,42,0.55); display:flex; align-items:center; gap:5px;">
                        <PhMapPin style="width:13px; height:13px;" />
                        {{ session.location }}
                      </span>
                    </div>
                  </div>

                  <!-- Places -->
                  <div v-if="session.seats_total" style="text-align:center; flex-shrink:0;">
                    <div style="font-size:20px; font-weight:900; line-height:1;" :style="session.is_full ? 'color:#EF4444;' : 'color:#0D1B2A;'">
                      {{ session.seats_available }}
                      <span style="font-size:13px; color:rgba(13,27,42,0.4); font-weight:600;">/{{ session.seats_total }}</span>
                    </div>
                    <div style="font-size:11px; color:rgba(13,27,42,0.4); margin-top:3px;">places</div>
                    <div style="width:56px; height:4px; background:rgba(13,27,42,0.08); border-radius:2px; margin:6px auto 0; overflow:hidden;">
                      <div
                        style="height:100%; border-radius:2px; transition:width 0.5s;"
                        :style="{
                          width: `${(session.seats_taken / session.seats_total) * 100}%`,
                          background: session.is_full ? '#EF4444' : '#22C55E',
                        }"
                      />
                    </div>
                  </div>

                  <!-- Prix + CTA -->
                  <div style="flex-shrink:0; display:flex; flex-direction:column; align-items:flex-end; gap:8px;">
                    <div v-if="session.price_override" style="font-size:22px; font-weight:900; color:#0D1B2A; letter-spacing:-0.01em;">
                      {{ session.price_override }}€
                    </div>
                    <Link
                      :href="route('contact')"
                      :style="session.is_full
                        ? 'pointer-events:none; opacity:0.5; display:inline-flex; align-items:center; gap:7px; padding:10px 18px; border-radius:100px; background:#EF4444; color:white; font-weight:700; font-size:13px; text-decoration:none;'
                        : 'display:inline-flex; align-items:center; gap:7px; padding:10px 18px; border-radius:100px; background:#C9A84C; color:#0D1B2A; font-weight:800; font-size:13px; text-decoration:none; transition:all 0.3s;'"
                      class="session-cta"
                    >
                      <PhEnvelope style="width:14px; height:14px;" />
                      {{ session.is_full ? 'Complet' : "S'inscrire" }}
                    </Link>
                  </div>
                </div>
              </div>
            </div>

            <!-- Si aucune session -->
            <div v-else-if="formation.sessions !== undefined" style="margin-bottom:40px; padding:28px; background:#FAF7F2; border-radius:16px; border:1.5px dashed rgba(13,27,42,0.1); text-align:center;">
              <PhCalendarX style="width:32px; height:32px; color:rgba(13,27,42,0.25); margin:0 auto 12px; display:block;" />
              <p style="font-size:14px; color:rgba(13,27,42,0.45); margin:0; line-height:1.6;">
                Aucune session programmée pour le moment.<br>
                <Link :href="route('contact')" style="color:#C9A84C; font-weight:600; text-decoration:none;">Contactez-nous</Link> pour connaître les prochaines dates.
              </p>
            </div>
          </div>

          <!-- Droite : formations similaires -->
          <div style="position:sticky; top:100px;">
            <h3 style="font-size:18px; font-weight:800; color:#0D1B2A; margin-bottom:20px; letter-spacing:-0.01em;">
              Formations similaires
            </h3>
            <div v-if="relatedFormations?.length" style="display:flex; flex-direction:column; gap:16px;">
              <Link
                v-for="f in relatedFormations"
                :key="f.id"
                :href="route('formations.show', f.slug)"
                style="display:flex; gap:14px; padding:16px; background:white; border:1.5px solid rgba(13,27,42,0.07); border-radius:16px; text-decoration:none; transition:all 0.3s;" class="related-hover"
              >
                <img :src="f.thumbnail_url" :alt="f.title" style="width:72px; height:56px; object-fit:cover; border-radius:10px; flex-shrink:0;" />
                <div>
                  <div style="font-size:14px; font-weight:700; color:#0D1B2A; line-height:1.4; margin-bottom:4px;">{{ f.title }}</div>
                  <div v-if="f.current_price" style="font-size:13px; font-weight:800; color:#C9A84C;">{{ f.current_price }}€</div>
                  <div v-else style="font-size:13px; color:rgba(13,27,42,0.4);">Sur demande</div>
                </div>
              </Link>
            </div>
            <div v-else style="text-align:center; padding:32px; background:#FAF7F2; border-radius:16px; border:1px dashed rgba(13,27,42,0.1);">
              <p style="font-size:14px; color:rgba(13,27,42,0.4);">Aucune formation similaire</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA bottom -->
    <section style="background:#0A1628; padding:100px 0; text-align:center; position:relative; overflow:hidden;">
      <div class="orb orb-1" style="opacity:0.2;" />
      <div style="max-width:700px; margin:0 auto; padding:0 3rem; position:relative; z-index:1;">
        <h2 style="font-size:clamp(32px,4vw,52px); font-weight:900; color:white; letter-spacing:-0.03em; margin-bottom:20px;">
          Intéressé par cette formation ?
        </h2>
        <p style="font-size:17px; color:rgba(255,255,255,0.5); margin-bottom:40px; line-height:1.7;">
          Contactez-nous pour obtenir plus d'informations ou pour vous inscrire.
        </p>
        <Link :href="route('contact')" style="display:inline-flex; align-items:center; gap:10px; background:#C9A84C; color:#0D1B2A; font-weight:800; font-size:15px; padding:16px 36px; border-radius:100px; text-decoration:none;" class="cta-hover">
          <PhEnvelope style="width:18px; height:18px;" />
          Nous contacter
        </Link>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup>
import { computed } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import {
  PhCaretRight, PhCertificate, PhChartBar, PhClock, PhStar,
  PhEnvelope, PhPhone, PhCheckCircle, PhFilePdf, PhCalendarX
} from '@phosphor-icons/vue'
function getSessionStatusLabel(status) {
  return {
    ouvert:   'Inscriptions ouvertes',
    bientot:  'Commence bientôt',
    complet:  'Complet',
    en_cours: 'Session en cours',
  }[status] ?? status
}

function getSessionStatusStyle(status) {
  return {
    ouvert:   'background:rgba(34,197,94,0.1); color:#16A34A;',
    bientot:  'background:rgba(245,158,11,0.1); color:#D97706;',
    complet:  'background:rgba(239,68,68,0.1); color:#DC2626;',
    en_cours: 'background:rgba(59,130,246,0.1); color:#2563EB;',
  }[status] ?? 'background:#F1F3F7; color:rgba(13,27,42,0.5);'
}
const props = defineProps({
  formation:         Object,
  relatedFormations: Array,
})
function downloadPdf() {
  window.open(route('formations.pdf', formation.slug), '_blank')
}
const levelLabels = { debutant:'Débutant', intermediaire:'Intermédiaire', avance:'Avancé', tous:'Tous niveaux' }
const levelLabel  = computed(() => levelLabels[props.formation?.level] ?? props.formation?.level)
</script>

<style scoped>
.orb { position:absolute; border-radius:50%; filter:blur(100px); pointer-events:none; }
.orb-1 { width:600px; height:600px; background:radial-gradient(circle,rgba(201,168,76,0.12) 0%,transparent 70%); top:-200px; right:-100px; }
.fade-up { animation:fadeUp 0.7s cubic-bezier(0.16,1,0.3,1) both; animation-delay:var(--d,0s); }
@keyframes fadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
.hover-gold:hover { color:#C9A84C !important; }
.cta-hover:hover { background:#E2C97E !important; transform:translateY(-2px); box-shadow:0 8px 32px rgba(201,168,76,0.35); }
.phone-hover:hover { background:#0D1B2A !important; color:white !important; }
.related-hover:hover { border-color:rgba(201,168,76,0.3) !important; box-shadow:0 4px 20px rgba(13,27,42,0.08); transform:translateY(-2px); }
.prose-content { font-size:15px; color:rgba(13,27,42,0.7); line-height:1.8; }
.prose-content h2, .prose-content h3 { color:#0D1B2A; font-weight:800; margin:28px 0 12px; }
.prose-content p { margin-bottom:16px; }
.prose-content ul { padding-left:20px; margin-bottom:16px; }
.prose-content li { margin-bottom:6px; }
.session-card:hover   { box-shadow:0 4px 24px rgba(13,27,42,0.08); transform:translateX(4px); }
.session-cta:hover    { transform:translateY(-2px) !important; box-shadow:0 4px 16px rgba(201,168,76,0.3); }
.pdf-btn:hover        { background:#FAF7F2 !important; color:#0D1B2A !important; }
</style>