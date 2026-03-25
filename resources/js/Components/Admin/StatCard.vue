<template>
  <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
    <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" :class="card.color">
      <component :is="card.icon" class="w-6 h-6" weight="fill" />
    </div>
    <div>
      <div class="text-2xl font-extrabold text-[#0D1B2A]">{{ card.value?.toLocaleString() ?? 0 }}</div>
      <div class="text-[#0D1B2A]/50 text-sm">{{ card.label }}</div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  card: { type: Object, required: true },
})
</script>