<template>
  <AdminLayout>
    <Head title="Mon profil" />

    <div style="max-width:700px; display:flex; flex-direction:column; gap:24px;">

      <div>
        <h1 style="font-size:24px; font-weight:900; color:#0D1B2A; letter-spacing:-0.02em;">Mon profil</h1>
        <p style="font-size:14px; color:rgba(13,27,42,0.45); margin-top:4px;">Gérez vos informations personnelles et votre mot de passe</p>
      </div>

      <!-- Avatar -->
      <div style="background:white; border-radius:20px; padding:28px; box-shadow:0 1px 8px rgba(13,27,42,0.06);">
        <h2 style="font-size:15px; font-weight:800; color:#0D1B2A; margin-bottom:24px;">Photo de profil</h2>
        <div style="display:flex; align-items:center; gap:24px;">
          <div style="position:relative;">
            <img
              :src="avatarPreview ?? user.avatar_url"
              :alt="user.full_name"
              style="width:96px; height:96px; border-radius:50%; object-fit:cover; border:3px solid rgba(201,168,76,0.3);"
            />
            <button
              @click="$refs.avatarInput.click()"
              style="position:absolute; bottom:0; right:0; width:28px; height:28px; border-radius:50%; background:#0D1B2A; border:2px solid white; display:flex; align-items:center; justify-content:center; cursor:pointer;"
            >
              <PhCamera style="width:13px; height:13px; color:white;" />
            </button>
            <input ref="avatarInput" type="file" accept="image/*" style="display:none;" @change="handleAvatarChange" />
          </div>
          <div>
            <div style="font-size:18px; font-weight:800; color:#0D1B2A;">{{ user.full_name }}</div>
            <div style="font-size:13px; color:rgba(13,27,42,0.45); margin-top:2px;">{{ user.email }}</div>
            <button @click="$refs.avatarInput.click()" style="display:inline-flex; align-items:center; gap:6px; margin-top:10px; padding:8px 14px; border-radius:8px; border:1.5px solid rgba(13,27,42,0.12); background:transparent; font-size:13px; font-weight:600; color:rgba(13,27,42,0.6); cursor:pointer; font-family:inherit;" class="change-avatar-btn">
              <PhUpload style="width:14px; height:14px;" />
              Changer la photo
            </button>
          </div>
        </div>
      </div>

      <!-- Informations personnelles -->
      <div style="background:white; border-radius:20px; padding:28px; box-shadow:0 1px 8px rgba(13,27,42,0.06);">
        <h2 style="font-size:15px; font-weight:800; color:#0D1B2A; margin-bottom:24px;">Informations personnelles</h2>
        <form @submit.prevent="submit" style="display:flex; flex-direction:column; gap:18px;">

          <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
            <div>
              <label class="form-label">Prénom <span style="color:#C9A84C;">*</span></label>
              <input v-model="form.first_name" type="text" required class="form-input" :class="{ error: form.errors.first_name }" />
              <p v-if="form.errors.first_name" class="form-error">{{ form.errors.first_name }}</p>
            </div>
            <div>
              <label class="form-label">Nom <span style="color:#C9A84C;">*</span></label>
              <input v-model="form.last_name" type="text" required class="form-input" :class="{ error: form.errors.last_name }" />
              <p v-if="form.errors.last_name" class="form-error">{{ form.errors.last_name }}</p>
            </div>
          </div>

          <div>
            <label class="form-label">Email <span style="color:#C9A84C;">*</span></label>
            <input v-model="form.email" type="email" required class="form-input" :class="{ error: form.errors.email }" />
            <p v-if="form.errors.email" class="form-error">{{ form.errors.email }}</p>
          </div>

          <div>
            <label class="form-label">Téléphone</label>
            <input v-model="form.phone" type="tel" placeholder="+262 692 00 00 00" class="form-input" />
          </div>

          <div style="padding-top:16px; border-top:1.5px solid rgba(13,27,42,0.06);">
            <h3 style="font-size:14px; font-weight:800; color:#0D1B2A; margin-bottom:16px;">Changer le mot de passe</h3>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
              <div>
                <label class="form-label">Nouveau mot de passe</label>
                <input v-model="form.password" type="password" placeholder="Laisser vide pour ne pas changer" class="form-input" :class="{ error: form.errors.password }" />
                <p v-if="form.errors.password" class="form-error">{{ form.errors.password }}</p>
              </div>
              <div>
                <label class="form-label">Confirmer le mot de passe</label>
                <input v-model="form.password_confirmation" type="password" placeholder="Confirmer le nouveau mot de passe" class="form-input" />
              </div>
            </div>
          </div>

          <div style="display:flex; justify-content:flex-end; padding-top:8px;">
            <button
              type="submit"
              :disabled="form.processing"
              style="display:inline-flex; align-items:center; gap:8px; padding:12px 28px; border-radius:12px; border:none; background:#0D1B2A; color:white; font-size:14px; font-weight:700; cursor:pointer; font-family:inherit; transition:all 0.2s;"
              class="submit-btn"
            >
              <PhCircleNotch v-if="form.processing" style="width:16px; height:16px;" class="spin" />
              <PhFloppyDisk v-else style="width:16px; height:16px;" />
              {{ form.processing ? 'Enregistrement...' : 'Sauvegarder' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { PhCamera, PhUpload, PhCircleNotch, PhFloppyDisk } from '@phosphor-icons/vue'

const props = defineProps({ user: Object })

const avatarPreview = ref(null)

const form = useForm({
  first_name:            props.user.first_name ?? '',
  last_name:             props.user.last_name  ?? '',
  email:                 props.user.email      ?? '',
  phone:                 props.user.phone      ?? '',
  password:              '',
  password_confirmation: '',
  avatar:                null,
})

function handleAvatarChange(e) {
  const file = e.target.files[0]
  if (!file) return
  form.avatar    = file
  avatarPreview.value = URL.createObjectURL(file)
}

function submit() {
  form.put(route('admin.profile.update'), { forceFormData: true })
}
</script>

<style scoped>
.form-label { display:block; font-size:13px; font-weight:700; color:#0D1B2A; margin-bottom:8px; }
.form-input { width:100%; padding:12px 14px; border:1.5px solid rgba(13,27,42,0.12); border-radius:12px; font-size:14px; color:#0D1B2A; outline:none; font-family:inherit; background:#FAF7F2; transition:border-color 0.2s; box-sizing:border-box; }
.form-input:focus { border-color:rgba(201,168,76,0.6); background:white; }
.form-input.error { border-color:#EF4444; }
.form-error { font-size:12px; color:#EF4444; margin-top:5px; }
.submit-btn:hover:not(:disabled) { background:#1A2D42 !important; transform:translateY(-1px); }
.change-avatar-btn:hover { background:#FAF7F2; color:#0D1B2A !important; }
.spin { animation:spin 1s linear infinite; }
@keyframes spin { to { transform:rotate(360deg); } }
</style>