<template>
  <div style="position:relative; width:100%; height:200px;">
    <canvas v-if="hasData" ref="chartRef" style="width:100% !important; height:200px !important;" />
    <div v-else style="display:flex; flex-direction:column; align-items:center; justify-content:center; height:200px; color:rgba(13,27,42,0.25);">
      <PhChartLine style="width:36px; height:36px; margin-bottom:10px;" />
      <span style="font-size:12px; font-weight:600;">Aucune donnée pour l'instant</span>
      <span style="font-size:11px; margin-top:3px; opacity:0.7;">Les données apparaîtront dans 24h</span>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { PhChartLine } from '@phosphor-icons/vue'

const props = defineProps({
  data: { type: Object, default: () => ({}) },
})

const chartRef = ref(null)
const hasData  = computed(() => Object.keys(props.data ?? {}).length > 0)

onMounted(async () => {
  if (!hasData.value || !chartRef.value) return

  const { Chart, registerables } = await import('chart.js')
  Chart.register(...registerables)

  const labels = Object.keys(props.data)
  const values = Object.values(props.data)
  const ctx    = chartRef.value.getContext('2d')

  // Gradient fill
  const gradient = ctx.createLinearGradient(0, 0, 0, 200)
  gradient.addColorStop(0,   'rgba(201, 168, 76, 0.18)')
  gradient.addColorStop(0.6, 'rgba(201, 168, 76, 0.04)')
  gradient.addColorStop(1,   'rgba(201, 168, 76, 0.0)')

  new Chart(ctx, {
    type: 'line',
    data: {
      labels,
      datasets: [{
        data:             values,
        borderColor:      '#C9A84C',
        backgroundColor:  gradient,
        borderWidth:      2,
        fill:             true,
        tension:          0.45,
        pointBackgroundColor: '#C9A84C',
        pointBorderColor:     'white',
        pointBorderWidth:     2,
        pointRadius:          3,
        pointHoverRadius:     6,
        pointHoverBorderWidth: 2,
      }],
    },
    options: {
      responsive:          true,
      maintainAspectRatio: false,
      interaction:         { intersect: false, mode: 'index' },
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor:  '#0D1B2A',
          titleColor:       'rgba(255,255,255,0.5)',
          bodyColor:        'white',
          borderColor:      'rgba(201,168,76,0.3)',
          borderWidth:      1,
          cornerRadius:     10,
          padding:          10,
          displayColors:    false,
          titleFont:        { size: 11 },
          bodyFont:         { size: 14, weight: '700' },
          callbacks: {
            label: (item) => `${item.parsed.y.toLocaleString()} vues`,
          },
        },
      },
      scales: {
        x: {
          grid:  { display: false },
          border:{ display: false },
          ticks: {
            color:         'rgba(13,27,42,0.35)',
            font:          { size: 11, weight: '500' },
            maxTicksLimit: 7,
            maxRotation:   0,
          },
        },
        y: {
          grid:   { color: 'rgba(13,27,42,0.04)' },
          border: { display: false },
          ticks: {
            color:    'rgba(13,27,42,0.35)',
            font:     { size: 11 },
            callback: (v) => v === 0 ? '0' : v.toLocaleString(),
          },
        },
      },
    },
  })
})
</script>