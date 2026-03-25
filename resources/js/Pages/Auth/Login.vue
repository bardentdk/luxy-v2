<template>
  <div class="min-h-screen bg-[#0D1B2A] flex items-center justify-center p-6">
    <!-- Fond décoratif -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute top-0 right-0 w-96 h-96 rounded-full bg-[#C9A84C]/10 blur-[120px]" />
      <div class="absolute bottom-0 left-0 w-72 h-72 rounded-full bg-[#1A2D42] blur-[100px]" />
    </div>

    <div class="relative z-10 w-full max-w-md">
      <!-- Logo -->
      <div class="text-center mb-10">
        <Link :href="route('home')" class="inline-flex flex-col items-center gap-3">
          <div class="w-16 h-16 rounded-2xl bg-[#C9A84C] flex items-center justify-center shadow-[0_4px_32px_rgba(201,168,76,0.4)]">
            <span class="text-[#0D1B2A] font-black text-3xl">L</span>
          </div>
          <div>
            <span class="text-white font-extrabold text-xl block">Luxy Coaching & Formation</span>
            <span class="text-[#C9A84C] text-xs tracking-[0.2em] uppercase">Espace administrateur</span>
          </div>
        </Link>
      </div>

      <!-- Carte de connexion -->
      <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 shadow-[0_24px_80px_rgba(0,0,0,0.4)]">
        <h1 class="text-white font-extrabold text-2xl mb-2">Connexion</h1>
        <p class="text-white/50 text-sm mb-8">Accédez à votre espace d'administration.</p>

        <form @submit.prevent="submit" class="flex flex-col gap-5">
          <!-- Email -->
          <div>
            <label class="block text-white/70 text-sm font-medium mb-2">Adresse email</label>
            <div class="relative">
              <PhEnvelopeSimple class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-white/30" />
              <input
                v-model="form.email"
                type="email"
                autocomplete="email"
                required
                placeholder="votre@email.re"
                class="w-full bg-white/10 border rounded-xl py-3.5 pl-12 pr-4 text-white placeholder-white/30 text-sm transition-all focus:outline-none focus:ring-2 focus:ring-[#C9A84C]/50"
                :class="form.errors.email ? 'border-red-400' : 'border-white/20 focus:border-[#C9A84C]/60'"
              />
            </div>
            <p v-if="form.errors.email" class="text-red-400 text-xs mt-1.5">{{ form.errors.email }}</p>
          </div>

          <!-- Mot de passe -->
          <div>
            <label class="block text-white/70 text-sm font-medium mb-2">Mot de passe</label>
            <div class="relative">
              <PhLock class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-white/30" />
              <input
                v-model="form.password"
                :type="showPassword ? 'text' : 'password'"
                autocomplete="current-password"
                required
                placeholder="••••••••"
                class="w-full bg-white/10 border rounded-xl py-3.5 pl-12 pr-12 text-white placeholder-white/30 text-sm transition-all focus:outline-none focus:ring-2 focus:ring-[#C9A84C]/50"
                :class="form.errors.password ? 'border-red-400' : 'border-white/20 focus:border-[#C9A84C]/60'"
              />
              <button
                type="button"
                @click="showPassword = !showPassword"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-white/30 hover:text-white/60 transition-colors"
              >
                <PhEye v-if="showPassword" class="w-5 h-5" />
                <PhEyeSlash v-else class="w-5 h-5" />
              </button>
            </div>
            <p v-if="form.errors.password" class="text-red-400 text-xs mt-1.5">{{ form.errors.password }}</p>
          </div>

          <!-- Se souvenir de moi -->
          <label class="flex items-center gap-3 cursor-pointer">
            <input
              v-model="form.remember"
              type="checkbox"
              class="w-4 h-4 accent-[#C9A84C] rounded"
            />
            <span class="text-white/60 text-sm">Se souvenir de moi</span>
          </label>

          <button
            type="submit"
            :disabled="form.processing"
            class="btn-primary w-full py-4 justify-center text-base mt-2"
          >
            <PhCircleNotch v-if="form.processing" class="w-5 h-5 animate-spin" />
            <PhSignIn v-else class="w-5 h-5" />
            {{ form.processing ? 'Connexion...' : 'Se connecter' }}
          </button>
        </form>
      </div>

      <div class="text-center mt-8">
        <Link :href="route('home')" class="text-white/30 hover:text-white/60 text-sm transition-colors flex items-center justify-center gap-2">
          <PhArrowLeft class="w-4 h-4" />
          Retour au site
        </Link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import {
  PhEnvelopeSimple, PhLock, PhEye, PhEyeSlash,
  PhSignIn, PhCircleNotch, PhArrowLeft,
} from '@phosphor-icons/vue'

const showPassword = ref(false)

const form = useForm({
  email:    '',
  password: '',
  remember: false,
})

function submit() {
  form.post(route('auth.login.post'), {
    onFinish: () => {
      form.reset('password')
    },
  })
}
</script>