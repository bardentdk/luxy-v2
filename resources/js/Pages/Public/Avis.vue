<template>
  <PublicLayout>
    <Head title="Vos avis" />

    <!-- Hero -->
    <section style="background:#0A1628; padding:140px 0 80px; position:relative; overflow:hidden;">
      <div class="orb orb-1" />
      <div class="hero-grid" />
      <div style="max-width:1320px; margin:0 auto; padding:0 3rem; position:relative; z-index:1; text-align:center;">
        <div class="fade-up" style="--d:0s; display:inline-flex; align-items:center; gap:8px; background:rgba(201,168,76,0.08); border:1px solid rgba(201,168,76,0.2); border-radius:100px; padding:8px 16px; margin-bottom:24px;">
          <PhStar style="width:14px; height:14px; color:#C9A84C;" weight="fill" />
          <span style="color:#C9A84C; font-size:13px; font-weight:600;">Témoignages</span>
        </div>
        <h1 class="fade-up" style="--d:0.1s; font-size:clamp(40px,5vw,72px); font-weight:900; color:white; letter-spacing:-0.03em; line-height:1.05; margin-bottom:20px;">
          Ce que disent<br>
          <span style="background:linear-gradient(135deg,#C9A84C,#E8C97E); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;">nos apprenants</span>
        </h1>

        <!-- Score global -->
        <div class="fade-up" style="--d:0.2s; display:inline-flex; align-items:center; gap:20px; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); border-radius:20px; padding:20px 36px; margin-top:20px; flex-wrap:wrap; justify-content:center;">
          <div style="text-align:center;">
            <div style="font-size:52px; font-weight:900; color:white; line-height:1;">{{ stats.average }}</div>
            <div style="display:flex; gap:4px; justify-content:center; margin-top:6px;">
              <PhStar v-for="i in 5" :key="i" style="width:18px; height:18px;" :style="i <= Math.round(stats.average) ? 'color:#C9A84C;' : 'color:rgba(255,255,255,0.15);'" weight="fill" />
            </div>
          </div>
          <div style="width:1px; height:60px; background:rgba(255,255,255,0.1);" />
          <div>
            <div style="font-size:28px; font-weight:900; color:white; margin-bottom:4px;">{{ stats.total }}</div>
            <div style="font-size:14px; color:rgba(255,255,255,0.4);">avis vérifiés</div>
          </div>
          <div style="width:1px; height:60px; background:rgba(255,255,255,0.1);" />
          <div style="display:flex; flex-direction:column; gap:6px;">
            <div v-for="(count, rating) in ratingBreakdown" :key="rating" style="display:flex; align-items:center; gap:10px;">
              <span style="font-size:12px; color:rgba(255,255,255,0.5); width:12px; text-align:right;">{{ 5 - rating }}</span>
              <PhStar style="width:12px; height:12px; color:#C9A84C;" weight="fill" />
              <div style="width:100px; height:4px; background:rgba(255,255,255,0.1); border-radius:2px; overflow:hidden;">
                <div :style="`width:${stats.total > 0 ? (count / stats.total * 100) : 0}%; height:100%; background:#C9A84C; border-radius:2px;`" />
              </div>
              <span style="font-size:12px; color:rgba(255,255,255,0.4);">{{ count }}</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Grille avis -->
    <section style="background:#FAF7F2; padding:80px 0 100px;">
      <div style="max-width:1320px; margin:0 auto; padding:0 3rem;">

        <div v-if="reviews.data?.length" style="display:grid; grid-template-columns:repeat(3,1fr); gap:24px; margin-bottom:60px;">
          <ReviewCard
            v-for="review in reviews.data"
            :key="review.id"
            :review="review"
          />
        </div>

        <div v-else style="text-align:center; padding:80px 20px;">
          <div style="width:80px; height:80px; border-radius:24px; background:rgba(201,168,76,0.1); border:2px dashed rgba(201,168,76,0.3); display:flex; align-items:center; justify-content:center; margin:0 auto 24px;">
            <PhStar style="width:36px; height:36px; color:rgba(201,168,76,0.4);" weight="fill" />
          </div>
          <h3 style="font-size:20px; font-weight:700; color:#0D1B2A; margin-bottom:8px;">Aucun avis pour le moment</h3>
          <p style="font-size:15px; color:rgba(13,27,42,0.5);">Soyez le premier à partager votre expérience.</p>
        </div>

        <!-- Pagination -->
        <div v-if="reviews.last_page > 1" style="display:flex; justify-content:center; gap:8px;">
          <Link
            v-for="page in reviews.last_page"
            :key="page"
            :href="route('reviews.index', { page })"
            :style="page === reviews.current_page ? 'padding:8px 16px; border-radius:100px; font-size:13px; font-weight:700; border:1.5px solid #0D1B2A; background:#0D1B2A; color:white; text-decoration:none;' : 'padding:8px 16px; border-radius:100px; font-size:13px; font-weight:600; border:1.5px solid rgba(13,27,42,0.12); background:white; color:rgba(13,27,42,0.6); text-decoration:none;'"
          >
            {{ page }}
          </Link>
        </div>
      </div>
    </section>

    <!-- CTA laisser un avis -->
    <section style="background:white; padding:100px 0; text-align:center; border-top:1px solid rgba(13,27,42,0.06);">
      <div style="max-width:600px; margin:0 auto; padding:0 3rem;">
        <h2 style="font-size:clamp(28px,3.5vw,44px); font-weight:900; color:#0D1B2A; letter-spacing:-0.03em; margin-bottom:16px;">
          Vous avez suivi une formation chez nous ?
        </h2>
        <p style="font-size:16px; color:rgba(13,27,42,0.55); line-height:1.75; margin-bottom:36px;">
          Partagez votre expérience et aidez d'autres apprenants à faire leur choix.
        </p>
        <Link :href="route('contact')" style="display:inline-flex; align-items:center; gap:10px; background:#C9A84C; color:#0D1B2A; font-weight:800; font-size:15px; padding:15px 32px; border-radius:100px; text-decoration:none;" class="cta-hover">
          <PhStar style="width:18px; height:18px;" weight="fill" />
          Laisser un avis
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
import ReviewCard from '@/Components/Public/ReviewCard.vue'
import { PhStar } from '@phosphor-icons/vue'

const props = defineProps({
  reviews: Object,
  stats:   Object,
})

const ratingBreakdown = computed(() => [
  props.stats.five  ?? 0,
  props.stats.four  ?? 0,
  props.stats.three ?? 0,
])
</script>

<style scoped>
.orb { position:absolute; border-radius:50%; filter:blur(100px); pointer-events:none; }
.orb-1 { width:600px; height:600px; background:radial-gradient(circle,rgba(201,168,76,0.12) 0%,transparent 70%); top:-200px; right:-100px; }
.hero-grid { position:absolute; inset:0; pointer-events:none; background-image:linear-gradient(rgba(255,255,255,0.02) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,0.02) 1px,transparent 1px); background-size:80px 80px; -webkit-mask-image:radial-gradient(ellipse at center,black 40%,transparent 80%); mask-image:radial-gradient(ellipse at center,black 40%,transparent 80%); }
.fade-up { animation:fadeUp 0.7s cubic-bezier(0.16,1,0.3,1) both; animation-delay:var(--d,0s); }
@keyframes fadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
.cta-hover:hover { background:#E2C97E !important; transform:translateY(-2px); box-shadow:0 8px 32px rgba(201,168,76,0.3); }
</style>