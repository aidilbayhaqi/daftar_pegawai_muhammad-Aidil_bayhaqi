<template>
  <div class="max-w-xl mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Karyawan</h1>

    <form @submit.prevent="submitForm" class="space-y-4">
      <!-- NIP -->
      <div>
        <label class="block mb-1 font-semibold">NIP</label>
        <input v-model="form.nip" type="text" class="w-full border px-3 py-2 rounded" disabled />
      </div>

      <!-- Nama -->
      <div>
        <label class="block mb-1 font-semibold">Nama</label>
        <input v-model="form.nama" type="text" class="w-full border px-3 py-2 rounded" required />
      </div>

      <!-- Tempat & Tanggal Lahir -->
      <div>
        <label class="block mb-1 font-semibold">Tempat Lahir</label>
        <input v-model="form.tempat_lahir" type="text" class="w-full border px-3 py-2 rounded" required />
      </div>

      <div>
        <label class="block mb-1 font-semibold">Tanggal Lahir</label>
        <input v-model="form.tanggal_lahir" type="date" class="w-full border px-3 py-2 rounded" required />
      </div>

      <!-- Jenis Kelamin -->
      <div>
        <label class="block mb-1 font-semibold">Jenis Kelamin</label>
        <select v-model="form.jenis_kelamin" class="w-full border px-3 py-2 rounded" required>
          <option value="L">Laki-laki</option>
          <option value="P">Perempuan</option>
        </select>
      </div>

      <!-- Alamat -->
      <div>
        <label class="block mb-1 font-semibold">Alamat</label>
        <textarea v-model="form.alamat" class="w-full border px-3 py-2 rounded"></textarea>
      </div>

      <!-- Agama -->
      <div>
        <label class="block mb-1 font-semibold">Agama</label>
        <input v-model="form.agama" type="text" class="w-full border px-3 py-2 rounded" />
      </div>

      <!-- No HP -->
      <div>
        <label class="block mb-1 font-semibold">No HP</label>
        <input v-model="form.no_hp" type="text" class="w-full border px-3 py-2 rounded" />
      </div>

      <!-- NPWP -->
      <div>
        <label class="block mb-1 font-semibold">NPWP</label>
        <input v-model="form.npwp" type="text" class="w-full border px-3 py-2 rounded" />
      </div>

      <!-- Unit -->
      <div>
        <label class="block mb-1 font-semibold">Unit</label>
        <select v-model="form.unit_id" class="w-full border px-3 py-2 rounded">
          <option disabled value="">-- Pilih Unit --</option>
          <option v-for="unit in units" :key="unit.id" :value="unit.id">
            {{ unit.nama_unit }}
          </option>
        </select>
      </div>

      <!-- Jabatan -->
      <div>
        <label class="block mb-1 font-semibold">Jabatan</label>
        <select v-model="form.jabatan_id" class="w-full border px-3 py-2 rounded">
          <option disabled value="">-- Pilih Jabatan --</option>
          <option v-for="jabatan in jabatans" :key="jabatan.id" :value="jabatan.id">
            {{ jabatan.nama_jabatan }}
          </option>
        </select>
      </div>

      <!-- Foto -->
      <div>
        <label class="block mb-1 font-semibold">Foto</label>
        <input type="file" @change="handleFileChange" class="w-full" />
        <div v-if="form.fotoPreview" class="mt-2">
          <img :src="form.fotoPreview" class="h-24 w-24 object-cover rounded" />
        </div>
      </div>

      <!-- Tombol -->
      <button
        type="submit"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
      >
        Simpan Perubahan
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { karyawanService } from '~/services/useKaryawan.js'

const route = useRoute()
const router = useRouter()
const id = route.params.id

const form = ref({
  nip: '',
  nama: '',
  tempat_lahir: '',
  tanggal_lahir: '',
  jenis_kelamin: 'L',
  alamat: '',
  agama: '',
  no_hp: '',
  npwp: '',
  unit_id: '',
  jabatan_id: '',
  foto: null,
  fotoPreview: null,
})

const units = ref([])
const jabatans = ref([])

onMounted(async () => {
  try {
    const data = await karyawanService.getById(id)
    form.value = {
      ...form.value,
      ...data,
      foto: null,
      tanggal_lahir: data.tanggal_lahir?.split('T')[0] || data.tanggal_lahir,
      fotoPreview: data.foto ? `http://127.0.0.1:8000/storage/${data.foto}` : null,
    }

    units.value = await karyawanService.getUnits()
    jabatans.value = await karyawanService.getJabatans()
  } catch (error) {
    console.error('Gagal memuat data:', error)
    alert('Gagal memuat data karyawan')
  }
})

function handleFileChange(e) {
  const file = e.target.files[0]
  if (file) {
    form.value.foto = file
    form.value.fotoPreview = URL.createObjectURL(file)
  }
}

async function submitForm() {
  try {
    const formData = new FormData()
    for (const key in form.value) {
      if (['fotoPreview', 'nip'].includes(key)) continue
      const value = form.value[key]
      if (key === 'foto' && !value) continue
      if (key === 'tanggal_lahir' && value) {
        const date = new Date(value)
        formData.append(key, date.toISOString().split('T')[0])
      } else if (value !== null && value !== undefined) {
        formData.append(key, value)
      }
    }

    formData.append('_method', 'PUT')

    await karyawanService.update(id, formData)
    alert('Data karyawan berhasil diperbarui!')
    router.push('/dashboard')
  } catch (error) {
    console.error('Gagal menyimpan:', error.response?.data || error)
    alert(`Gagal memperbarui: ${JSON.stringify(error.response?.data?.errors || error.response?.data || 'Error')}`)
  }
}
</script>
