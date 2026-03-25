<template>
  <PublicLayout>
    <Head title="Nos formations" />

    <!-- Hero -->
    <section style="position:relative; background:white; padding:140px 0 80px; overflow:hidden;">
      <div style="position:absolute; inset:0; background-image:radial-gradient(rgba(13,27,42,0.05) 1px, transparent 1px); background-size:44px 44px; pointer-events:none; -webkit-mask-image:radial-gradient(ellipse 80% 80% at 50% 50%, black 40%, transparent 100%); mask-image:radial-gradient(ellipse 80% 80% at 50% 50%, black 40%, transparent 100%);" />
      <div style="position:absolute; top:-200px; right:-200px; width:700px; height:700px; border-radius:50%; background:radial-gradient(circle, rgba(201,168,76,0.1) 0%, transparent 65%); pointer-events:none; animation:mesh-1 14s ease-in-out infinite;" />
      <div style="position:absolute; left:0; top:20%; bottom:20%; width:3px; background:linear-gradient(to bottom, transparent, #C9A84C 40%, #E2C97E 60%, transparent); border-radius:2px;" />

      <div style="max-width:1400px; margin:0 auto; padding:0 3rem; position:relative; z-index:1;">
        <div data-reveal style="display:inline-flex; align-items:center; gap:8px; background:rgba(201,168,76,0.08); border:1px solid rgba(201,168,76,0.22); border-radius:100px; padding:6px 14px; margin-bottom:24px;">
          <PhGraduationCap style="width:13px; height:13px; color:#C9A84C;" />
          <span style="font-size:11px; font-weight:700; color:#A07828; letter-spacing:0.08em; text-transform:uppercase;">Catalogue de formations</span>
        </div>
        <h1 data-reveal style="font-family:'Syne',sans-serif; font-size:clamp(44px,6vw,80px); font-weight:800; color:#0D1B2A; letter-spacing:-0.04em; line-height:1; margin:0 0 20px;">
          Nos formations
        </h1>
        <p data-reveal style="--delay:0.1s; font-size:18px; color:rgba(13,27,42,0.5); max-width:520px; line-height:1.75; margin:0;">
          Choisissez votre domaine et découvrez les programmes conçus pour le marché réunionnais.
        </p>
      </div>
    </section>

    <!-- Contenu -->
    <section style="background:#FAF8F3; min-height:60vh; padding:60px 0 100px;">
      <div style="max-width:1400px; margin:0 auto; padding:0 3rem;">

        <Transition name="view-switch" mode="out-in">

          <!-- ── BENTO GRID ── -->
          <div v-if="!activeCategory" key="bento">
            <div style="margin-bottom:44px;">
              <h2 data-reveal style="font-family:'Syne',sans-serif; font-size:22px; font-weight:800; color:#0D1B2A; letter-spacing:-0.02em; margin:0 0 6px;">Choisissez votre domaine</h2>
              <p data-reveal style="font-size:14px; color:rgba(13,27,42,0.45); margin:0;">
                {{ totalFormations }} formation{{ totalFormations > 1 ? 's' : '' }} réparties dans {{ categories.length }} domaines
              </p>
            </div>

            <div class="bento-grid">
              <div
                v-for="(cat, i) in categories"
                :key="cat.id"
                class="bento-card"
                :class="`bento-${getBentoSize(i)}`"
                @click="selectCategory(cat)"
                :style="getBentoStyle(i)"
              >
                <div class="bento-noise" />
                <!-- Count badge -->
                <div style="position:absolute; top:18px; right:18px; background:rgba(255,255,255,0.18); backdrop-filter:blur(8px); border:1px solid rgba(255,255,255,0.25); border-radius:100px; padding:4px 12px; font-size:12px; font-weight:700; color:white; z-index:2; white-space:nowrap;">
                  {{ cat.formations_count }} formation{{ cat.formations_count > 1 ? 's' : '' }}
                </div>

                <div style="position:relative; z-index:2; height:100%; display:flex; flex-direction:column; justify-content:flex-end; padding:28px;">
                  <!-- Icône -->
                  <div style="width:52px; height:52px; border-radius:14px; background:rgba(255,255,255,0.18); backdrop-filter:blur(8px); border:1px solid rgba(255,255,255,0.25); display:flex; align-items:center; justify-content:center; margin-bottom:18px; flex-shrink:0;">
                    <component :is="getIcon(cat.icon)" style="width:26px; height:26px; color:white;" weight="fill" />
                  </div>
                  <h3 style="font-family:'Syne',sans-serif; font-size:clamp(18px,2.2vw,24px); font-weight:800; color:white; margin:0 0 6px; letter-spacing:-0.02em; line-height:1.2;">{{ cat.name }}</h3>
                  <p v-if="cat.description" style="font-size:13px; color:rgba(255,255,255,0.65); margin:0 0 18px; line-height:1.5; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">{{ cat.description }}</p>
                  <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(255,255,255,0.15); backdrop-filter:blur(8px); border:1px solid rgba(255,255,255,0.25); border-radius:100px; padding:8px 16px; width:fit-content; color:white; font-size:13px; font-weight:700; font-family:'Syne',sans-serif; transition:all 0.3s;" class="bento-cta">
                    Voir les formations <PhArrowRight style="width:14px; height:14px;" />
                  </div>
                </div>
              </div>

              <!-- Card tout voir -->
              <div class="bento-card bento-all" @click="selectAll" style="background:white; border:2px dashed rgba(13,27,42,0.12);">
                <div style="height:100%; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:28px; text-align:center; gap:14px; position:relative; z-index:2;">
                  <div style="width:52px; height:52px; border-radius:14px; background:#FAF8F3; display:flex; align-items:center; justify-content:center;">
                    <PhSquaresFour style="width:26px; height:26px; color:rgba(13,27,42,0.35);" weight="fill" />
                  </div>
                  <div>
                    <div style="font-family:'Syne',sans-serif; font-size:16px; font-weight:800; color:#0D1B2A; margin-bottom:4px;">Toutes les formations</div>
                    <div style="font-size:13px; color:rgba(13,27,42,0.4);">Voir tout le catalogue</div>
                  </div>
                  <div style="display:inline-flex; align-items:center; gap:6px; font-size:13px; font-weight:700; color:rgba(13,27,42,0.55); border:1.5px solid rgba(13,27,42,0.12); padding:7px 16px; border-radius:100px; transition:all 0.2s;" class="all-cta">
                    Explorer <PhArrowRight style="width:13px; height:13px;" />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- ── FORMATIONS D'UNE CATÉGORIE ── -->
          <div v-else key="list">

            <!-- Retour + titre -->
            <div style="display:flex; align-items:center; gap:16px; margin-bottom:40px; flex-wrap:wrap;">
              <button
                @click="activeCategory = null; formationsList = null"
                style="display:inline-flex; align-items:center; gap:8px; padding:10px 18px; border-radius:100px; border:1.5px solid rgba(13,27,42,0.12); background:white; color:rgba(13,27,42,0.65); font-size:13px; font-weight:700; cursor:none; font-family:'Syne',sans-serif; transition:all 0.2s;"
                class="back-pill"
              >
                <PhArrowLeft style="width:14px; height:14px;" /> Tous les domaines
              </button>

              <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:36px; height:36px; border-radius:10px; background:linear-gradient(135deg,#C9A84C,#E2C97E); display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 4px 12px rgba(201,168,76,0.3);">
                  <component :is="getIcon(activeCategory.icon)" style="width:18px; height:18px; color:#0D1B2A;" weight="fill" />
                </div>
                <div>
                  <span style="font-family:'Syne',sans-serif; font-size:20px; font-weight:800; color:#0D1B2A; letter-spacing:-0.02em;">{{ activeCategory.name }}</span>
                  <span style="font-size:13px; color:rgba(13,27,42,0.4); margin-left:10px;">{{ formationsList?.total ?? 0 }} formation{{ (formationsList?.total ?? 0) > 1 ? 's' : '' }}</span>
                </div>
              </div>
            </div>

            <!-- Filtres -->
            <div style="background:white; border-radius:16px; padding:16px 20px; display:flex; align-items:center; gap:12px; box-shadow:0 1px 8px rgba(13,27,42,0.05); border:1px solid rgba(13,27,42,0.07); margin-bottom:32px; flex-wrap:wrap;">
              <div style="position:relative; flex:1; min-width:200px;">
                <PhMagnifyingGlass style="width:15px; height:15px; color:rgba(13,27,42,0.3); position:absolute; left:12px; top:50%; transform:translateY(-50%);" />
                <input v-model="searchQ" type="text" placeholder="Rechercher une formation..." @input="applyFilters" style="width:100%; padding:9px 12px 9px 36px; border:1.5px solid rgba(13,27,42,0.1); border-radius:10px; font-size:14px; color:#0D1B2A; outline:none; font-family:inherit; background:#FAF8F3; box-sizing:border-box; transition:border-color 0.2s;" class="search-input" />
              </div>
              <div style="display:flex; gap:8px; flex-wrap:wrap;">
                <button v-for="lvl in levels" :key="lvl.value" @click="setLevel(lvl.value)" style="padding:8px 14px; border-radius:100px; font-size:12px; font-weight:700; cursor:none; transition:all 0.2s; white-space:nowrap; font-family:'Syne',sans-serif; border:1.5px solid;" :style="levelQ === lvl.value ? 'background:#0D1B2A; color:white; border-color:#0D1B2A;' : 'background:white; color:rgba(13,27,42,0.55); border-color:rgba(13,27,42,0.12);'">
                  {{ lvl.label }}
                </button>
              </div>
            </div>

            <!-- Grille -->
            <div v-if="formationsList?.data?.length" style="display:grid; grid-template-columns:repeat(3,1fr); gap:24px;">
              <FormationCardWG v-for="formation in formationsList.data" :key="formation.id" :formation="formation" />
            </div>

            <!-- Vide -->
            <div v-else-if="formationsList" style="text-align:center; padding:80px; background:white; border-radius:20px; border:1.5px dashed rgba(13,27,42,0.1);">
              <PhGraduationCap style="width:40px; height:40px; color:rgba(201,168,76,0.4); margin:0 auto 16px; display:block;" />
              <h3 style="font-family:'Syne',sans-serif; font-size:18px; font-weight:800; color:#0D1B2A; margin-bottom:8px;">Aucune formation trouvée</h3>
              <p style="font-size:14px; color:rgba(13,27,42,0.4);">Essayez de modifier vos critères.</p>
            </div>

            <!-- Skeleton -->
            <div v-else style="display:grid; grid-template-columns:repeat(3,1fr); gap:24px;">
              <div v-for="i in 6" :key="i" style="background:white; border-radius:20px; overflow:hidden; border:1.5px solid rgba(13,27,42,0.06);">
                <div style="height:200px; background:linear-gradient(90deg,#EDE9DF 25%,#E4DFD3 50%,#EDE9DF 75%); background-size:200% 100%; animation:shimmer 1.5s ease-in-out infinite;" />
                <div style="padding:20px; display:flex; flex-direction:column; gap:8px;">
                  <div style="height:10px; background:#EDE9DF; border-radius:5px; width:35%;" />
                  <div style="height:18px; background:#EDE9DF; border-radius:5px;" />
                  <div style="height:14px; background:#EDE9DF; border-radius:5px; width:65%;" />
                </div>
              </div>
            </div>

            <!-- Pagination -->
            <div v-if="formationsList?.last_page > 1" style="display:flex; justify-content:center; gap:8px; margin-top:52px;">
              <button v-for="page in formationsList.last_page" :key="page" @click="goToPage(page)" style="padding:8px 14px; border-radius:100px; font-size:13px; font-weight:700; cursor:none; transition:all 0.2s; font-family:'Syne',sans-serif; border:1.5px solid;" :style="page === formationsList.current_page ? 'background:#0D1B2A; color:white; border-color:#0D1B2A;' : 'background:white; color:rgba(13,27,42,0.55); border-color:rgba(13,27,42,0.12);'">
                {{ page }}
              </button>
            </div>
          </div>
        </Transition>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import PublicLayout    from '@/Layouts/PublicLayout.vue'
import FormationCard from '@/Components/Public/FormationCard.vue'
import {
  PhGraduationCap, PhArrowRight, PhArrowLeft,
  PhMagnifyingGlass, PhSquaresFour,
  PhBriefcase, PhBooks, PhMonitor, PhUsers,
  PhTranslate, PhCertificate, PhChalkboardTeacher,
  PhCode, PhTrendUp, PhGlobe,
} from '@phosphor-icons/vue'

const props = defineProps({
  categories:       Array,
  formations:       Object,
  selectedCategory: Object,
  filters:          Object,
})

const activeCategory  = ref(props.selectedCategory ?? null)
const formationsList  = ref(props.formations ?? null)
const searchQ         = ref(props.filters?.search ?? '')
const levelQ          = ref(props.filters?.level  ?? '')

const totalFormations = computed(() => props.categories.reduce((s, c) => s + (c.formations_count ?? 0), 0))
const levels = [
  { value:'',             label:'Tous' },
  { value:'debutant',     label:'Débutant' },
  { value:'intermediaire',label:'Intermédiaire' },
  { value:'avance',       label:'Avancé' },
]

const iconMap = { PhBriefcase, PhBooks, PhMonitor, PhUsers, PhTranslate, PhCertificate, PhChalkboardTeacher, PhCode, PhTrendUp, PhGlobe, PhGraduationCap }
function getIcon(name) { return iconMap[name] ?? PhGraduationCap }

const bentoStyles = [
  'background:linear-gradient(135deg,#0D1B2A,#1A2D42)',
  'background:linear-gradient(135deg,#C9A84C,#A07828)',
  'background:linear-gradient(135deg,#1A3A5C,#0D2440)',
  'background:linear-gradient(135deg,#2D4A3E,#1A3028)',
  'background:linear-gradient(135deg,#3D2B1F,#5C3D2E)',
  'background:linear-gradient(135deg,#2B2040,#1A1228)',
]
function getBentoStyle(i)  { return bentoStyles[i % bentoStyles.length] }
function getBentoSize(i)   { return i === 0 ? 'large' : i === 1 ? 'wide' : 'normal' }

function selectCategory(cat) {
  activeCategory.value = cat
  formationsList.value = null
  searchQ.value = ''; levelQ.value = ''
  router.get(route('formations.index'), { categorie: cat.slug }, {
    preserveState: true, preserveScroll: false, only: ['formations', 'selectedCategory'],
    onSuccess: p => { formationsList.value = p.props.formations },
  })
}

function selectAll() {
  activeCategory.value = { name: 'Toutes les formations', icon: 'PhSquaresFour', slug: null }
  formationsList.value = null
  router.get(route('formations.index'), {}, {
    preserveState: true, only: ['formations'],
    onSuccess: p => { formationsList.value = p.props.formations },
  })
}

function setLevel(val) { levelQ.value = val; applyFilters() }

function applyFilters() {
  router.get(route('formations.index'), {
    categorie: activeCategory.value?.slug ?? undefined,
    search:    searchQ.value || undefined,
    level:     levelQ.value  || undefined,
  }, { preserveState:true, replace:true, only:['formations'], onSuccess: p => { formationsList.value = p.props.formations } })
}

function goToPage(page) {
  router.get(route('formations.index'), {
    categorie: activeCategory.value?.slug ?? undefined,
    search:    searchQ.value || undefined,
    level:     levelQ.value  || undefined, page,
  }, { preserveState:true, only:['formations'], onSuccess: p => { formationsList.value = p.props.formations } })
}

watch(() => props.formations,       v => { if (v) formationsList.value = v })
watch(() => props.selectedCategory, v => { if (v) activeCategory.value = v })
</script>

<style scoped>
@keyframes mesh-1  { 0%,100%{transform:translate(0,0) scale(1)} 50%{transform:translate(60px,-40px) scale(1.1)} }
@keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }

