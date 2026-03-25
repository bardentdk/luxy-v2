<template>
  <div
    data-reveal
    style="background:white; border:1.5px solid rgba(13,27,42,0.07); border-radius:20px; padding:28px; display:flex; flex-direction:column; gap:16px; transition:all 0.35s cubic-bezier(0.16,1,0.3,1); position:relative; overflow:hidden; cursor:default;"
    class="wg-review-card"
  >
    <!-- Guillemet déco -->
    <div style="position:absolute; bottom:-16px; right:16px; font-size:100px; line-height:1; color:rgba(201,168,76,0.07); font-family:'Syne',sans-serif; font-weight:800; pointer-events:none; user-select:none;">"</div>

    <!-- Étoiles -->
    <div style="display:flex; gap:3px; position:relative; z-index:1;">
      <PhStar v-for="i in 5" :key="i" style="width:15px; height:15px;" :style="i <= review.rating ? 'color:#C9A84C;' : 'color:rgba(13,27,42,0.1);'" weight="fill" />
    </div>

    <!-- Commentaire -->
    <p style="font-size:14px; color:rgba(13,27,42,0.65); line-height:1.75; flex:1; font-style:italic; margin:0; position:relative; z-index:1;">
      "{{ review.comment }}"
    </p>

    <!-- Tag formation -->
    <div v-if="review.formation" style="display:inline-flex; align-items:center; gap:6px; background:rgba(201,168,76,0.08); border:1px solid rgba(201,168,76,0.18); padding:5px 10px; border-radius:8px; width:fit-content; position:relative; z-index:1;">
      <PhGraduationCap style="width:11px; height:11px; color:#C9A84C;" weight="fill" />
      <span style="font-size:11px; font-weight:600; color:#A07828; max-width:180px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ review.formation.title }}</span>
    </div>

    <div style="height:1px; background:rgba(13,27,42,0.06); position:relative; z-index:1;" />

    <!-- Reviewer -->
    <div style="display:flex; align-items:center; gap:12px; position:relative; z-index:1;">
      <div style="width:40px; height:40px; border-radius:50%; background:linear-gradient(135deg,#C9A84C,#E2C97E); display:flex; align-items:center; justify-content:center; flex-shrink:0; font-family:'Syne',sans-serif; font-size:15px; font-weight:800; color:#0D1B2A; border:2px solid rgba(201,168,76,0.2);">
        {{ review.reviewer_name.charAt(0).toUpperCase() }}
      </div>
      <div style="flex:1; min-width:0;">
        <div style="font-family:'Syne',sans-serif; font-size:14px; font-weight:700; color:#0D1B2A; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ review.reviewer_name }}</div>
        <div v-if="review.reviewer_job" style="font-size:12px; color:rgba(13,27,42,0.4); overflow:hidden; text-overflow:ellipsis; white-space:nowrap; margin-top:1px;">{{ review.reviewer_job }}</div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { PhStar, PhGraduationCap } from '@phosphor-icons/vue'
defineProps({ review: { type: Object, required: true } })
</script>

<style scoped>
.wg-review-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 16px 40px rgba(13,27,42,0.1);
  border-color: rgba(201,168,76,0.2) !important;
}
</style>