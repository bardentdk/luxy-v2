<template>
  <article
    data-reveal
    style="background:white; border:1.5px solid rgba(13,27,42,0.07); border-radius:24px; overflow:hidden; display:flex; flex-direction:column; transition:all 0.5s cubic-bezier(0.16,1,0.3,1); position:relative; cursor:none;"
    class="wg-formation-card"
  >
    <!-- Image -->
    <div style="position:relative; overflow:hidden; height:220px; flex-shrink:0;">
      <img
        :src="formation.thumbnail_url"
        :alt="formation.title"
        style="width:100%; height:100%; object-fit:cover; transition:transform 0.8s cubic-bezier(0.16,1,0.3,1); display:block;"
        class="wg-card-img"
        loading="lazy"
      />
      <div style="position:absolute; inset:0; background:linear-gradient(to top, rgba(13,27,42,0.6) 0%, rgba(13,27,42,0.1) 50%, transparent 100%);" />

      <!-- Badges -->
      <div style="position:absolute; top:14px; left:14px; display:flex; gap:8px; flex-wrap:wrap;">
        <span v-if="formation.category" style="background:rgba(255,255,255,0.9); backdrop-filter:blur(10px); color:#0D1B2A; font-size:11px; font-weight:700; padding:5px 12px; border-radius:100px; white-space:nowrap; letter-spacing:0.01em;">
          {{ formation.category.name }}
        </span>
      </div>
      <div v-if="formation.has_certification" style="position:absolute; top:14px; right:14px;">
        <span style="background:rgba(201,168,76,0.9); backdrop-filter:blur(10px); color:#0D1B2A; font-size:11px; font-weight:700; padding:5px 10px; border-radius:100px; display:flex; align-items:center; gap:5px; white-space:nowrap;">
          <PhCertificate style="width:11px; height:11px;" weight="fill" /> Certifiante
        </span>
      </div>

      <!-- Méta bas -->
      <div style="position:absolute; bottom:14px; left:14px; display:flex; gap:8px;">
        <span style="background:rgba(13,27,42,0.65); backdrop-filter:blur(8px); color:rgba(255,255,255,0.85); font-size:11px; font-weight:600; padding:4px 9px; border-radius:6px; display:flex; align-items:center; gap:4px; white-space:nowrap;">
          <PhChartBar style="width:10px; height:10px;" /> {{ levelLabel }}
        </span>
        <span v-if="formation.duration" style="background:rgba(13,27,42,0.65); backdrop-filter:blur(8px); color:rgba(255,255,255,0.85); font-size:11px; font-weight:600; padding:4px 9px; border-radius:6px; display:flex; align-items:center; gap:4px; white-space:nowrap;">
          <PhClock style="width:10px; height:10px;" /> {{ formation.duration }}
        </span>
      </div>
    </div>

    <!-- Contenu -->
    <div style="flex:1; display:flex; flex-direction:column; padding:22px;">
      <h3 style="font-family:'Syne',sans-serif; font-size:17px; font-weight:700; color:#0D1B2A; line-height:1.3; margin:0 0 8px; letter-spacing:-0.01em; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
        {{ formation.title }}
      </h3>

      <p v-if="formation.short_description" style="font-size:13px; color:rgba(13,27,42,0.5); line-height:1.65; margin:0 0 14px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; flex:1;">
        {{ formation.short_description }}
      </p>
      <div v-else style="flex:1;" />

      <!-- Rating -->
      <div v-if="formation.average_rating > 0" style="display:flex; align-items:center; gap:6px; margin-bottom:16px;">
        <div style="display:flex; gap:2px;">
          <PhStar v-for="i in 5" :key="i" style="width:12px; height:12px;" :style="i <= Math.round(formation.average_rating) ? 'color:#C9A84C;' : 'color:rgba(13,27,42,0.1);'" weight="fill" />
        </div>
        <span style="font-size:12px; font-weight:700; color:#0D1B2A;">{{ formation.average_rating }}</span>
        <span style="font-size:12px; color:rgba(13,27,42,0.3);">({{ formation.reviews_count }})</span>
      </div>

      <div style="height:1px; background:rgba(13,27,42,0.06); margin-bottom:16px;" />

      <!-- Prix + CTA -->
      <div style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
        <div>
          <div v-if="formation.current_price" style="display:flex; align-items:baseline; gap:6px;">
            <span style="font-family:'Syne',sans-serif; font-size:22px; font-weight:800; color:#0D1B2A; letter-spacing:-0.02em; line-height:1;">{{ formation.current_price }}€</span>
            <span v-if="formation.is_on_promo" style="font-size:12px; color:rgba(13,27,42,0.3); text-decoration:line-through;">{{ formation.price }}€</span>
          </div>
          <span v-if="formation.is_on_promo" style="background:rgba(201,168,76,0.12); border:1px solid rgba(201,168,76,0.25); color:#A07828; font-size:10px; font-weight:700; padding:2px 8px; border-radius:100px; display:inline-block; margin-top:3px; letter-spacing:0.03em;">PROMO</span>
          <span v-if="!formation.current_price" style="font-size:13px; font-weight:600; color:rgba(13,27,42,0.4);">Sur demande</span>
        </div>
        <Link :href="route('formations.show', formation.slug)" class="btn-gold" style="font-size:12px; padding:10px 18px; flex-shrink:0;">
          Découvrir <PhArrowRight style="width:13px; height:13px;" />
        </Link>
      </div>
    </div>

    <!-- Ligne gold bas au hover -->
    <div style="position:absolute; bottom:0; left:0; right:0; height:2px; background:linear-gradient(90deg,#C9A84C,#E2C97E,#C9A84C); transform:scaleX(0); transition:transform 0.45s cubic-bezier(0.16,1,0.3,1); transform-origin:left;" class="wg-gold-line" />
  </article>
</template>

<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { PhStar, PhCertificate, PhChartBar, PhClock, PhArrowRight } from '@phosphor-icons/vue'

const props = defineProps({
  formation: { type: Object, required: true },
  index:     { type: Number, default: 0 },
})

const levelLabels = { debutant:'Débutant', intermediaire:'Intermédiaire', avance:'Avancé', tous:'Tous niveaux' }
const levelLabel  = computed(() => levelLabels[props.formation.level] ?? props.formation.level)
</script>

<style scoped>
.wg-formation-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 24px 60px rgba(13,27,42,0.12), 0 0 0 1px rgba(201,168,76,0.15);
  border-color: rgba(201,168,76,0.2) !important;
}
.wg-formation-card:hover .wg-card-img    { transform: scale(1.06); }
.wg-formation-card:hover .wg-gold-line   { transform: scaleX(1); }
</style>