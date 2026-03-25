<template>
  <PublicLayout>
    <Head title="La vie du centre" />

    <!-- Hero -->
    <section style="position:relative; background:white; padding:140px 0 80px; overflow:hidden;">
      <div style="position:absolute; top:-200px; right:-200px; width:700px; height:700px; border-radius:50%; background:radial-gradient(circle, rgba(201,168,76,0.08) 0%, transparent 65%); pointer-events:none;" />
      <div style="position:absolute; left:0; top:20%; bottom:20%; width:3px; background:linear-gradient(to bottom, transparent, #C9A84C 40%, #E2C97E 60%, transparent); border-radius:2px;" />

      <div style="max-width:1400px; margin:0 auto; padding:0 3rem; position:relative; z-index:1;">
        <div data-reveal style="display:inline-flex; align-items:center; gap:8px; background:rgba(201,168,76,0.08); border:1px solid rgba(201,168,76,0.22); border-radius:100px; padding:6px 14px; margin-bottom:24px;">
          <PhNewspaper style="width:13px; height:13px; color:#C9A84C;" />
          <span style="font-size:11px; font-weight:700; color:#A07828; letter-spacing:0.08em; text-transform:uppercase;">Actualités & Blog</span>
        </div>
        <h1 data-reveal style="font-family:'Syne',sans-serif; font-size:clamp(44px,6vw,80px); font-weight:800; color:#0D1B2A; letter-spacing:-0.04em; line-height:1; margin:0 0 20px;">
          La vie du centre
        </h1>
        <p data-reveal style="--delay:0.1s; font-size:18px; color:rgba(13,27,42,0.5); max-width:520px; line-height:1.75; margin:0;">
          Nos actualités, conseils et témoignages du monde de la formation professionnelle à La Réunion.
        </p>
      </div>
    </section>

    <!-- Articles -->
    <section style="background:#FAF8F3; padding:60px 0 100px;">
      <div style="max-width:1400px; margin:0 auto; padding:0 3rem;">

        <!-- Article vedette -->
        <div v-if="articles.data?.[0]" style="margin-bottom:60px;">
          <Link
            :href="route('articles.show', articles.data[0].slug)"
            style="display:grid; grid-template-columns:1.2fr 1fr; background:white; border-radius:28px; overflow:hidden; text-decoration:none; border:1.5px solid rgba(13,27,42,0.07); box-shadow:0 4px 32px rgba(13,27,42,0.07); transition:all 0.45s cubic-bezier(0.16,1,0.3,1);"
            class="featured-article"
          >
            <div style="overflow:hidden; min-height:380px; position:relative;">
              <img :src="articles.data[0].thumbnail_url" :alt="articles.data[0].title" style="width:100%; height:100%; object-fit:cover; transition:transform 0.7s cubic-bezier(0.16,1,0.3,1); display:block;" class="feat-img" />
              <div style="position:absolute; inset:0; background:linear-gradient(to right, transparent 60%, rgba(255,255,255,0.05));" />
              <div style="position:absolute; top:20px; left:20px; background:#C9A84C; color:#0D1B2A; font-family:'Syne',sans-serif; font-size:11px; font-weight:800; padding:5px 14px; border-radius:100px; letter-spacing:0.05em; text-transform:uppercase; box-shadow:0 4px 12px rgba(201,168,76,0.35);">
                À la une
              </div>
            </div>
            <div style="padding:52px 48px; display:flex; flex-direction:column; justify-content:center;">
              <div style="display:flex; align-items:center; gap:12px; margin-bottom:20px; font-size:12px; color:rgba(13,27,42,0.4); flex-wrap:wrap;">
                <span style="display:flex; align-items:center; gap:4px;"><PhCalendarBlank style="width:12px;height:12px;" /> {{ articles.data[0].formatted_published_at }}</span>
                <span style="display:flex; align-items:center; gap:4px;"><PhClock style="width:12px;height:12px;" /> {{ articles.data[0].read_time }} min</span>
              </div>
              <h2 style="font-family:'Syne',sans-serif; font-size:clamp(20px,2.5vw,32px); font-weight:800; color:#0D1B2A; letter-spacing:-0.025em; line-height:1.2; margin:0 0 14px;">
                {{ articles.data[0].title }}
              </h2>
              <p style="font-size:15px; color:rgba(13,27,42,0.55); line-height:1.75; margin-bottom:28px;">{{ articles.data[0].excerpt }}</p>
              <div style="display:flex; align-items:center; justify-content:space-between; padding-top:24px; border-top:1px solid rgba(13,27,42,0.07); flex-wrap:wrap; gap:12px;">
                <div v-if="articles.data[0].author" style="display:flex; align-items:center; gap:10px;">
                  <img :src="articles.data[0].author.avatar_url" style="width:32px; height:32px; border-radius:50%; object-fit:cover; border:2px solid rgba(201,168,76,0.2);" />
                  <span style="font-size:13px; font-weight:600; color:rgba(13,27,42,0.55);">{{ articles.data[0].author.full_name }}</span>
                </div>
                <span style="display:flex; align-items:center; gap:6px; font-family:'Syne',sans-serif; font-size:13px; font-weight:700; color:#A07828;">
                  Lire l'article <PhArrowRight style="width:14px; height:14px;" />
                </span>
              </div>
            </div>
          </Link>
        </div>

        <!-- Grille reste -->
        <div v-if="articles.data?.length > 1" style="display:grid; grid-template-columns:repeat(3,1fr); gap:24px; margin-bottom:60px;">
          <ArticleCardWG v-for="article in articles.data.slice(1)" :key="article.id" :article="article" />
        </div>

        <!-- Vide -->
        <div v-if="!articles.data?.length" style="text-align:center; padding:80px; background:white; border-radius:20px; border:1.5px dashed rgba(13,27,42,0.1);">
          <PhNewspaper style="width:40px; height:40px; color:rgba(201,168,76,0.4); margin:0 auto 16px; display:block;" />
          <h3 style="font-family:'Syne',sans-serif; font-size:18px; font-weight:800; color:#0D1B2A; margin-bottom:8px;">Aucun article pour le moment</h3>
          <p style="font-size:14px; color:rgba(13,27,42,0.4);">Revenez bientôt pour découvrir nos actualités.</p>
        </div>

        <!-- Pagination -->
        <div v-if="articles.last_page > 1" style="display:flex; justify-content:center; gap:8px;">
          <Link v-for="page in articles.last_page" :key="page" :href="route('articles.index', {page})" style="padding:8px 14px; border-radius:100px; font-size:13px; font-weight:700; font-family:'Syne',sans-serif; text-decoration:none; border:1.5px solid; transition:all 0.2s;" :style="page === articles.current_page ? 'background:#0D1B2A;color:white;border-color:#0D1B2A;' : 'background:white;color:rgba(13,27,42,0.55);border-color:rgba(13,27,42,0.12);'">
            {{ page }}
          </Link>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import PublicLayout  from '@/Layouts/PublicLayout.vue'
import ArticleCard from '@/Components/Public/ArticleCard.vue'
import { PhNewspaper, PhCalendarBlank, PhClock, PhArrowRight } from '@phosphor-icons/vue'
defineProps({ articles: Object })
</script>

<style scoped>
.featured-article:hover { box-shadow:0 16px 60px rgba(13,27,42,0.12) !important; transform:translateY(-4px); border-color:rgba(201,168,76,0.2) !important; }
.featured-article:hover .feat-img { transform:scale(1.04); }
</style>