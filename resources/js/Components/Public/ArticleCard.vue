<template>
  <article
    style="background:white; border-radius:20px; overflow:hidden; border:1.5px solid rgba(13,27,42,0.07); display:flex; flex-direction:column; transition:all 0.4s cubic-bezier(0.16,1,0.3,1);"
    class="article-card"
  >
    <!-- Image -->
    <div style="overflow:hidden; position:relative; flex-shrink:0;" :style="{ aspectRatio: '16/9' }">
      <img
        :src="article.thumbnail_url"
        :alt="article.title"
        style="width:100%; height:100%; object-fit:cover; transition:transform 0.7s cubic-bezier(0.16,1,0.3,1); display:block;"
        class="article-img"
        loading="lazy"
      />
      <!-- Tags -->
      <div v-if="article.tags?.length" style="position:absolute; bottom:10px; left:10px; display:flex; gap:6px; flex-wrap:wrap;">
        <span
          v-for="tag in article.tags.slice(0,2)"
          :key="tag"
          style="background:rgba(13,27,42,0.7); backdrop-filter:blur(4px); color:rgba(255,255,255,0.9); font-size:10px; font-weight:700; padding:3px 9px; border-radius:100px; white-space:nowrap;"
        >
          {{ tag }}
        </span>
      </div>
    </div>

    <!-- Contenu -->
    <div style="padding:20px 22px 24px; display:flex; flex-direction:column; flex:1; gap:10px;">

      <!-- Meta -->
      <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
        <span style="display:inline-flex; align-items:center; gap:5px; font-size:12px; color:rgba(13,27,42,0.45); font-weight:500;">
          <PhCalendarBlank style="width:12px; height:12px;" />
          {{ article.formatted_published_at }}
        </span>
        <span style="display:inline-flex; align-items:center; gap:5px; font-size:12px; color:rgba(13,27,42,0.45); font-weight:500;">
          <PhClock style="width:12px; height:12px;" />
          {{ article.read_time }} min
        </span>
      </div>

      <!-- Titre -->
      <h3 style="font-size:16px; font-weight:800; color:#0D1B2A; line-height:1.35; margin:0; letter-spacing:-0.01em; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; flex:1;">
        {{ article.title }}
      </h3>

      <!-- Excerpt -->
      <p v-if="article.excerpt" style="font-size:13px; color:rgba(13,27,42,0.5); line-height:1.65; margin:0; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
        {{ article.excerpt }}
      </p>

      <!-- Footer -->
      <div style="display:flex; align-items:center; justify-content:space-between; margin-top:6px; padding-top:14px; border-top:1px solid rgba(13,27,42,0.06); gap:10px;">
        <div v-if="article.author" style="display:flex; align-items:center; gap:8px; min-width:0;">
          <img
            :src="article.author.avatar_url"
            :alt="article.author.full_name"
            style="width:26px; height:26px; border-radius:50%; object-fit:cover; flex-shrink:0;"
          />
          <span style="font-size:12px; font-weight:600; color:rgba(13,27,42,0.55); overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
            {{ article.author.full_name }}
          </span>
        </div>

        <Link
          :href="route('articles.show', article.slug)"
          style="display:inline-flex; align-items:center; gap:5px; font-size:13px; font-weight:800; color:#C9A84C; text-decoration:none; flex-shrink:0; transition:all 0.2s;"
          class="read-link"
        >
          Lire
          <PhArrowRight style="width:14px; height:14px;" />
        </Link>
      </div>
    </div>
  </article>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { PhCalendarBlank, PhClock, PhArrowRight } from '@phosphor-icons/vue'

defineProps({
  article: { type: Object, required: true },
})
</script>

<style scoped>
.article-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 16px 48px rgba(13,27,42,0.12);
  border-color: rgba(201,168,76,0.15);
}
.article-card:hover .article-img {
  transform: scale(1.05);
}
.read-link:hover {
  gap: 8px !important;
  color: #0D1B2A !important;
}
</style>