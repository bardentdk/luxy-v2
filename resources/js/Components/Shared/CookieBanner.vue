<template>
  <Teleport to="body">
    <Transition name="cookie">
      <div
        v-if="showBanner"
        class="fixed bottom-6 left-6 right-6 md:left-auto md:right-6 md:max-w-md z-[9990] bg-[#0D1B2A] text-white rounded-2xl p-6 shadow-2xl border border-white/10"
      >
        <div class="flex items-start gap-4 mb-4 p-10">
          <div class="w-10 h-10 rounded-xl bg-[#C9A84C]/20 flex items-center justify-center flex-shrink-0">
            <PhCookie class="w-5 h-5 text-[#C9A84C]" weight="fill" />
          </div>
          <div>
            <h3 class="font-bold text-white text-sm mb-1">Gestion des cookies</h3>
            <p class="text-white/60 text-xs leading-relaxed">
              Nous utilisons des cookies pour améliorer votre expérience.
              <Link :href="route('politique-cookies')" class="text-[#C9A84C] hover:underline">En savoir plus</Link>
            </p>
          </div>
        </div>

        <div class="flex gap-3">
          <button
            @click="acceptAll"
            class="flex-1 btn-primary text-sm py-2.5 justify-center"
          >
            Tout accepter
          </button>
          <button
            @click="rejectAll"
            class="flex-1 bg-white/10 hover:bg-white/20 text-white text-sm font-medium py-2.5 px-4 rounded-full transition-colors"
          >
            Refuser
          </button>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { PhCookie } from '@phosphor-icons/vue'

const showBanner = ref(false)

onMounted(() => {
  if (!localStorage.getItem('luxy_cookie_consent')) {
    setTimeout(() => { showBanner.value = true }, 2000)
  }
})

function acceptAll() {
  localStorage.setItem('luxy_cookie_consent', JSON.stringify({ analytics: true, marketing: true }))
  showBanner.value = false
}

function rejectAll() {
  localStorage.setItem('luxy_cookie_consent', JSON.stringify({ analytics: false, marketing: false }))
  showBanner.value = false
}
</script>

<style scoped>
.cookie-enter-active, .cookie-leave-active { transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
.cookie-enter-from, .cookie-leave-to { opacity: 0; transform: translateY(20px); }
</style>