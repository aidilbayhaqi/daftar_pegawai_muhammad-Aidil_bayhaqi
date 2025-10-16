<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-md">
      <h1 class="text-2xl font-bold mb-6 text-center text-green-600">
        Register Pegawai
      </h1>

      <form @submit.prevent="handleRegister" class="space-y-4">
        <!-- Nama -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
          <input
            v-model="form.name"
            type="text"
            placeholder="Masukkan nama lengkap"
            required
            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
          />
        </div>

        <!-- Email -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input
            v-model="form.email"
            type="email"
            placeholder="Masukkan email"
            required
            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
          />
        </div>

        <!-- Password -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
          <input
            v-model="form.password"
            type="password"
            placeholder="Masukkan password"
            required
            minlength="6"
            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
          />
        </div>

        <button
          type="submit"
          class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition-colors"
        >
          Daftar
        </button>
      </form>

      <p class="text-center text-sm mt-4">
        Sudah punya akun?
        <NuxtLink to="/login" class="text-green-600 hover:underline">
          Login di sini
        </NuxtLink>
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { authService } from '~/services/useAuth'
import axios from 'axios'

const router = useRouter()
const form = ref({
  name: '',
  email: '',
  password: ''
})

const handleRegister = async () => {
  try {
    const res = await authService.register(form.value)
    alert('Registrasi berhasil! Silakan login.')
    router.push('/')
  } catch (error) {
    console.error('Gagal register:', error)
    if (error.response?.data?.errors) {
      const msg = Object.values(error.response.data.errors).flat().join('\n')
      alert(msg)
    } else {
      alert('Terjadi kesalahan saat registrasi.')
    }
  }
}
</script>
