<template>
  <PublicLayout>
    <Head :title="page.meta_title ?? page.title" />

    <!-- Hero -->
    <section style="position:relative; background:white; padding:140px 0 60px; overflow:hidden;">
      <div style="position:absolute; top:-200px; right:-200px; width:600px; height:600px; border-radius:50%; background:radial-gradient(circle, rgba(201,168,76,0.07) 0%, transparent 65%); pointer-events:none;" />
      <div style="position:absolute; left:0; top:20%; bottom:20%; width:3px; background:linear-gradient(to bottom, transparent, #C9A84C 40%, #E2C97E 60%, transparent); border-radius:2px;" />

      <div style="max-width:1000px; margin:0 auto; padding:0 3rem; position:relative; z-index:1;">
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:24px; font-size:13px; color:rgba(13,27,42,0.4); flex-wrap:wrap;">
          <Link :href="route('home')" style="color:inherit; text-decoration:none; transition:color 0.2s;" class="bc-link">Accueil</Link>
          <PhCaretRight style="width:12px; height:12px;" />
          <span style="color:rgba(13,27,42,0.65);">{{ page.title }}</span>
        </div>
        <h1 style="font-family:'Syne',sans-serif; font-size:clamp(36px,5vw,68px); font-weight:800; color:#0D1B2A; letter-spacing:-0.04em; line-height:1.05; margin:0;">
          {{ page.title }}
        </h1>
      </div>
    </section>

    <!-- Contenu -->
    <section style="background:#FAF8F3; padding:60px 0 100px;">
      <div style="max-width:900px; margin:0 auto; padding:0 3rem;">
        <div style="background:white; border-radius:24px; padding:52px; border:1.5px solid rgba(13,27,42,0.07); box-shadow:0 4px 32px rgba(13,27,42,0.06);">
          <div class="prose-wg" v-html="page.content" />
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import { PhCaretRight } from '@phosphor-icons/vue'
defineProps({ page: Object })
</script>

<style scoped>
.bc-link:hover { color:#C9A84C !important; }
.prose-wg { font-size:16px; color:rgba(13,27,42,0.72); line-height:1.85; }
.prose-wg h2 { font-family:'Syne',sans-serif; font-size:24px; font-weight:800; color:#0D1B2A; letter-spacing:-0.02em; margin:48px 0 14px; padding-bottom:12px; border-bottom:2px solid rgba(201,168,76,0.25); }
.prose-wg h3 { font-family:'Syne',sans-serif; font-size:19px; font-weight:700; color:#0D1B2A; margin:32px 0 10px; }
.prose-wg p  { margin-bottom:18px; }
.prose-wg ul, .prose-wg ol { padding-left:22px; margin-bottom:18px; }
.prose-wg li { margin-bottom:8px; }
.prose-wg strong { color:#0D1B2A; font-weight:800; }
.prose-wg a { color:#C9A84C; text-decoration:underline; }
.prose-wg table { width:100%; border-collapse:collapse; margin-bottom:24px; border-radius:12px; overflow:hidden; }
.prose-wg th { background:#FAF8F3; padding:12px 16px; text-align:left; font-family:'Syne',sans-serif; font-weight:700; font-size:13px; color:#0D1B2A; border-bottom:2px solid rgba(13,27,42,0.08); }
.prose-wg td { padding:12px 16px; font-size:14px; border-bottom:1px solid rgba(13,27,42,0.06); color:rgba(13,27,42,0.7); }
</style>