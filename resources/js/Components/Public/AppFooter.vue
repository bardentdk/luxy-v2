<template>
  <footer style="background:#0D1B2A; position:relative; overflow:hidden;">

    <div style="position:absolute; bottom:0; left:50%; transform:translateX(-50%); width:900px; height:400px; border-radius:50%; background:radial-gradient(circle, rgba(201,168,76,0.08) 0%, transparent 70%); pointer-events:none;" />
    <div style="position:absolute; top:0; left:10%; right:10%; height:1px; background:linear-gradient(90deg,transparent,rgba(201,168,76,0.3),transparent);" />

    <div style="max-width:1400px; margin:0 auto; padding:80px 3rem; position:relative; z-index:1; display:grid; grid-template-columns:1.5fr 1fr 1fr 1.3fr; gap:64px;">

      <!-- Brand -->
      <div>
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
          <!-- <div style="width:38px; height:38px; border-radius:11px; background:linear-gradient(135deg,#C9A84C,#E2C97E); display:flex; align-items:center; justify-content:center; box-shadow:0 4px 16px rgba(201,168,76,0.3);">
            <span style="font-family:'Syne',sans-serif; font-weight:800; font-size:18px; color:#0D1B2A;">L</span>
          </div>
          <div>
            <span style="font-family:'Syne',sans-serif; font-weight:800; font-size:16px; color:white; display:block; line-height:1.1;">Luxy</span>
            <span style="font-size:9px; color:#C9A84C; letter-spacing:0.22em; text-transform:uppercase; display:block; font-weight:700;">Formation</span>
          </div> -->
          <img src="https://luxyformation.re/wp-content/uploads/2024/03/cropped-horizontal_luxy_logo-300x97.png" alt="" class="w-40">

        </div>
        <p style="font-size:14px; color:rgba(255,255,255,0.4); line-height:1.75; margin-bottom:28px; max-width:260px;">
          Centre de formation professionnelle et soutien scolaire à La Réunion.
        </p>
        <div style="display:flex; gap:10px;">
          <a v-for="s in socials" :key="s.name" :href="s.url" target="_blank" rel="noopener" style="width:36px; height:36px; border-radius:10px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.08); display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,0.4); text-decoration:none; transition:all 0.25s;" class="footer-social">
            <component :is="s.icon" style="width:15px; height:15px;" />
          </a>
        </div>
      </div>

      <!-- Navigation -->
      <div>
        <h3 style="font-family:'Syne',sans-serif; font-size:10px; font-weight:700; color:rgba(255,255,255,0.25); letter-spacing:0.2em; text-transform:uppercase; margin-bottom:20px;">Navigation</h3>
        <ul style="list-style:none; display:flex; flex-direction:column; gap:10px;">
          <li v-for="item in navLinks" :key="item.name">
            <Link :href="route(item.route)" style="font-size:14px; color:rgba(255,255,255,0.4); text-decoration:none; display:flex; align-items:center; gap:7px; transition:all 0.2s;" class="footer-nav-link">
              <span style="width:4px; height:4px; border-radius:50%; background:rgba(201,168,76,0.4); flex-shrink:0; transition:all 0.2s;" class="footer-nav-dot" />
              {{ item.name }}
            </Link>
          </li>
        </ul>
      </div>

      <!-- Contact -->
      <div>
        <h3 style="font-family:'Syne',sans-serif; font-size:10px; font-weight:700; color:rgba(255,255,255,0.25); letter-spacing:0.2em; text-transform:uppercase; margin-bottom:20px;">Contact</h3>
        <div style="display:flex; flex-direction:column; gap:14px;">
          <div v-for="info in contactInfos" :key="info.label" style="display:flex; align-items:flex-start; gap:10px;">
            <component :is="info.icon" style="width:15px; height:15px; flex-shrink:0; margin-top:2px; color:#C9A84C;" weight="fill" />
            <a v-if="info.href" :href="info.href" style="font-size:13px; color:rgba(255,255,255,0.4); text-decoration:none; line-height:1.5; transition:color 0.2s;" class="footer-contact-link">{{ info.value }}</a>
            <span v-else style="font-size:13px; color:rgba(255,255,255,0.4); line-height:1.5;">{{ info.value }}</span>
          </div>
        </div>
      </div>

      <!-- Newsletter -->
      <div>
        <h3 style="font-family:'Syne',sans-serif; font-size:10px; font-weight:700; color:rgba(255,255,255,0.25); letter-spacing:0.2em; text-transform:uppercase; margin-bottom:20px;">Newsletter</h3>
        <p style="font-size:13px; color:rgba(255,255,255,0.4); line-height:1.65; margin-bottom:16px;">
          Actualités et nouvelles formations directement dans votre boîte.
        </p>
        <form @submit.prevent="subscribe" style="display:flex; flex-direction:column; gap:10px;">
          <input
            v-model="email"
            type="email"
            placeholder="votre@email.re"
            required
            style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:12px; padding:11px 14px; font-size:13px; color:white; outline:none; font-family:inherit; transition:border-color 0.2s; width:100%; box-sizing:border-box;"
            class="footer-email"
          />
          <button type="submit" :disabled="loading" class="btn-gold" style="justify-content:center; font-size:13px; padding:11px; border:none; width:100%;">
            <PhPaperPlaneTilt style="width:14px; height:14px;" />
            {{ loading ? 'Envoi...' : "S'abonner" }}
          </button>
        </form>
      </div>
    </div>

    <!-- Bottom -->
    <div style="border-top:1px solid rgba(255,255,255,0.06);">
      <div style="max-width:1400px; margin:0 auto; padding:20px 3rem; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px;">
        <p style="font-size:12px; color:rgba(255,255,255,0.2); margin:0;">© {{ year }} Luxy Coaching &amp; Formation — Tous droits réservés</p>
        <nav style="display:flex; flex-wrap:wrap; gap:20px;">
          <Link v-for="p in legalPages" :key="p.name" :href="route(p.route)" style="font-size:12px; color:rgba(255,255,255,0.2); text-decoration:none; transition:color 0.2s;" class="footer-legal">{{ p.name }}</Link>
        </nav>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { PhMapPin, PhPhone, PhEnvelopeSimple, PhPaperPlaneTilt, PhFacebookLogo, PhInstagramLogo, PhLinkedinLogo } from '@phosphor-icons/vue'

