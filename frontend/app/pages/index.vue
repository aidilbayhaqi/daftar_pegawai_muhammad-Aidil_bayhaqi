<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-sm bg-white p-6 rounded shadow">
      <h1 class="text-2xl font-bold mb-6 text-center">Login Karyawan</h1>

      <form @submit.prevent="handleLogin" class="space-y-4">
        <div>
          <label class="block mb-1 font-semibold">Email</label>
          <input
            v-model="form.email"
            type="email"
            placeholder="Masukkan email"
            class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-300"
          />
        </div>

        <div>
          <label class="block mb-1 font-semibold">Password</label>
          <input
            v-model="form.password"
            type="password"
            placeholder="Masukkan password"
            class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-300"
          />
        </div>

        <button
          type="submit"
          class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700"
          :disabled="loading"
        >
          {{ loading ? 'Loading...' : 'Login' }}
        </button>
      </form>

      <p class="mt-4 text-sm text-center">
        Belum punya akun?
        <a href="/register" class="text-blue-600 underline">Daftar</a>
      </p>

      <p v-if="errorMessage" class="mt-2 text-red-600 text-sm text-center">
        {{ errorMessage }}
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { authService } from '~/services/useAuth'

const router = useRouter()
const form = ref({
  email: '',
  password: ''
})
const loading = ref(false)
const errorMessage = ref('')

async function handleLogin() {
  loading.value = true
  errorMessage.value = ''
  try {
    const res = await authService.login(form.value)
    // Simpan token ke localStorage
    localStorage.setItem('token', res.access_token)
    alert('Login berhasil!')
    router.push('/dashboard') 
  } catch (err) {
    console.error(err)
    errorMessage.value = 'Email atau password salah'
  } finally {
    loading.value = false
  }
}
</script>
