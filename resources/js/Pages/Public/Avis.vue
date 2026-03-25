<template>
  <PublicLayout>
    <Head title="Vos avis" />

    <!-- Hero -->
    <section style="position:relative; background:white; padding:140px 0 80px; overflow:hidden;">
      <div style="position:absolute; top:-200px; right:-200px; width:700px; height:700px; border-radius:50%; background:radial-gradient(circle, rgba(201,168,76,0.08) 0%, transparent 65%); pointer-events:none;" />
      <div style="position:absolute; left:0; top:20%; bottom:20%; width:3px; background:linear-gradient(to bottom, transparent, #C9A84C 40%, #E2C97E 60%, transparent); border-radius:2px;" />

      <div style="max-width:1400px; margin:0 auto; padding:0 3rem; position:relative; z-index:1; text-align:center;">
        <div data-reveal style="display:inline-flex; align-items:center; gap:8px; background:rgba(201,168,76,0.08); border:1px solid rgba(201,168,76,0.22); border-radius:100px; padding:6px 14px; margin-bottom:24px;">
          <PhStar style="width:13px; height:13px; color:#C9A84C;" weight="fill" />
          <span style="font-size:11px; font-weight:700; color:#A07828; letter-spacing:0.08em; text-transform:uppercase;">Témoignages</span>
        </div>
        <h1 data-reveal style="font-family:'Syne',sans-serif; font-size:clamp(44px,6vw,80px); font-weight:800; color:#0D1B2A; letter-spacing:-0.04em; line-height:1; margin:0 0 20px;">
          Ce que disent<br><span class="text-gradient-gold">nos apprenants</span>
        </h1>

        <!-- Score global -->
        <div data-reveal style="--delay:0.15s; display:inline-flex; align-items:center; gap:28px; background:#FAF8F3; border:1.5px solid rgba(201,168,76,0.2); border-radius:24px; padding:24px 40px; margin-top:20px; flex-wrap:wrap; justify-content:center;">
          <div style="text-align:center;">
            <div style="font-family:'Syne',sans-serif; font-size:56px; font-weight:800; color:#0D1B2A; line-height:1; letter-spacing:-0.03em;" class="text-gradient-gold">{{ stats.average }}</div>
            <div style="display:flex; gap:4px; justify-content:center; margin-top:6px;">
              <PhStar v-for="i in 5" :key="i" style="width:16px; height:16px;" :style="i <= Math.round(stats.average) ? 'color:#C9A84C;' : 'color:rgba(13,27,42,0.1);'" weight="fill" />
            </div>
          </div>
          <div style="width:1px; height:60px; background:rgba(13,27,42,0.1);" />
          <div style="text-align:center;">
            <div style="font-family:'Syne',sans-serif; font-size:32px; font-weight:800; color:#0D1B2A; line-height:1; letter-spacing:-0.02em;">{{ stats.total }}</div>
            <div style="font-size:13px; color:rgba(13,27,42,0.4); margin-top:4px; font-weight:600;">avis vérifiés</div>
          </div>
          <div style="width:1px; height:60px; background:rgba(13,27,42,0.1);" />
          <!-- Barres -->
          <div style="display:flex; flex-direction:column; gap:6px;">
            <div v-for="(count, i) in ratingBars" :key="i" style="display:flex; align-items:center; gap:8px;">
              <span style="font-size:12px; color:rgba(13,27,42,0.4); width:10px; text-align:right; font-weight:600;">{{ 5 - i }}</span>
              <PhStar style="width:11px; height:11px; color:#C9A84C;" weight="fill" />
              <div style="width:90px; height:4px; background:rgba(13,27,42,0.08); border-radius:2px; overflow:hidden;">
                <div :style="`width:${stats.total > 0 ? (count / stats.total * 100) : 0}%; height:100%; background:#C9A84C; border-radius:2px;`" />
              </div>
              <span style="font-size:11px; color:rgba(13,27,42,0.35); width:16px;">{{ count }}</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Grille avis -->
    <section style="background:#FAF8F3; padding:60px 0 100px;">
      <div style="max-width:1400px; margin:0 auto; padding:0 3rem;">

        <div v-if="reviews.data?.length" style="display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:60px;">
          <ReviewCardWG v-for="review in reviews.data" :key="review.id" :review="review" />
        </div>

        <div v-else style="text-align:center; padding:80px; background:white; border-radius:20px; border:1.5px dashed rgba(13,27,42,0.1);">
          <PhStar style="width:40px; height:40px; color:rgba(201,168,76,0.4); margin:0 auto 16px; display:block;" weight="fill" />
          <h3 style="font-family:'Syne',sans-serif; font-size:18px; font-weight:800; color:#0D1B2A; margin-bottom:8px;">Aucun avis pour le moment</h3>
          <p style="font-size:14px; color:rgba(13,27,42,0.4);">Soyez le premier à partager votre expérience.</p>
        </div>

        <!-- Pagination -->
        <div v-if="reviews.last_page > 1" style="display:flex; justify-content:center; gap:8px; margin-bottom:60px;">
          <Link v-for="page in reviews.last_page" :key="page" :href="route('reviews.index', {page})" style="padding:8px 14px; border-radius:100px; font-size:13px; font-weight:700; font-family:'Syne',sans-serif; text-decoration:none; border:1.5px solid; transition:all 0.2s;" :style="page === reviews.current_page ? 'background:#0D1B2A;color:white;border-color:#0D1B2A;' : 'background:white;color:rgba(13,27,42,0.55);border-color:rgba(13,27,42,0.12);'">
            {{ page }}
          </Link>
        </div>

        <!-- CTA laisser avis -->
        <div style="background:#0D1B2A; border-radius:28px; padding:64px; text-align:center; position:relative; overflow:hidden;">
          <div style="position:absolute; inset:0; background:radial-gradient(ellipse 60% 50% at 50% 50%, rgba(201,168,76,0.1) 0%, transparent 70%); pointer-events:none;" />
          <div style="position:absolute; top:0; left:15%; right:15%; height:1px; background:linear-gradient(90deg,transparent,rgba(201,168,76,0.3),transparent);" />
          <h2 style="font-family:'Syne',sans-serif; font-size:clamp(26px,3.5vw,40px); font-weight:800; color:white; letter-spacing:-0.03em; margin-bottom:14px; position:relative; z-index:1;">
            Vous avez suivi une formation chez nous ?
          </h2>
          <p style="font-size:16px; color:rgba(255,255,255,0.45); line-height:1.75; margin-bottom:32px; position:relative; z-index:1; max-width:480px; margin-left:auto; margin-right:auto;">
            Partagez votre expérience et aidez d'autres apprenants à faire leur choix.
          </p>
          <Link :href="route('contact')" class="btn-gold" style="position:relative; z-index:1;">
            <PhStar style="width:17px; height:17px;" weight="fill" /> Laisser un avis
          </Link>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup>
import { computed } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import PublicLayout  from '@/Layouts/PublicLayout.vue'
import ReviewCard  from '@/Components/Public/ReviewCard.vue'
import { PhStar } from '@phosphor-icons/vue'

const props = defineProps({ reviews: Object, stats: Object })

const ratingBars = computed(() => [
  props.stats.five  ?? 0,
  props.stats.four  ?? 0,
  props.stats.three ?? 0,
])
</script>