const year    = new Date().getFullYear()
const email   = ref('')
const loading = ref(false)

const socials      = [{ name:'Facebook', url:'#', icon:PhFacebookLogo }, { name:'Instagram', url:'#', icon:PhInstagramLogo }, { name:'LinkedIn', url:'#', icon:PhLinkedinLogo }]
const navLinks     = [{ name:'Accueil', route:'home' }, { name:'La vie du centre', route:'articles.index' }, { name:'Nos formations', route:'formations.index' }, { name:'Vos avis', route:'reviews.index' }, { name:'Contact', route:'contact' }]
const contactInfos = [{ icon:PhMapPin, label:'Adresse', value:'123 Rue de la Formation, 97400 Saint-Denis', href:null }, { icon:PhPhone, label:'Téléphone', value:'+262 262 00 00 00', href:'tel:+262262000000' }, { icon:PhEnvelopeSimple, label:'Email', value:'contact@luxyformation.re', href:'mailto:contact@luxyformation.re' }]
const legalPages   = [{ name:'Mentions légales', route:'mentions-legales' }, { name:'CGV', route:'cgv' }, { name:'CGU', route:'cgu' }, { name:'Cookies', route:'politique-cookies' }, { name:'Confidentialité', route:'politique-confidentialite' }]

async function subscribe() { loading.value = true; await new Promise(r => setTimeout(r, 1000)); email.value = ''; loading.value = false }
</script>

<style scoped>
.footer-social:hover      { background:rgba(201,168,76,0.15) !important; border-color:rgba(201,168,76,0.3) !important; color:#C9A84C !important; transform:translateY(-2px); }
.footer-nav-link:hover    { color:white !important; }
.footer-nav-link:hover .footer-nav-dot { background:#C9A84C !important; box-shadow:0 0 8px rgba(201,168,76,0.5); }
.footer-contact-link:hover{ color:rgba(255,255,255,0.7) !important; }
.footer-email:focus       { border-color:rgba(201,168,76,0.4) !important; background:rgba(201,168,76,0.05) !important; }
.footer-legal:hover       { color:rgba(255,255,255,0.5) !important; }
</style>