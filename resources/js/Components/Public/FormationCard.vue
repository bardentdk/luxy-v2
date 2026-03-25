<template>
  <article
    style="background:white; border-radius:24px; overflow:hidden; border:1.5px solid rgba(13,27,42,0.07); display:flex; flex-direction:column; transition:all 0.4s cubic-bezier(0.16,1,0.3,1); position:relative;"
    class="formation-card"
  >
    <!-- Thumbnail -->
    <div style="position:relative; overflow:hidden; aspect-ratio:16/10; flex-shrink:0;">
      <img
        :src="formation.thumbnail_url"
        :alt="formation.title"
        style="width:100%; height:100%; object-fit:cover; transition:transform 0.7s cubic-bezier(0.16,1,0.3,1); display:block;"
        class="card-img"
        loading="lazy"
      />

      <!-- Overlay dégradé bas -->
      <div style="position:absolute; inset:0; background:linear-gradient(to top, rgba(13,27,42,0.5) 0%, transparent 50%); pointer-events:none;" />

      <!-- Badge catégorie -->
      <div v-if="formation.category" style="position:absolute; top:12px; left:12px;">
        <span style="display:inline-flex; align-items:center; background:rgba(255,255,255,0.92); backdrop-filter:blur(8px); color:#0D1B2A; font-size:11px; font-weight:800; padding:5px 12px; border-radius:100px; letter-spacing:0.01em; white-space:nowrap;">
          {{ formation.category.name }}
        </span>
      </div>

      <!-- Badge certification -->
      <div v-if="formation.has_certification" style="position:absolute; top:12px; right:12px;">
        <span style="display:inline-flex; align-items:center; gap:4px; background:#C9A84C; color:#0D1B2A; font-size:11px; font-weight:800; padding:5px 10px; border-radius:100px; white-space:nowrap;">
          <PhCertificate style="width:12px; height:12px;" weight="fill" />
          Certifiante
        </span>
      </div>

      <!-- Niveau + Durée sur le bas de l'image -->
      <div style="position:absolute; bottom:12px; left:12px; display:flex; align-items:center; gap:10px;">
        <span style="display:inline-flex; align-items:center; gap:4px; background:rgba(13,27,42,0.7); backdrop-filter:blur(4px); color:rgba(255,255,255,0.85); font-size:11px; font-weight:600; padding:4px 9px; border-radius:6px; white-space:nowrap;">
          <PhChartBar style="width:11px; height:11px;" />
          {{ levelLabel }}
        </span>
        <span v-if="formation.duration" style="display:inline-flex; align-items:center; gap:4px; background:rgba(13,27,42,0.7); backdrop-filter:blur(4px); color:rgba(255,255,255,0.85); font-size:11px; font-weight:600; padding:4px 9px; border-radius:6px; white-space:nowrap;">
          <PhClock style="width:11px; height:11px;" />
          {{ formation.duration }}
        </span>
      </div>
    </div>

    <!-- Contenu -->
    <div style="flex:1; display:flex; flex-direction:column; padding:20px 22px 22px;">

      <!-- Titre -->
      <h3 style="font-size:16px; font-weight:800; color:#0D1B2A; line-height:1.3; margin:0 0 8px; letter-spacing:-0.01em; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
        {{ formation.title }}
      </h3>

      <!-- Description -->
      <p v-if="formation.short_description" style="font-size:13px; color:rgba(13,27,42,0.55); line-height:1.6; margin:0 0 14px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; flex:1;">
        {{ formation.short_description }}
      </p>
      <div v-else style="flex:1;" />

      <!-- Rating -->
      <div v-if="formation.average_rating > 0" style="display:flex; align-items:center; gap:6px; margin-bottom:16px;">
        <div style="display:flex; gap:2px;">
          <PhStar
            v-for="i in 5"
            :key="i"
            style="width:13px; height:13px;"
            :style="i <= Math.round(formation.average_rating) ? 'color:#C9A84C;' : 'color:rgba(13,27,42,0.12);'"
            weight="fill"
          />
        </div>
        <span style="font-size:12px; font-weight:800; color:#0D1B2A;">{{ formation.average_rating }}</span>
        <span style="font-size:12px; color:rgba(13,27,42,0.35);">({{ formation.reviews_count }} avis)</span>
      </div>

      <!-- Séparateur -->
      <div style="height:1px; background:rgba(13,27,42,0.06); margin-bottom:16px;" />

      <!-- Prix + CTA -->
      <div style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
        <div>
          <div v-if="formation.current_price" style="display:flex; align-items:baseline; gap:6px;">
            <span style="font-size:22px; font-weight:900; color:#0D1B2A; letter-spacing:-0.02em; line-height:1;">
              {{ formation.current_price }}€
            </span>
            <span
              v-if="formation.is_on_promo && formation.price"
              style="font-size:13px; color:rgba(13,27,42,0.35); text-decoration:line-through;"
            >
              {{ formation.price }}€
            </span>
          </div>
          <span v-else style="font-size:13px; font-weight:600; color:rgba(13,27,42,0.45);">Sur demande</span>

          <!-- Badge promo -->
          <div v-if="formation.is_on_promo" style="margin-top:4px;">
            <span style="background:rgba(239,68,68,0.1); color:#DC2626; font-size:10px; font-weight:800; padding:2px 8px; border-radius:100px;">
              Promotion
            </span>
          </div>
        </div>

        <Link
          :href="route('formations.show', formation.slug)"
          style="display:inline-flex; align-items:center; gap:7px; background:#C9A84C; color:#0D1B2A; font-weight:800; font-size:13px; padding:11px 18px; border-radius:100px; text-decoration:none; white-space:nowrap; flex-shrink:0; transition:all 0.3s cubic-bezier(0.16,1,0.3,1);"
          class="card-cta"
        >
          En savoir plus
          <PhArrowRight style="width:14px; height:14px;" />
        </Link>
      </div>
    </div>
  </article>
</template>

<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import {
  PhStar, PhCertificate, PhChartBar, PhClock, PhArrowRight,
} from '@phosphor-icons/vue'

const props = defineProps({
  formation: { type: Object, required: true },
})

const levelLabels = {
  debutant:      'Débutant',
  intermediaire: 'Intermédiaire',
  avance:        'Avancé',
  tous:          'Tous niveaux',
}

const levelLabel = computed(() => levelLabels[props.formation.level] ?? props.formation.level)
</script>

<style scoped>
.formation-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 20px 60px rgba(13,27,42,0.14);
  border-color: rgba(201,168,76,0.2);
}
.formation-card:hover .card-img {
  transform: scale(1.06);
}
.card-cta:hover {
  background: #E2C97E;
  transform: translateY(-1px);
  box-shadow: 0 6px 20px rgba(201,168,76,0.35);
}
</style>