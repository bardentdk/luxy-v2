<template>
  <AdminLayout>
    <Head title="Tableau de bord" />

    <div style="display:flex; flex-direction:column; gap:24px; max-width:1400px;">

      <!-- En-tête avec date -->
      <div style="display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px;">
        <div>
          <div style="display:flex; align-items:center; gap:10px; margin-bottom:6px;">
            <div style="width:8px; height:8px; border-radius:50%; background:#22C55E; box-shadow:0 0 8px rgba(34,197,94,0.6);" />
            <span style="font-size:12px; font-weight:600; color:#22C55E; letter-spacing:0.03em;">Système opérationnel</span>
          </div>
          <h1 style="font-size:24px; font-weight:900; color:#0D1B2A; letter-spacing:-0.025em; margin:0 0 4px;">
            Bonjour, {{ $page.props.auth?.user?.first_name }} 👋
          </h1>
          <p style="font-size:13px; color:rgba(13,27,42,0.45); margin:0;">
            {{ todayLabel }} — voici un résumé de l'activité de votre site
          </p>
        </div>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
          <Link :href="route('admin.formations.create')" style="display:inline-flex; align-items:center; gap:7px; height:36px; padding:0 16px; border-radius:9px; background:#0D1B2A; color:white; font-size:13px; font-weight:700; text-decoration:none; transition:all 0.2s;" class="action-btn-dark">
            <PhPlus style="width:14px; height:14px;" />
            Nouvelle formation
          </Link>
          <Link :href="route('admin.articles.create')" style="display:inline-flex; align-items:center; gap:7px; height:36px; padding:0 16px; border-radius:9px; background:white; border:1.5px solid rgba(13,27,42,0.12); color:rgba(13,27,42,0.7); font-size:13px; font-weight:700; text-decoration:none; transition:all 0.2s;" class="action-btn-light">
            <PhPencil style="width:14px; height:14px;" />
            Nouvel article
          </Link>
        </div>
      </div>

      <!-- Alertes si éléments en attente -->
      <div v-if="stats.unread_contacts > 0 || stats.pending_reviews > 0" style="display:flex; gap:12px; flex-wrap:wrap;">
        <Link
          v-if="stats.unread_contacts > 0"
          :href="route('admin.contacts.index')"
          style="display:flex; align-items:center; gap:10px; padding:12px 16px; background:linear-gradient(135deg,rgba(245,158,11,0.08),rgba(245,158,11,0.04)); border:1px solid rgba(245,158,11,0.2); border-radius:12px; text-decoration:none; transition:all 0.2s; flex:1; min-width:240px;"
          class="alert-card"
        >
          <div style="width:32px; height:32px; border-radius:8px; background:rgba(245,158,11,0.15); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <PhEnvelopeSimple style="width:16px; height:16px; color:#F59E0B;" weight="fill" />
          </div>
          <div>
            <span style="font-size:13px; font-weight:700; color:#0D1B2A; display:block; line-height:1.3;">
              {{ stats.unread_contacts }} message{{ stats.unread_contacts > 1 ? 's' : '' }} non lu{{ stats.unread_contacts > 1 ? 's' : '' }}
            </span>
            <span style="font-size:12px; color:rgba(13,27,42,0.5);">Cliquer pour consulter →</span>
          </div>
        </Link>

        <Link
          v-if="stats.pending_reviews > 0"
          :href="route('admin.reviews.index')"
          style="display:flex; align-items:center; gap:10px; padding:12px 16px; background:linear-gradient(135deg,rgba(139,92,246,0.08),rgba(139,92,246,0.04)); border:1px solid rgba(139,92,246,0.2); border-radius:12px; text-decoration:none; transition:all 0.2s; flex:1; min-width:240px;"
          class="alert-card"
        >
          <div style="width:32px; height:32px; border-radius:8px; background:rgba(139,92,246,0.15); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <PhStar style="width:16px; height:16px; color:#8B5CF6;" weight="fill" />
          </div>
          <div>
            <span style="font-size:13px; font-weight:700; color:#0D1B2A; display:block; line-height:1.3;">
              {{ stats.pending_reviews }} avis en attente de modération
            </span>
            <span style="font-size:12px; color:rgba(13,27,42,0.5);">Modérer maintenant →</span>
          </div>
        </Link>
      </div>

      <!-- KPI Cards — ligne 1 -->
      <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px;">
        <div
          v-for="kpi in kpiCards"
          :key="kpi.label"
          style="background:white; border-radius:16px; padding:20px; border:1px solid rgba(13,27,42,0.06); position:relative; overflow:hidden; transition:all 0.25s;"
          class="kpi-card"
        >
          <!-- Fond décoratif -->
          <div style="position:absolute; top:-20px; right:-20px; width:80px; height:80px; border-radius:50%; opacity:0.06;" :style="{ background: kpi.accent }" />

          <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:16px;">
            <div
              style="width:38px; height:38px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;"
              :style="{ background: kpi.bg }"
            >
              <component :is="kpi.icon" style="width:18px; height:18px;" :style="{ color: kpi.accent }" weight="fill" />
            </div>
            <span
              v-if="kpi.trend !== undefined"
              style="font-size:11px; font-weight:700; padding:3px 8px; border-radius:100px;"
              :style="kpi.trend >= 0
                ? 'background:rgba(34,197,94,0.1); color:#16A34A;'
                : 'background:rgba(239,68,68,0.1); color:#DC2626;'"
            >
              {{ kpi.trend >= 0 ? '↑' : '↓' }} {{ Math.abs(kpi.trend) }}%
            </span>
          </div>

          <div style="font-size:30px; font-weight:900; color:#0D1B2A; line-height:1; letter-spacing:-0.025em; margin-bottom:4px;">
            {{ kpi.value?.toLocaleString() ?? 0 }}
          </div>
          <div style="font-size:12px; font-weight:600; color:rgba(13,27,42,0.45);">{{ kpi.label }}</div>
          <div v-if="kpi.sub" style="font-size:11px; color:rgba(13,27,42,0.3); margin-top:2px;">{{ kpi.sub }}</div>
        </div>
      </div>

      <!-- Graphique + Pages populaires -->
      <div style="display:grid; grid-template-columns:1fr 320px; gap:16px;">

        <!-- Graphique -->
        <div style="background:white; border-radius:16px; padding:24px; border:1px solid rgba(13,27,42,0.06);">
          <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <div>
              <h2 style="font-size:15px; font-weight:800; color:#0D1B2A; margin:0 0 2px; letter-spacing:-0.01em;">
                Trafic — 30 derniers jours
              </h2>
              <p style="font-size:12px; color:rgba(13,27,42,0.4); margin:0;">Nombre de pages vues par jour</p>
            </div>
            <div style="display:flex; align-items:center; gap:6px; padding:6px 10px; background:#F4F6FA; border-radius:8px;">
              <div style="width:8px; height:8px; border-radius:50%; background:#C9A84C;" />
              <span style="font-size:11px; font-weight:600; color:rgba(13,27,42,0.5);">Pages vues</span>
            </div>
          </div>

          <!-- Total rapide -->
          <div style="display:flex; align-items:baseline; gap:8px; margin-bottom:20px; padding-bottom:16px; border-bottom:1px solid rgba(13,27,42,0.05);">
            <span style="font-size:28px; font-weight:900; color:#0D1B2A; letter-spacing:-0.025em;">
              {{ totalViewsMonth?.toLocaleString() ?? 0 }}
            </span>
            <span style="font-size:12px; color:rgba(13,27,42,0.4); font-weight:600;">vues ce mois</span>
          </div>

          <ViewsChart :data="viewsChart" />
        </div>

        <!-- Pages populaires -->
        <div style="background:white; border-radius:16px; padding:24px; border:1px solid rgba(13,27,42,0.06); display:flex; flex-direction:column;">
          <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px; padding-bottom:16px; border-bottom:1px solid rgba(13,27,42,0.05);">
            <PhFire style="width:16px; height:16px; color:#F59E0B;" weight="fill" />
            <h2 style="font-size:14px; font-weight:800; color:#0D1B2A; margin:0; letter-spacing:-0.01em;">Pages populaires</h2>
          </div>

          <div style="flex:1; display:flex; flex-direction:column; gap:6px; overflow:hidden;">
            <div
              v-for="(p, i) in (topPages ?? []).slice(0, 8)"
              :key="i"
              style="display:flex; align-items:center; gap:10px; padding:8px 10px; border-radius:9px; transition:background 0.15s; cursor:default;"
              class="page-row"
            >
              <span style="width:18px; height:18px; border-radius:5px; background:#F1F3F7; display:flex; align-items:center; justify-content:center; font-size:10px; font-weight:800; color:rgba(13,27,42,0.35); flex-shrink:0;">
                {{ i + 1 }}
              </span>
              <span style="flex:1; font-size:12px; font-weight:600; color:#0D1B2A; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                {{ p.route_name ?? p.url }}
              </span>
              <span style="font-size:11px; font-weight:800; color:rgba(13,27,42,0.5); flex-shrink:0; background:#F1F3F7; padding:2px 7px; border-radius:5px;">
                {{ p.views?.toLocaleString() }}
              </span>
            </div>

            <div v-if="!topPages?.length" style="flex:1; display:flex; align-items:center; justify-content:center;">
              <p style="font-size:12px; color:rgba(13,27,42,0.3); text-align:center; margin:0;">Aucune donnée<br>disponible</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Ligne formations + activité rapide -->
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

        <!-- Formations populaires -->
        <div style="background:white; border-radius:16px; padding:24px; border:1px solid rgba(13,27,42,0.06);">
          <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; padding-bottom:16px; border-bottom:1px solid rgba(13,27,42,0.05);">
            <div style="display:flex; align-items:center; gap:8px;">
              <PhGraduationCap style="width:16px; height:16px; color:#C9A84C;" weight="fill" />
              <h2 style="font-size:14px; font-weight:800; color:#0D1B2A; margin:0; letter-spacing:-0.01em;">Formations populaires</h2>
            </div>
            <Link :href="route('admin.formations.index')" style="font-size:12px; font-weight:700; color:#C9A84C; text-decoration:none; padding:5px 10px; border-radius:7px; border:1px solid rgba(201,168,76,0.2); transition:all 0.2s;" class="see-all">
              Voir tout
            </Link>
          </div>

          <div v-if="topFormations?.length" style="display:flex; flex-direction:column; gap:10px;">
            <div
              v-for="(f, i) in topFormations"
              :key="f.id"
              style="display:flex; align-items:center; gap:12px; padding:10px; border-radius:10px; background:#F8F9FB; transition:all 0.2s; cursor:default;"
              class="formation-row"
            >
              <span style="width:20px; text-align:center; font-size:12px; font-weight:800; color:rgba(13,27,42,0.25); flex-shrink:0;">
                {{ i + 1 }}
              </span>
              <img
                :src="f.thumbnail_url"
                :alt="f.title"
                style="width:44px; height:34px; object-fit:cover; border-radius:7px; flex-shrink:0;"
              />
              <div style="flex:1; min-width:0;">
                <div style="font-size:13px; font-weight:700; color:#0D1B2A; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; line-height:1.3;">
                  {{ f.title }}
                </div>
                <div style="font-size:11px; color:rgba(13,27,42,0.4); display:flex; align-items:center; gap:4px; margin-top:2px;">
                  <PhEye style="width:11px; height:11px;" />
                  {{ f.view_count?.toLocaleString() }} vues
                </div>
              </div>
            </div>
          </div>
          <div v-else style="padding:32px 0; text-align:center; font-size:13px; color:rgba(13,27,42,0.3);">
            Aucune formation disponible
          </div>
        </div>

        <!-- Résumé rapide -->
        <div style="display:flex; flex-direction:column; gap:16px;">

          <!-- Contacts récents -->
          <div style="background:white; border-radius:16px; padding:24px; border:1px solid rgba(13,27,42,0.06); flex:1;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; padding-bottom:16px; border-bottom:1px solid rgba(13,27,42,0.05);">
              <div style="display:flex; align-items:center; gap:8px;">
                <PhEnvelopeSimple style="width:16px; height:16px; color:#F59E0B;" weight="fill" />
                <h2 style="font-size:14px; font-weight:800; color:#0D1B2A; margin:0;">Messages</h2>
              </div>
              <Link :href="route('admin.contacts.index')" style="font-size:12px; font-weight:700; color:#C9A84C; text-decoration:none; padding:5px 10px; border-radius:7px; border:1px solid rgba(201,168,76,0.2); transition:all 0.2s;" class="see-all">
                Voir tout
              </Link>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
              <div style="padding:14px; background:#F8F9FB; border-radius:10px; text-align:center;">
                <div style="font-size:26px; font-weight:900; color:#0D1B2A; letter-spacing:-0.02em; line-height:1;">
                  {{ stats.total_contacts?.toLocaleString() ?? 0 }}
                </div>
                <div style="font-size:11px; font-weight:600; color:rgba(13,27,42,0.4); margin-top:4px;">Total reçus</div>
              </div>
              <div style="padding:14px; border-radius:10px; text-align:center;" :style="stats.unread_contacts > 0 ? 'background:rgba(245,158,11,0.08); border:1px solid rgba(245,158,11,0.15);' : 'background:#F8F9FB;'">
                <div style="font-size:26px; font-weight:900; letter-spacing:-0.02em; line-height:1;" :style="stats.unread_contacts > 0 ? 'color:#D97706;' : 'color:#0D1B2A;'">
                  {{ stats.unread_contacts?.toLocaleString() ?? 0 }}
                </div>
                <div style="font-size:11px; font-weight:600; margin-top:4px;" :style="stats.unread_contacts > 0 ? 'color:#D97706;' : 'color:rgba(13,27,42,0.4);'">
                  Non lus
                </div>
              </div>
            </div>
          </div>

          <!-- Avis -->
          <div style="background:white; border-radius:16px; padding:24px; border:1px solid rgba(13,27,42,0.06); flex:1;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; padding-bottom:16px; border-bottom:1px solid rgba(13,27,42,0.05);">
              <div style="display:flex; align-items:center; gap:8px;">
                <PhStar style="width:16px; height:16px; color:#C9A84C;" weight="fill" />
                <h2 style="font-size:14px; font-weight:800; color:#0D1B2A; margin:0;">Avis clients</h2>
              </div>
              <Link :href="route('admin.reviews.index')" style="font-size:12px; font-weight:700; color:#C9A84C; text-decoration:none; padding:5px 10px; border-radius:7px; border:1px solid rgba(201,168,76,0.2); transition:all 0.2s;" class="see-all">
                Modérer
              </Link>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
              <div style="padding:14px; background:#F8F9FB; border-radius:10px; text-align:center;">
                <div style="font-size:26px; font-weight:900; color:#0D1B2A; letter-spacing:-0.02em; line-height:1;">
                  {{ stats.approved_reviews?.toLocaleString() ?? 0 }}
                </div>
                <div style="font-size:11px; font-weight:600; color:rgba(13,27,42,0.4); margin-top:4px;">Approuvés</div>
              </div>
              <div style="padding:14px; border-radius:10px; text-align:center;" :style="stats.pending_reviews > 0 ? 'background:rgba(139,92,246,0.08); border:1px solid rgba(139,92,246,0.15);' : 'background:#F8F9FB;'">
                <div style="font-size:26px; font-weight:900; letter-spacing:-0.02em; line-height:1;" :style="stats.pending_reviews > 0 ? 'color:#7C3AED;' : 'color:#0D1B2A;'">
                  {{ stats.pending_reviews?.toLocaleString() ?? 0 }}
                </div>
                <div style="font-size:11px; font-weight:600; margin-top:4px;" :style="stats.pending_reviews > 0 ? 'color:#7C3AED;' : 'color:rgba(13,27,42,0.4);'">
                  En attente
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { computed } from 'vue'
import { Head, Link, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import ViewsChart from '@/Components/Admin/ViewsChart.vue'
import {
  PhUsers, PhGraduationCap, PhNewspaper, PhEye,
  PhEnvelopeSimple, PhStar, PhFire, PhPlus, PhPencil,
} from '@phosphor-icons/vue'

const props = defineProps({
  stats:         Object,
  topPages:      Array,
  viewsChart:    Object,
  topFormations: Array,
})

const page = usePage()

const todayLabel = computed(() => {
  return new Date().toLocaleDateString('fr-FR', {
    weekday: 'long', day: 'numeric', month: 'long', year: 'numeric',
  })
})

const totalViewsMonth = computed(() => {
  if (!props.viewsChart) return 0
  return Object.values(props.viewsChart).reduce((a, b) => a + b, 0)
})

const kpiCards = computed(() => [
  {
    label:  'Utilisateurs',
    value:  props.stats?.total_users,
    sub:    `${props.stats?.active_users ?? 0} actifs`,
    icon:   PhUsers,
    accent: '#3B82F6',
    bg:     'rgba(59,130,246,0.1)',
    trend:  undefined,
  },
  {
    label:  'Formations publiées',
    value:  props.stats?.published_formations,
    sub:    `${props.stats?.total_formations ?? 0} au total`,
    icon:   PhGraduationCap,
    accent: '#C9A84C',
    bg:     'rgba(201,168,76,0.12)',
    trend:  undefined,
  },
  {
    label:  'Articles publiés',
    value:  props.stats?.published_articles,
    sub:    `${props.stats?.total_articles ?? 0} au total`,
    icon:   PhNewspaper,
    accent: '#8B5CF6',
    bg:     'rgba(139,92,246,0.1)',
    trend:  undefined,
  },
  {
    label:  "Vues aujourd'hui",
    value:  props.stats?.views_today,
    sub:    `${props.stats?.views_this_month?.toLocaleString() ?? 0} ce mois`,
    icon:   PhEye,
    accent: '#22C55E',
    bg:     'rgba(34,197,94,0.1)',
    trend:  undefined,
  },
])
</script>

<style scoped>
.kpi-card:hover        { box-shadow:0 4px 20px rgba(13,27,42,0.08); transform:translateY(-1px); }
.page-row:hover        { background:#F1F3F7; }
.formation-row:hover   { background:#EEF0F4 !important; }
.alert-card:hover      { transform:translateY(-1px); box-shadow:0 4px 16px rgba(13,27,42,0.08); }
.action-btn-dark:hover { background:#1A2D42 !important; transform:translateY(-1px); }
.action-btn-light:hover{ background:#F4F6FA !important; border-color:rgba(13,27,42,0.2) !important; }
.see-all:hover         { background:rgba(201,168,76,0.08); }
</style>