<template>
  <article
    data-reveal
    style="border-radius:20px; overflow:hidden; border:1.5px solid rgba(13,27,42,0.07); display:flex; flex-direction:column; transition:all 0.45s cubic-bezier(0.16,1,0.3,1); cursor:none; background:white;"
    class="wg-article-card"
  >
    <!-- Image -->
    <div style="overflow:hidden; position:relative; flex-shrink:0;" :style="featured ? 'height:260px;' : 'height:180px;'">
      <img
        :src="article.thumbnail_url"
        :alt="article.title"
        style="width:100%; height:100%; object-fit:cover; transition:transform 0.8s cubic-bezier(0.16,1,0.3,1); display:block;"
        class="wg-article-img"
        loading="lazy"
      />
      <div style="position:absolute; inset:0; background:linear-gradient(to top, rgba(13,27,42,0.5) 0%, transparent 60%);" />

      <!-- Badge vedette -->
      <div v-if="featured" style="position:absolute; top:14px; left:14px; background:#C9A84C; color:#0D1B2A; font-family:'Syne',sans-serif; font-size:10px; font-weight:800; padding:5px 12px; border-radius:100px; letter-spacing:0.06em; text-transform:uppercase; box-shadow:0 4px 12px rgba(201,168,76,0.4);">
        À la une
      </div>

      <!-- Tags -->
      <div v-if="article.tags?.length" style="position:absolute; bottom:12px; left:12px; display:flex; gap:6px;">
        <span v-for="tag in article.tags.slice(0,2)" :key="tag" style="background:rgba(13,27,42,0.65); backdrop-filter:blur(8px); color:rgba(255,255,255,0.85); font-size:10px; font-weight:700; padding:3px 9px; border-radius:100px; white-space:nowrap; letter-spacing:0.04em; text-transform:uppercase;">
          {{ tag }}
        </span>
      </div>
    </div>

    <!-- Contenu -->
    <div style="padding:20px 22px 24px; display:flex; flex-direction:column; flex:1; gap:10px;">
      <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
        <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:600; color:rgba(13,27,42,0.35); letter-spacing:0.04em; text-transform:uppercase;">
          <PhCalendarBlank style="width:11px; height:11px;" /> {{ article.formatted_published_at }}
        </span>
        <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:600; color:rgba(13,27,42,0.35); letter-spacing:0.04em;">
          <PhClock style="width:11px; height:11px;" /> {{ article.read_time }} min
        </span>
      </div>

      <h3
        style="font-family:'Syne',sans-serif; font-weight:700; color:#0D1B2A; line-height:1.3; margin:0; letter-spacing:-0.01em; flex:1; display:-webkit-box; -webkit-box-orient:vertical; overflow:hidden;"
        :style="featured ? 'font-size:20px; -webkit-line-clamp:3;' : 'font-size:15px; -webkit-line-clamp:2;'"
      >
        {{ article.title }}
      </h3>

      <p v-if="featured && article.excerpt" style="font-size:13px; color:rgba(13,27,42,0.5); line-height:1.7; margin:0; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
        {{ article.excerpt }}
      </p>

      <div style="display:flex; align-items:center; justify-content:space-between; padding-top:12px; border-top:1px solid rgba(13,27,42,0.06); margin-top:auto; gap:10px;">
        <div v-if="article.author" style="display:flex; align-items:center; gap:8px; min-width:0;">
          <img :src="article.author.avatar_url" :alt="article.author.full_name" style="width:24px; height:24px; border-radius:50%; object-fit:cover; border:1.5px solid rgba(201,168,76,0.2);" />
          <span style="font-size:12px; font-weight:500; color:rgba(13,27,42,0.4); overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ article.author.full_name }}</span>
        </div>
        <Link
          :href="route('articles.show', article.slug)"
          style="display:inline-flex; align-items:center; gap:5px; font-family:'Syne',sans-serif; font-size:12px; font-weight:700; color:#A07828; text-decoration:none; flex-shrink:0; letter-spacing:0.02em; transition:all 0.2s;"
          class="wg-read-link"
        >
          Lire <PhArrowRight style="width:13px; height:13px;" />
        </Link>
      </div>
    </div>
  </article>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { PhCalendarBlank, PhClock, PhArrowRight } from '@phosphor-icons/vue'
defineProps({ article: { type: Object, required: true }, featured: { type: Boolean, default: false } })
</script>

<style scoped>
.wg-article-card:hover { border-color:rgba(201,168,76,0.2) !important; transform:translateY(-5px); box-shadow:0 20px 50px rgba(13,27,42,0.1); }
.wg-article-card:hover .wg-article-img { transform:scale(1.06); }
.wg-read-link:hover { color:#0D1B2A !important; gap:8px !important; }
</style>