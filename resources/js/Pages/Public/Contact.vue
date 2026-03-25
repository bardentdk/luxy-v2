<template>
  <PublicLayout>
    <Head title="Contactez-nous" />

    <!-- Hero -->
    <section style="position:relative; background:white; padding:140px 0 80px; overflow:hidden;">
      <div style="position:absolute; top:-200px; right:-200px; width:700px; height:700px; border-radius:50%; background:radial-gradient(circle, rgba(201,168,76,0.08) 0%, transparent 65%); pointer-events:none;" />
      <div style="position:absolute; left:0; top:20%; bottom:20%; width:3px; background:linear-gradient(to bottom, transparent, #C9A84C 40%, #E2C97E 60%, transparent); border-radius:2px;" />

      <div style="max-width:1400px; margin:0 auto; padding:0 3rem; position:relative; z-index:1;">
        <div data-reveal style="display:inline-flex; align-items:center; gap:8px; background:rgba(201,168,76,0.08); border:1px solid rgba(201,168,76,0.22); border-radius:100px; padding:6px 14px; margin-bottom:24px;">
          <PhEnvelope style="width:13px; height:13px; color:#C9A84C;" />
          <span style="font-size:11px; font-weight:700; color:#A07828; letter-spacing:0.08em; text-transform:uppercase;">Contactez-nous</span>
        </div>
        <h1 data-reveal style="font-family:'Syne',sans-serif; font-size:clamp(44px,6vw,80px); font-weight:800; color:#0D1B2A; letter-spacing:-0.04em; line-height:1; margin:0 0 20px;">
          Parlons de<br><span class="text-gradient-gold">votre projet</span>
        </h1>
        <p data-reveal style="--delay:0.1s; font-size:18px; color:rgba(13,27,42,0.5); max-width:500px; line-height:1.75; margin:0;">
          Vous avez une question ou un projet de formation ? Notre équipe vous répond rapidement.
        </p>
      </div>
    </section>

    <!-- Contenu -->
    <section style="background:#FAF8F3; padding:60px 0 100px;">
      <div style="max-width:1400px; margin:0 auto; padding:0 3rem;">
        <div style="display:grid; grid-template-columns:1fr 1.6fr; gap:80px; align-items:start;">

          <!-- Infos -->
          <div>
            <h2 style="font-family:'Syne',sans-serif; font-size:22px; font-weight:800; color:#0D1B2A; letter-spacing:-0.02em; margin-bottom:28px;">Nos coordonnées</h2>

            <div style="display:flex; flex-direction:column; gap:16px; margin-bottom:40px;">
              <div v-for="info in contactInfos" :key="info.label" style="display:flex; align-items:flex-start; gap:16px; padding:22px; background:white; border-radius:20px; border:1.5px solid rgba(13,27,42,0.07); transition:all 0.25s;" class="info-card">
                <div style="width:46px; height:46px; border-radius:14px; background:rgba(201,168,76,0.1); border:1px solid rgba(201,168,76,0.2); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                  <component :is="info.icon" style="width:21px; height:21px; color:#C9A84C;" weight="fill" />
                </div>
                <div>
                  <div style="font-size:11px; font-weight:700; color:rgba(13,27,42,0.35); letter-spacing:0.08em; text-transform:uppercase; margin-bottom:4px; font-family:'Syne',sans-serif;">{{ info.label }}</div>
                  <a v-if="info.href" :href="info.href" style="font-size:15px; font-weight:600; color:#0D1B2A; text-decoration:none; transition:color 0.2s;" class="info-link">{{ info.value }}</a>
                  <div v-else style="font-size:15px; font-weight:600; color:#0D1B2A; line-height:1.5;">{{ info.value }}</div>
                </div>
              </div>
            </div>

            <!-- Horaires -->
            <div style="background:white; border-radius:20px; padding:28px; border:1.5px solid rgba(13,27,42,0.07);">
              <h3 style="font-family:'Syne',sans-serif; font-size:16px; font-weight:800; color:#0D1B2A; margin-bottom:20px; display:flex; align-items:center; gap:10px; letter-spacing:-0.01em;">
                <PhClock style="width:17px; height:17px; color:#C9A84C;" weight="fill" />Horaires d'ouverture
              </h3>
              <div style="display:flex; flex-direction:column; gap:10px;">
                <div v-for="h in horaires" :key="h.day" style="display:flex; justify-content:space-between; font-size:14px; padding:8px 0; border-bottom:1px solid rgba(13,27,42,0.05);">
                  <span style="color:rgba(13,27,42,0.55);">{{ h.day }}</span>
                  <span style="font-weight:700; color:#0D1B2A; font-family:'Syne',sans-serif;" :style="h.closed ? 'color:rgba(13,27,42,0.35);' : ''">{{ h.hours }}</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Formulaire -->
          <div style="background:white; border-radius:28px; padding:52px; box-shadow:0 8px 48px rgba(13,27,42,0.08); border:1.5px solid rgba(201,168,76,0.12);">

            <!-- Ligne déco top -->
            <div style="height:3px; background:linear-gradient(90deg,#C9A84C,#E2C97E); border-radius:2px; margin-bottom:36px;" />

            <h2 style="font-family:'Syne',sans-serif; font-size:24px; font-weight:800; color:#0D1B2A; letter-spacing:-0.025em; margin-bottom:6px;">Envoyez-nous un message</h2>
            <p style="font-size:14px; color:rgba(13,27,42,0.45); margin-bottom:32px; line-height:1.6;">Nous vous répondons dans les 24h ouvrées.</p>

            <form @submit.prevent="submit" style="display:flex; flex-direction:column; gap:20px;">

              <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div>
                  <label class="form-label">Nom complet <span style="color:#C9A84C;">*</span></label>
                  <input v-model="form.full_name" type="text" placeholder="Jean Dupont" required class="form-inp" :class="{'form-inp-err':form.errors.full_name}" />
                  <p v-if="form.errors.full_name" class="form-err-msg">{{ form.errors.full_name }}</p>
                </div>
                <div>
                  <label class="form-label">Email <span style="color:#C9A84C;">*</span></label>
                  <input v-model="form.email" type="email" placeholder="jean@exemple.re" required class="form-inp" :class="{'form-inp-err':form.errors.email}" />
                  <p v-if="form.errors.email" class="form-err-msg">{{ form.errors.email }}</p>
                </div>
              </div>

              <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div>
                  <label class="form-label">Téléphone</label>
                  <input v-model="form.phone" type="tel" placeholder="+262 692 00 00 00" class="form-inp" />
                </div>
                <div>
                  <label class="form-label">Formation intéressée</label>
                  <input v-model="form.formation_interest" type="text" placeholder="Ex: Développeur Web" class="form-inp" />
                </div>
              </div>

              <div>
                <label class="form-label">Objet <span style="color:#C9A84C;">*</span></label>
                <input v-model="form.subject" type="text" placeholder="Demande d'information" required class="form-inp" :class="{'form-inp-err':form.errors.subject}" />
                <p v-if="form.errors.subject" class="form-err-msg">{{ form.errors.subject }}</p>
              </div>

              <div>
                <label class="form-label">Message <span style="color:#C9A84C;">*</span></label>
                <textarea v-model="form.message" rows="5" placeholder="Décrivez votre demande..." required class="form-inp" style="resize:vertical; min-height:120px;" :class="{'form-inp-err':form.errors.message}" />
                <p v-if="form.errors.message" class="form-err-msg">{{ form.errors.message }}</p>
              </div>

              <label style="display:flex; align-items:flex-start; gap:12px; cursor:none;">
                <input v-model="form.accept_rgpd" type="checkbox" required style="width:18px; height:18px; margin-top:2px; accent-color:#C9A84C; flex-shrink:0;" />
                <span style="font-size:13px; color:rgba(13,27,42,0.5); line-height:1.65;">
                  J'accepte que mes données soient utilisées pour traiter ma demande, conformément à notre <Link :href="route('politique-confidentialite')" style="color:#C9A84C; text-decoration:none; font-weight:600;">politique de confidentialité</Link>.
                </span>
              </label>
              <p v-if="form.errors.accept_rgpd" class="form-err-msg">{{ form.errors.accept_rgpd }}</p>

              <button type="submit" :disabled="form.processing" class="btn-gold" style="justify-content:center; margin-top:4px; border:none; width:100%;">
                <PhCircleNotch v-if="form.processing" style="width:17px; height:17px;" class="spin" />
                <PhPaperPlaneTilt v-else style="width:17px; height:17px;" />
                {{ form.processing ? 'Envoi en cours...' : 'Envoyer le message' }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import PublicLayout from '@/Layouts/PublicLayout.vue'
import { PhEnvelope, PhMapPin, PhPhone, PhClock, PhPaperPlaneTilt, PhCircleNotch } from '@phosphor-icons/vue'

const form = useForm({ full_name:'', email:'', phone:'', subject:'', message:'', formation_interest:'', accept_rgpd:false })
function submit() { form.post(route('contact.store'), { onSuccess: () => form.reset() }) }

const contactInfos = [
  { icon: PhMapPin,  label: 'Adresse',   value: '123 Rue de la Formation, 97400 Saint-Denis, La Réunion', href: null },
  { icon: PhPhone,   label: 'Téléphone', value: '+262 262 00 00 00',         href: 'tel:+262262000000' },
  { icon: PhEnvelope,label: 'Email',     value: 'contact@luxyformation.re',  href: 'mailto:contact@luxyformation.re' },
]
const horaires = [
  { day: 'Lundi — Vendredi', hours: '08h00 — 17h00', closed: false },
  { day: 'Samedi',           hours: '08h30 — 12h00', closed: false },
  { day: 'Dimanche',         hours: 'Fermé',          closed: true },
]
</script>

<style scoped>
.info-card:hover  { box-shadow:0 4px 20px rgba(13,27,42,0.07); transform:translateY(-2px); border-color:rgba(201,168,76,0.2) !important; }
.info-link:hover  { color:#C9A84C !important; }
.form-label { display:block; font-size:12px; font-weight:700; color:#0D1B2A; margin-bottom:8px; font-family:'Syne',sans-serif; letter-spacing:0.02em; }
.form-inp   { width:100%; padding:12px 14px; border:1.5px solid rgba(13,27,42,0.12); border-radius:12px; font-size:14px; color:#0D1B2A; outline:none; font-family:inherit; background:#FAF8F3; transition:all 0.2s; box-sizing:border-box; }
.form-inp:focus { border-color:rgba(201,168,76,0.5); background:white; }
.form-inp-err { border-color:#EF4444 !important; }
.form-err-msg { font-size:12px; color:#EF4444; margin-top:5px; }
.spin { animation:spin 1s linear infinite; }
@keyframes spin { to { transform:rotate(360deg); } }
</style>