.bento-grid { display:grid; grid-template-columns:repeat(3,1fr); grid-auto-rows:210px; gap:16px; }
.bento-card { border-radius:22px; position:relative; overflow:hidden; cursor:none; transition:all 0.45s cubic-bezier(0.16,1,0.3,1); border:1px solid rgba(255,255,255,0.1); }
.bento-card:hover { transform:translateY(-5px) scale(1.01); box-shadow:0 20px 60px rgba(13,27,42,0.2); }
.bento-card:hover .bento-cta { background:rgba(255,255,255,0.25) !important; }
.bento-noise { position:absolute; inset:0; background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E"); z-index:1; pointer-events:none; }
.bento-large  { grid-column:span 2; grid-row:span 2; }
.bento-wide   { grid-column:span 1; grid-row:span 2; }
.bento-normal { grid-column:span 1; grid-row:span 1; }
.bento-all    { grid-column:span 1; grid-row:span 1; }
.bento-all:hover { border-color:rgba(13,27,42,0.2) !important; }
.bento-all:hover .all-cta { background:#0D1B2A !important; color:white !important; border-color:#0D1B2A !important; }

.view-switch-enter-active { transition:all 0.45s cubic-bezier(0.16,1,0.3,1); }
.view-switch-leave-active { transition:all 0.25s ease; }
.view-switch-enter-from   { opacity:0; transform:translateY(20px); }
.view-switch-leave-to     { opacity:0; transform:translateY(-10px); }

.back-pill:hover  { background:#FAF8F3 !important; color:#0D1B2A !important; }
.search-input:focus { border-color:rgba(201,168,76,0.4) !important; background:white !important; }

@media (max-width:1024px) {
  .bento-grid  { grid-template-columns:repeat(2,1fr); }
  .bento-large { grid-column:span 2; grid-row:span 1; }
  .bento-wide  { grid-column:span 1; grid-row:span 1; }
}
@media (max-width:640px) {
  .bento-grid  { grid-template-columns:1fr; grid-auto-rows:180px; }
  .bento-large, .bento-wide { grid-column:span 1; grid-row:span 1; }
}
</style>