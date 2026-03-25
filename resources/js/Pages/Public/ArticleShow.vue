<template>
  <PublicLayout>
    <Head :title="article.meta_title ?? article.title" />

    <!-- Hero -->
    <section style="position:relative; background:white; padding:140px 0 0; overflow:hidden;">
      <div style="position:absolute; top:-200px; right:-200px; width:700px; height:700px; border-radius:50%; background:radial-gradient(circle, rgba(201,168,76,0.07) 0%, transparent 65%); pointer-events:none;" />
      <div style="position:absolute; left:0; top:15%; bottom:15%; width:3px; background:linear-gradient(to bottom, transparent, #C9A84C 40%, #E2C97E 60%, transparent); border-radius:2px;" />

      <div style="max-width:900px; margin:0 auto; padding:0 3rem; position:relative; z-index:1;">

        <!-- Breadcrumb -->
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:32px; font-size:13px; color:rgba(13,27,42,0.4); flex-wrap:wrap;">
          <Link :href="route('home')" style="color:inherit; text-decoration:none; transition:color 0.2s;" class="bc-link">Accueil</Link>
          <PhCaretRight style="width:12px; height:12px;" />
          <Link :href="route('articles.index')" style="color:inherit; text-decoration:none; transition:color 0.2s;" class="bc-link">La vie du centre</Link>
          <PhCaretRight style="width:12px; height:12px;" />
          <span style="color:rgba(13,27,42,0.6); overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width:220px;">{{ article.title }}</span>
        </div>

        <!-- Tags -->
        <div v-if="article.tags?.length" style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:20px;">
          <span v-for="tag in article.tags" :key="tag" style="background:rgba(201,168,76,0.08); border:1px solid rgba(201,168,76,0.22); color:#A07828; font-size:12px; font-weight:700; padding:5px 12px; border-radius:100px; font-family:'Syne',sans-serif;">{{ tag }}</span>
        </div>

        <h1 data-reveal style="font-family:'Syne',sans-serif; font-size:clamp(32px,4.5vw,60px); font-weight:800; color:#0D1B2A; letter-spacing:-0.035em; line-height:1.05; margin-bottom:20px;">
          {{ article.title }}
        </h1>

        <p style="font-size:18px; color:rgba(13,27,42,0.5); line-height:1.75; margin-bottom:36px;">{{ article.excerpt }}</p>

        <!-- Meta auteur -->
        <div style="display:flex; align-items:center; justify-content:space-between; padding:24px 0 36px; border-top:1px solid rgba(13,27,42,0.08); flex-wrap:wrap; gap:16px;">
          <div style="display:flex; align-items:center; gap:14px;">
            <img v-if="article.author?.avatar_url" :src="article.author.avatar_url" :alt="article.author.full_name" style="width:44px; height:44px; border-radius:50%; object-fit:cover; border:2px solid rgba(201,168,76,0.25);" />
            <div>
              <div style="font-family:'Syne',sans-serif; font-size:15px; font-weight:700; color:#0D1B2A;">{{ article.author?.full_name }}</div>
              <div style="font-size:13px; color:rgba(13,27,42,0.4);">{{ article.formatted_published_at }}</div>
            </div>
          </div>
          <div style="display:flex; align-items:center; gap:6px; font-size:13px; color:rgba(13,27,42,0.4);">
            <PhClock style="width:14px; height:14px; color:#C9A84C;" />
            {{ article.read_time }} min de lecture
          </div>
        </div>
      </div>

      <!-- Bannière -->
      <div v-if="article.banner_url" style="max-width:1400px; margin:0 auto; padding:0 3rem; position:relative; z-index:1;">
        <img :src="article.banner_url" :alt="article.title" style="width:100%; height:440px; object-fit:cover; border-radius:24px 24px 0 0; display:block;" />
      </div>
    </section>

    <!-- Corps -->
    <section style="background:#FAF8F3; padding:80px 0 100px;">
      <div style="max-width:760px; margin:0 auto; padding:0 3rem;">
        <div class="prose-wg" v-html="article.content" />

        <!-- Tags bas -->
        <div v-if="article.tags?.length" style="margin-top:56px; padding-top:36px; border-top:1px solid rgba(13,27,42,0.08); display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
          <span style="font-size:13px; font-weight:600; color:rgba(13,27,42,0.35);">Tags :</span>
          <span v-for="tag in article.tags" :key="tag" style="background:white; border:1.5px solid rgba(13,27,42,0.1); color:rgba(13,27,42,0.55); font-size:13px; font-weight:600; padding:5px 14px; border-radius:100px;">{{ tag }}</span>
        </div>

        <!-- CTA -->
        <div style="margin-top:64px; background:#0D1B2A; border-radius:24px; padding:48px; text-align:center; position:relative; overflow:hidden;">
          <div style="position:absolute; inset:0; background:radial-gradient(ellipse 60% 50% at 50% 50%, rgba(201,168,76,0.12) 0%, transparent 70%); pointer-events:none;" />
          <h3 style="font-family:'Syne',sans-serif; font-size:26px; font-weight:800; color:white; margin-bottom:12px; letter-spacing:-0.02em; position:relative; z-index:1;">Intéressé par nos formations ?</h3>
          <p style="font-size:15px; color:rgba(255,255,255,0.45); margin-bottom:28px; line-height:1.7; position:relative; z-index:1;">Découvrez notre catalogue de formations professionnelles à La Réunion.</p>
          <div style="display:flex; justify-content:center; gap:12px; flex-wrap:wrap; position:relative; z-index:1;">
            <Link :href="route('formations.index')" class="btn-gold"><PhGraduationCap style="width:16px; height:16px;" /> Voir les formations</Link>
            <Link :href="route('contact')" style="display:inline-flex; align-items:center; gap:8px; background:transparent; color:rgba(255,255,255,0.65); font-family:'Syne',sans-serif; font-weight:700; font-size:14px; padding:14px 26px; border-radius:100px; text-decoration:none; border:1.5px solid rgba(255,255,255,0.2); transition:all 0.3s;" class="ghost-btn">
              Nous contacter
            </Link>
          </div>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import { PhCaretRight, PhClock, PhGraduationCap } from '@phosphor-icons/vue'
defineProps({ article: Object })
</script>

<style scoped>
.bc-link:hover  { color:#C9A84C !important; }
.ghost-btn:hover { background:rgba(255,255,255,0.08) !important; border-color:rgba(255,255,255,0.4) !important; color:white !important; }
.prose-wg { font-size:17px; color:rgba(13,27,42,0.72); line-height:1.85; }
.prose-wg h2 { font-family:'Syne',sans-serif; font-size:26px; font-weight:800; color:#0D1B2A; letter-spacing:-0.02em; margin:48px 0 16px; }
.prose-wg h3 { font-family:'Syne',sans-serif; font-size:21px; font-weight:800; color:#0D1B2A; margin:36px 0 12px; }
.prose-wg p  { margin-bottom:20px; }
.prose-wg ul, .prose-wg ol { padding-left:24px; margin-bottom:20px; }
.prose-wg li { margin-bottom:8px; }
.prose-wg strong { color:#0D1B2A; font-weight:800; }
.prose-wg blockquote { border-left:3px solid #C9A84C; padding-left:24px; margin:32px 0; font-style:italic; color:rgba(13,27,42,0.55); background:rgba(201,168,76,0.04); border-radius:0 12px 12px 0; padding:20px 24px; }
.prose-wg img { width:100%; border-radius:16px; margin:28px 0; }
.prose-wg a { color:#C9A84C; text-decoration:underline; }
</style>