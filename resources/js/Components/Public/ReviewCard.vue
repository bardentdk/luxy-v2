<template>
  <div
    style="background:white; border-radius:20px; padding:28px; border:1.5px solid rgba(13,27,42,0.07); display:flex; flex-direction:column; gap:16px; transition:all 0.3s ease; position:relative; overflow:hidden;"
    class="review-card"
  >
    <!-- Guillemet décoratif -->
    <div style="position:absolute; top:20px; right:20px; font-size:64px; line-height:1; color:rgba(201,168,76,0.08); font-family:Georgia,serif; pointer-events:none; user-select:none;">
      "
    </div>

    <!-- Étoiles -->
    <div style="display:flex; gap:3px;">
      <PhStar
        v-for="i in 5"
        :key="i"
        style="width:16px; height:16px;"
        :style="i <= review.rating ? 'color:#C9A84C;' : 'color:rgba(13,27,42,0.1);'"
        weight="fill"
      />
    </div>

    <!-- Commentaire -->
    <p style="font-size:14px; color:rgba(13,27,42,0.7); line-height:1.75; flex:1; font-style:italic; margin:0; position:relative; z-index:1;">
      "{{ review.comment }}"
    </p>

    <!-- Formation liée -->
    <div v-if="review.formation" style="display:inline-flex; align-items:center; gap:6px; background:rgba(201,168,76,0.08); border:1px solid rgba(201,168,76,0.15); padding:5px 10px; border-radius:8px; width:fit-content;">
      <PhGraduationCap style="width:12px; height:12px; color:#C9A84C;" weight="fill" />
      <span style="font-size:11px; font-weight:700; color:rgba(13,27,42,0.6); overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width:180px;">
        {{ review.formation.title }}
      </span>
    </div>

    <!-- Séparateur -->
    <div style="height:1px; background:rgba(13,27,42,0.06);" />

    <!-- Reviewer -->
    <div style="display:flex; align-items:center; gap:12px;">
      <img
        v-if="review.reviewer_avatar"
        :src="review.reviewer_avatar"
        :alt="review.reviewer_name"
        style="width:42px; height:42px; border-radius:50%; object-fit:cover; flex-shrink:0; border:2px solid rgba(201,168,76,0.2);"
      />
      <div
        v-else
        style="width:42px; height:42px; border-radius:50%; background:linear-gradient(135deg,#0D1B2A,#1A2D42); display:flex; align-items:center; justify-content:center; flex-shrink:0; border:2px solid rgba(201,168,76,0.2);"
      >
        <span style="color:#C9A84C; font-weight:900; font-size:16px; line-height:1;">
          {{ review.reviewer_name.charAt(0).toUpperCase() }}
        </span>
      </div>
      <div style="flex:1; min-width:0;">
        <p style="font-size:14px; font-weight:800; color:#0D1B2A; margin:0 0 2px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
          {{ review.reviewer_name }}
        </p>
        <p v-if="review.reviewer_job" style="font-size:12px; color:rgba(13,27,42,0.45); margin:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
          {{ review.reviewer_job }}
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { PhStar, PhGraduationCap } from '@phosphor-icons/vue'

defineProps({
  review: { type: Object, required: true },
})
</script>

<style scoped>
.review-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 40px rgba(13,27,42,0.1);
  border-color: rgba(201,168,76,0.2);
}
</style>