<template>
  <PublicLayout>
    <Head :title="formation.title" />

    <!-- Hero -->
    <section style="position:relative; background:white; padding:140px 0 0; overflow:hidden;">
      <div style="position:absolute; top:-200px; right:-200px; width:700px; height:700px; border-radius:50%; background:radial-gradient(circle, rgba(201,168,76,0.08) 0%, transparent 65%); pointer-events:none;" />
      <div style="position:absolute; left:0; top:20%; bottom:20%; width:3px; background:linear-gradient(to bottom, transparent, #C9A84C 40%, #E2C97E 60%, transparent); border-radius:2px;" />

      <div style="max-width:1400px; margin:0 auto; padding:0 3rem; position:relative; z-index:1;">

        <!-- Breadcrumb -->
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:32px; font-size:13px; color:rgba(13,27,42,0.4); flex-wrap:wrap;">
          <Link :href="route('home')" style="color:inherit; text-decoration:none; transition:color 0.2s;" class="bc-link">Accueil</Link>
          <PhCaretRight style="width:12px; height:12px; flex-shrink:0;" />
          <Link :href="route('formations.index')" style="color:inherit; text-decoration:none; transition:color 0.2s;" class="bc-link">Formations</Link>
          <PhCaretRight style="width:12px; height:12px; flex-shrink:0;" />
          <span style="color:rgba(13,27,42,0.65); overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width:280px;">{{ formation.title }}</span>
        </div>

        <div style="display:grid; grid-template-columns:1fr 380px; gap:60px; align-items:start;">

          <!-- Gauche -->
          <div>
            <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:20px;">
              <span v-if="formation.category" style="background:rgba(201,168,76,0.1); border:1px solid rgba(201,168,76,0.25); color:#A07828; font-size:12px; font-weight:700; padding:5px 14px; border-radius:100px; font-family:'Syne',sans-serif;">
                {{ formation.category.name }}
              </span>
              <span v-if="formation.has_certification" style="background:rgba(201,168,76,0.1); border:1px solid rgba(201,168,76,0.25); color:#A07828; font-size:12px; font-weight:700; padding:5px 12px; border-radius:100px; display:inline-flex; align-items:center; gap:5px; font-family:'Syne',sans-serif;">
                <PhCertificate style="width:12px; height:12px;" /> Certifiante
              </span>
            </div>

            <h1 data-reveal style="font-family:'Syne',sans-serif; font-size:clamp(32px,4.5vw,58px); font-weight:800; color:#0D1B2A; letter-spacing:-0.035em; line-height:1.05; margin-bottom:22px;">
              {{ formation.title }}
            </h1>

            <p style="font-size:17px; color:rgba(13,27,42,0.55); line-height:1.8; margin-bottom:32px; max-width:580px;">
              {{ formation.short_description }}
            </p>

            <!-- Méta -->
            <div style="display:flex; gap:24px; flex-wrap:wrap; margin-bottom:40px;">
              <div v-if="formation.level" style="display:flex; align-items:center; gap:8px; font-size:14px; color:rgba(13,27,42,0.6);">
                <PhChartBar style="width:16px; height:16px; color:#C9A84C;" /> {{ levelLabel }}
              </div>
              <div v-if="formation.duration" style="display:flex; align-items:center; gap:8px; font-size:14px; color:rgba(13,27,42,0.6);">
                <PhClock style="width:16px; height:16px; color:#C9A84C;" /> {{ formation.duration }}
              </div>
              <div v-if="formation.average_rating > 0" style="display:flex; align-items:center; gap:8px;">
                <div style="display:flex; gap:2px;">
                  <PhStar v-for="i in 5" :key="i" style="width:14px; height:14px;" :style="i <= Math.round(formation.average_rating) ? 'color:#C9A84C;' : 'color:rgba(13,27,42,0.12);'" weight="fill" />
                </div>
                <span style="font-size:14px; font-weight:700; color:#0D1B2A;">{{ formation.average_rating }}</span>
                <span style="font-size:13px; color:rgba(13,27,42,0.4);">({{ formation.reviews_count }} avis)</span>
              </div>
            </div>
          </div>

          <!-- Droite : carte inscription sticky -->
          <div style="position:sticky; top:100px; background:white; border-radius:24px; border:1.5px solid rgba(201,168,76,0.2); padding:32px; box-shadow:0 20px 60px rgba(13,27,42,0.1);">
            <div v-if="formation.current_price" style="margin-bottom:24px;">
              <div style="font-family:'Syne',sans-serif; font-size:42px; font-weight:800; color:#0D1B2A; line-height:1; letter-spacing:-0.03em;" class="text-gradient-gold">
                {{ formation.current_price }}€
              </div>
              <div v-if="formation.is_on_promo" style="display:flex; align-items:center; gap:8px; margin-top:6px;">
                <span style="font-size:15px; color:rgba(13,27,42,0.35); text-decoration:line-through;">{{ formation.price }}€</span>
                <span style="background:rgba(201,168,76,0.12); border:1px solid rgba(201,168,76,0.25); color:#A07828; font-size:11px; font-weight:800; padding:3px 10px; border-radius:100px; letter-spacing:0.03em;">PROMO</span>
              </div>
            </div>
            <div v-else style="font-size:17px; font-weight:600; color:rgba(13,27,42,0.5); margin-bottom:24px;">Prix sur demande</div>

            <Link :href="route('contact')" class="btn-gold" style="width:100%; justify-content:center; margin-bottom:12px; box-sizing:border-box;">
              <PhEnvelope style="width:16px; height:16px;" /> S'inscrire à cette formation
            </Link>

            <a href="tel:+262262000000" style="display:flex; align-items:center; justify-content:center; gap:8px; padding:13px; border-radius:100px; border:1.5px solid rgba(13,27,42,0.12); color:rgba(13,27,42,0.65); font-size:14px; font-weight:700; text-decoration:none; transition:all 0.2s; font-family:'Syne',sans-serif; margin-bottom:12px;" class="phone-btn">
              <PhPhone style="width:15px; height:15px;" /> Appeler pour plus d'infos
            </a>

            <!-- Télécharger PDF -->
            <button @click="downloadPdf" style="display:flex; align-items:center; justify-content:center; gap:8px; width:100%; padding:12px; border-radius:100px; border:1.5px solid rgba(201,168,76,0.2); background:rgba(201,168,76,0.05); font-size:13px; font-weight:700; color:#A07828; cursor:none; font-family:'Syne',sans-serif; transition:all 0.2s;" class="pdf-btn">
              <PhFilePdf style="width:15px; height:15px; color:#C9A84C;" /> Télécharger la fiche PDF
            </button>

            <!-- Infos rapides -->
            <div style="margin-top:24px; padding-top:24px; border-top:1px solid rgba(13,27,42,0.07); display:flex; flex-direction:column; gap:12px;">
              <div v-if="formation.duration" style="display:flex; align-items:center; justify-content:space-between; font-size:14px;">
                <span style="color:rgba(13,27,42,0.45);">Durée</span>
                <span style="font-weight:700; color:#0D1B2A; font-family:'Syne',sans-serif;">{{ formation.duration }}</span>
              </div>
              <div style="display:flex; align-items:center; justify-content:space-between; font-size:14px;">
                <span style="color:rgba(13,27,42,0.45);">Niveau</span>
                <span style="font-weight:700; color:#0D1B2A; font-family:'Syne',sans-serif;">{{ levelLabel }}</span>
              </div>
              <div v-if="formation.has_certification" style="display:flex; align-items:center; justify-content:space-between; font-size:14px;">
                <span style="color:rgba(13,27,42,0.45);">Certification</span>
                <span style="font-weight:700; color:#C9A84C; display:flex; align-items:center; gap:4px; font-family:'Syne',sans-serif;">
                  <PhCheckCircle style="width:14px; height:14px;" weight="fill" /> Incluse
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Bannière -->
      <div v-if="formation.banner_url" style="max-width:1400px; margin:40px auto 0; padding:0 3rem; position:relative; z-index:1;">
        <img :src="formation.banner_url" :alt="formation.title" style="width:100%; height:400px; object-fit:cover; border-radius:24px 24px 0 0; display:block;" />
      </div>
    </section>

    <!-- Corps détaillé -->
    <section style="background:#FAF8F3; padding:80px 0 100px;">
      <div style="max-width:1400px; margin:0 auto; padding:0 3rem;">
        <div style="display:grid; grid-template-columns:1fr 380px; gap:60px; align-items:start;">

          <!-- Gauche -->
          <div>

            <!-- Objectifs -->
            <div v-if="formation.objectives?.length" style="margin-bottom:56px;">
              <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding-bottom:16px; border-bottom:2px solid #C9A84C; width:fit-content;">
                <h2 style="font-family:'Syne',sans-serif; font-size:22px; font-weight:800; color:#0D1B2A; margin:0; letter-spacing:-0.02em;">Ce que vous apprendrez</h2>
              </div>
              <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div v-for="obj in formation.objectives" :key="obj" style="display:flex; align-items:flex-start; gap:12px; padding:16px; background:white; border-radius:14px; border:1.5px solid rgba(13,27,42,0.07);">
                  <PhCheckCircle style="width:18px; height:18px; color:#C9A84C; flex-shrink:0; margin-top:1px;" weight="fill" />
                  <span style="font-size:14px; color:#0D1B2A; line-height:1.5;">{{ obj }}</span>
                </div>
              </div>
            </div>

            <!-- Programme -->
            <div v-if="formation.program?.length" style="margin-bottom:56px;">
              <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding-bottom:16px; border-bottom:2px solid #C9A84C; width:fit-content;">
                <h2 style="font-family:'Syne',sans-serif; font-size:22px; font-weight:800; color:#0D1B2A; margin:0; letter-spacing:-0.02em;">Programme</h2>
              </div>
              <div style="display:flex; flex-direction:column; gap:10px;">
                <div v-for="(mod, i) in formation.program" :key="i" style="border:1.5px solid rgba(13,27,42,0.08); border-radius:16px; overflow:hidden; background:white;">
                  <div style="padding:16px 20px; display:flex; align-items:center; gap:14px; background:#FAF8F3;">
                    <span style="width:28px; height:28px; border-radius:8px; background:#0D1B2A; color:white; font-size:12px; font-weight:900; display:flex; align-items:center; justify-content:center; flex-shrink:0; font-family:'Syne',sans-serif;">{{ String(i+1).padStart(2,'0') }}</span>
                    <span style="font-size:15px; font-weight:700; color:#0D1B2A; font-family:'Syne',sans-serif;">{{ mod.title ?? mod }}</span>
                  </div>
                  <div v-if="mod.description" style="padding:14px 20px 16px;">
                    <p style="font-size:14px; color:rgba(13,27,42,0.55); line-height:1.65; margin:0;">{{ mod.description }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Prérequis -->
            <div v-if="formation.prerequisites?.length" style="margin-bottom:56px;">
              <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding-bottom:16px; border-bottom:2px solid #C9A84C; width:fit-content;">
                <h2 style="font-family:'Syne',sans-serif; font-size:22px; font-weight:800; color:#0D1B2A; margin:0; letter-spacing:-0.02em;">Prérequis</h2>
              </div>
              <ul style="list-style:none; display:flex; flex-direction:column; gap:10px; padding:0; margin:0;">
                <li v-for="pre in formation.prerequisites" :key="pre" style="display:flex; align-items:center; gap:12px; font-size:15px; color:rgba(13,27,42,0.7); padding:10px 16px; background:white; border-radius:12px; border:1px solid rgba(13,27,42,0.07);">
                  <div style="width:6px; height:6px; border-radius:50%; background:#C9A84C; flex-shrink:0;" />
                  {{ pre }}
                </li>
              </ul>
            </div>

            <!-- Contenu -->
            <div v-if="formation.content" style="margin-bottom:56px;">
              <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding-bottom:16px; border-bottom:2px solid #C9A84C; width:fit-content;">
                <h2 style="font-family:'Syne',sans-serif; font-size:22px; font-weight:800; color:#0D1B2A; margin:0; letter-spacing:-0.02em;">Description complète</h2>
              </div>
              <div class="prose-wg" v-html="formation.content" />
            </div>

            <!-- Sessions -->
            <div v-if="formation.sessions?.length" style="margin-bottom:56px;">
              <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding-bottom:16px; border-bottom:2px solid #C9A84C; width:fit-content;">
                <h2 style="font-family:'Syne',sans-serif; font-size:22px; font-weight:800; color:#0D1B2A; margin:0; letter-spacing:-0.02em;">Prochaines sessions</h2>
              </div>
              <div style="display:flex; flex-direction:column; gap:14px;">
                <div v-for="session in formation.sessions" :key="session.id" style="background:white; border-radius:20px; border:1.5px solid rgba(13,27,42,0.08); padding:22px; display:flex; align-items:center; gap:20px; flex-wrap:wrap; transition:all 0.25s;" class="session-row">
                  <div style="width:4px; height:52px; border-radius:2px; flex-shrink:0;" :style="`background:${session.modality_color}`" />
                  <div style="flex-shrink:0;">
                    <div style="font-family:'Syne',sans-serif; font-size:17px; font-weight:800; color:#0D1B2A; letter-spacing:-0.01em;">{{ session.formatted_start_date }}</div>
                    <div v-if="session.formatted_end_date" style="font-size:12px; color:rgba(13,27,42,0.4); margin-top:2px;">→ {{ session.formatted_end_date }}</div>
                  </div>
                  <div style="flex:1; min-width:0; display:flex; flex-direction:column; gap:6px;">
                    <div style="display:flex; gap:8px; flex-wrap:wrap;">
                      <span style="font-size:12px; font-weight:700; padding:3px 10px; border-radius:100px;" :style="`background:${session.modality_color}18; color:${session.modality_color};`">{{ session.modality_label }}</span>
                      <span style="font-size:12px; font-weight:700; padding:3px 10px; border-radius:100px;" :style="sessionStatusStyle(session.status)">{{ sessionStatusLabel(session.status) }}</span>
                    </div>
                    <div style="display:flex; gap:14px; flex-wrap:wrap;">
                      <span v-if="session.schedule" style="font-size:13px; color:rgba(13,27,42,0.5); display:flex; align-items:center; gap:5px;"><PhClock style="width:12px;height:12px;" /> {{ session.schedule }}</span>
                      <span v-if="session.location" style="font-size:13px; color:rgba(13,27,42,0.5); display:flex; align-items:center; gap:5px;"><PhMapPin style="width:12px;height:12px;" /> {{ session.location }}</span>
                    </div>
                  </div>
                  <div v-if="session.seats_total" style="text-align:center; flex-shrink:0;">
                    <div style="font-family:'Syne',sans-serif; font-size:18px; font-weight:800; color:#0D1B2A; line-height:1;" :style="session.is_full ? 'color:#EF4444;' : ''">
                      {{ session.seats_available }}<span style="font-size:12px; color:rgba(13,27,42,0.4); font-weight:600;">/{{ session.seats_total }}</span>
                    </div>
                    <div style="font-size:11px; color:rgba(13,27,42,0.35); margin-top:2px;">places</div>
                  </div>
                  <Link :href="route('contact')" class="btn-gold" style="font-size:12px; padding:10px 18px; flex-shrink:0;">
                    <PhEnvelope style="width:13px; height:13px;" /> S'inscrire
                  </Link>
                </div>
              </div>
            </div>
            <div v-else style="margin-bottom:40px; padding:24px; background:white; border-radius:16px; border:1.5px dashed rgba(13,27,42,0.1); text-align:center;">
              <p style="font-size:14px; color:rgba(13,27,42,0.4); margin:0; line-height:1.65;">
                Aucune session programmée pour le moment.
                <Link :href="route('contact')" style="color:#C9A84C; font-weight:700; text-decoration:none;">Contactez-nous</Link> pour les prochaines dates.
              </p>
            </div>

            <!-- Avis -->
            <div v-if="formation.reviews?.length">
              <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px; padding-bottom:16px; border-bottom:2px solid #C9A84C; width:fit-content;">
                <h2 style="font-family:'Syne',sans-serif; font-size:22px; font-weight:800; color:#0D1B2A; margin:0; letter-spacing:-0.02em;">Avis des apprenants</h2>
              </div>
              <div style="display:flex; flex-direction:column; gap:16px;">
                <div v-for="review in formation.reviews" :key="review.reviewer_name" style="padding:22px; background:white; border-radius:20px; border:1.5px solid rgba(13,27,42,0.07);">
                  <div style="display:flex; gap:2px; margin-bottom:10px;"><PhStar v-for="i in 5" :key="i" style="width:14px;height:14px;" :style="i <= review.rating ? 'color:#C9A84C;' : 'color:rgba(13,27,42,0.1);'" weight="fill" /></div>
                  <p style="font-size:15px; color:rgba(13,27,42,0.65); line-height:1.7; margin-bottom:14px; font-style:italic;">"{{ review.comment }}"</p>
                  <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
                    <div>
                      <span style="font-family:'Syne',sans-serif; font-size:14px; font-weight:700; color:#0D1B2A;">{{ review.reviewer_name }}</span>
                      <span v-if="review.reviewer_job" style="font-size:12px; color:rgba(13,27,42,0.4); margin-left:8px;">— {{ review.reviewer_job }}</span>
                    </div>
                    <span style="font-size:12px; color:rgba(13,27,42,0.3);">{{ review.created_at }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Droite : formations similaires -->
          <div style="position:sticky; top:100px;">
            <h3 style="font-family:'Syne',sans-serif; font-size:17px; font-weight:800; color:#0D1B2A; margin:0 0 18px; letter-spacing:-0.01em;">Formations similaires</h3>
            <div v-if="relatedFormations?.length" style="display:flex; flex-direction:column; gap:14px;">
              <Link v-for="f in relatedFormations" :key="f.id" :href="route('formations.show', f.slug)" style="display:flex; gap:12px; padding:14px; background:white; border:1.5px solid rgba(13,27,42,0.07); border-radius:16px; text-decoration:none; transition:all 0.25s;" class="related-card">
                <img :src="f.thumbnail_url" :alt="f.title" style="width:68px; height:52px; object-fit:cover; border-radius:10px; flex-shrink:0;" />
                <div style="min-width:0;">
                  <div style="font-family:'Syne',sans-serif; font-size:13px; font-weight:700; color:#0D1B2A; line-height:1.4; margin-bottom:4px; overflow:hidden; text-overflow:ellipsis; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;">{{ f.title }}</div>
                  <div v-if="f.current_price" style="font-size:13px; font-weight:800; color:#C9A84C; font-family:'Syne',sans-serif;">{{ f.current_price }}€</div>
                  <div v-else style="font-size:12px; color:rgba(13,27,42,0.4);">Sur demande</div>
                </div>
              </Link>
            </div>
            <div v-else style="padding:28px; background:white; border-radius:16px; border:1.5px dashed rgba(13,27,42,0.08); text-align:center;">
              <p style="font-size:13px; color:rgba(13,27,42,0.35); margin:0;">Aucune formation similaire</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA bas -->
    <section style="background:#0D1B2A; padding:100px 0; text-align:center; position:relative; overflow:hidden;">
      <div style="position:absolute; inset:0; background:radial-gradient(ellipse 60% 50% at 50% 50%, rgba(201,168,76,0.1) 0%, transparent 70%); pointer-events:none;" />
      <div style="max-width:700px; margin:0 auto; padding:0 3rem; position:relative; z-index:1;">
        <h2 style="font-family:'Syne',sans-serif; font-size:clamp(30px,4vw,48px); font-weight:800; color:white; letter-spacing:-0.03em; margin-bottom:18px;">Intéressé par cette formation ?</h2>
        <p style="font-size:16px; color:rgba(255,255,255,0.45); margin-bottom:36px; line-height:1.7;">Contactez-nous pour obtenir plus d'informations ou vous inscrire.</p>
        <Link :href="route('contact')" class="btn-gold">
          <PhEnvelope style="width:17px; height:17px;" /> Nous contacter
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
import { PhCaretRight, PhCertificate, PhChartBar, PhClock, PhStar, PhEnvelope, PhPhone, PhCheckCircle, PhFilePdf, PhMapPin } from '@phosphor-icons/vue'

const props = defineProps({ formation: Object, relatedFormations: Array })

const levelLabels = { debutant:'Débutant', intermediaire:'Intermédiaire', avance:'Avancé', tous:'Tous niveaux' }
const levelLabel  = computed(() => levelLabels[props.formation?.level] ?? props.formation?.level)

function downloadPdf() { window.open(route('formations.pdf', props.formation.slug), '_blank') }

function sessionStatusLabel(s) { return { ouvert:'Ouvert', bientot:'Bientôt', complet:'Complet', en_cours:'En cours' }[s] ?? s }
function sessionStatusStyle(s) {
  return { ouvert:'background:rgba(34,197,94,0.1);color:#16A34A;', bientot:'background:rgba(245,158,11,0.1);color:#D97706;', complet:'background:rgba(239,68,68,0.1);color:#DC2626;', en_cours:'background:rgba(59,130,246,0.1);color:#2563EB;' }[s] ?? 'background:rgba(13,27,42,0.07);color:rgba(13,27,42,0.5);'
}
</script>

<style scoped>
.bc-link:hover    { color:#C9A84C !important; }
.phone-btn:hover  { background:#FAF8F3 !important; border-color:rgba(13,27,42,0.2) !important; }
.pdf-btn:hover    { background:rgba(201,168,76,0.1) !important; border-color:rgba(201,168,76,0.3) !important; }
.related-card:hover { box-shadow:0 4px 20px rgba(13,27,42,0.08); transform:translateY(-2px); border-color:rgba(201,168,76,0.2) !important; }
.session-row:hover { box-shadow:0 4px 20px rgba(13,27,42,0.07); transform:translateX(4px); }
.prose-wg { font-size:15px; color:rgba(13,27,42,0.7); line-height:1.85; }
.prose-wg h2 { font-family:'Syne',sans-serif; font-size:22px; font-weight:800; color:#0D1B2A; margin:36px 0 12px; letter-spacing:-0.02em; }
.prose-wg h3 { font-family:'Syne',sans-serif; font-size:18px; font-weight:700; color:#0D1B2A; margin:28px 0 10px; }
.prose-wg p  { margin-bottom:16px; }
.prose-wg ul, .prose-wg ol { padding-left:22px; margin-bottom:16px; }
.prose-wg li { margin-bottom:6px; }
.prose-wg strong { color:#0D1B2A; font-weight:800; }
.prose-wg blockquote { border-left:3px solid #C9A84C; padding-left:20px; margin:28px 0; font-style:italic; color:rgba(13,27,42,0.55); }
</style>