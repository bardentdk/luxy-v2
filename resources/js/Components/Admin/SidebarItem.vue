<template>
  <Link
    :href="route(item.route)"
    style="display:flex; align-items:center; border-radius:10px; text-decoration:none; font-size:13px; font-weight:600; transition:all 0.2s; position:relative; overflow:hidden; white-space:nowrap;"
    :style="{
      padding: collapsed ? '10px' : '10px 12px',
      justifyContent: collapsed ? 'center' : 'flex-start',
      gap: collapsed ? '0' : '10px',
      background: active ? 'rgba(201,168,76,0.15)' : 'transparent',
      color: active ? '#C9A84C' : 'rgba(255,255,255,0.5)',
    }"
    class="nav-item"
    :class="{ 'nav-item-active': active }"
  >
    <!-- Indicateur actif -->
    <div
      v-if="active"
      style="position:absolute; left:0; top:50%; transform:translateY(-50%); width:3px; height:60%; border-radius:0 3px 3px 0; background:#C9A84C;"
    />

    <!-- Icône -->
    <component
      :is="item.icon"
      style="flex-shrink:0; transition:transform 0.2s;"
      :style="{ width: '17px', height: '17px' }"
      :weight="active ? 'fill' : 'regular'"
    />

    <!-- Label avec tooltip si collapsed -->
    <Transition name="label">
      <span v-if="!collapsed" style="flex:1; overflow:hidden; text-overflow:ellipsis;">
        {{ item.name }}
      </span>
    </Transition>

    <!-- Badge -->
    <Transition name="label">
      <span
        v-if="item.badge && !collapsed"
        style="font-size:10px; font-weight:800; padding:2px 7px; border-radius:100px; background:#C9A84C; color:#0D1B2A; flex-shrink:0;"
      >
        {{ item.badge }}
      </span>
    </Transition>

    <!-- Tooltip sur mode collapsed -->
    <div v-if="collapsed" class="tooltip">{{ item.name }}</div>
  </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

defineProps({
  item:      { type: Object,  required: true },
  active:    { type: Boolean, default: false },
  collapsed: { type: Boolean, default: false },
})
</script>

<style scoped>
.nav-item:not(.nav-item-active):hover {
  background: rgba(255,255,255,0.07) !important;
  color: white !important;
}
.nav-item-active:hover { background: rgba(201,168,76,0.2) !important; }

.label-enter-active { transition: opacity 0.15s ease 0.1s; }
.label-leave-active { transition: opacity 0.08s ease; }
.label-enter-from, .label-leave-to { opacity: 0; }

/* Tooltip pour mode icône seule */
.tooltip {
  position: absolute;
  left: calc(100% + 12px);
  top: 50%;
  transform: translateY(-50%);
  background: #0D1B2A;
  color: white;
  font-size: 12px;
  font-weight: 600;
  padding: 6px 10px;
  border-radius: 8px;
  white-space: nowrap;
  pointer-events: none;
  opacity: 0;
  transition: opacity 0.2s ease 0.3s;
  border: 1px solid rgba(255,255,255,0.1);
  z-index: 100;
}
.nav-item:hover .tooltip { opacity: 1; }
</style>