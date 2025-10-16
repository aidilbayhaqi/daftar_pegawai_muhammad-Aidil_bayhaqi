<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Tambah / Edit Karyawan</h1>

    <KaryawanForm
      :units="units"
      :jabatans="jabatans"
      @submit="handleSubmit"
      @add-unit="showAddUnit = true"
      @add-jabatan="showAddJabatan = true"
    />

    <!-- Modal Tambah Unit -->
    <div v-if="showAddUnit" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-white p-6 rounded shadow w-96">
        <h2 class="text-lg font-semibold mb-3">Tambah Unit Baru</h2>
        <input v-model="newUnit.nama_unit" placeholder="Nama Unit" class="border w-full p-2 rounded mb-2" />
        <input v-model="newUnit.tempat_tugas" placeholder="Tempat Tugas" class="border w-full p-2 rounded mb-4" />
        <div class="flex justify-end gap-2">
          <button @click="showAddUnit = false" class="bg-gray-400 text-white px-3 py-1 rounded">Batal</button>
          <button @click="createUnit" class="bg-blue-600 text-white px-3 py-1 rounded">Simpan</button>
        </div>
      </div>
    </div>

    <!-- Modal Tambah Jabatan -->
    <div v-if="showAddJabatan" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-white p-6 rounded shadow w-96">
        <h2 class="text-lg font-semibold mb-3">Tambah Jabatan Baru</h2>
        <input v-model="newJabatan.nama_jabatan" placeholder="Nama Jabatan" class="border w-full p-2 rounded mb-2" />
        <input v-model="newJabatan.eselon" placeholder="Eselon" class="border w-full p-2 rounded mb-2" />
        <input v-model="newJabatan.golongan" placeholder="Golongan" class="border w-full p-2 rounded mb-4" />
        <div class="flex justify-end gap-2">
          <button @click="showAddJabatan = false" class="bg-gray-400 text-white px-3 py-1 rounded">Batal</button>
          <button @click="createJabatan" class="bg-blue-600 text-white px-3 py-1 rounded">Simpan</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import KaryawanForm from '~/components/karyawanForm.vue'
import { karyawanService } from '~/services/useKaryawan.js'

const units = ref([])
const jabatans = ref([])

const showAddUnit = ref(false)
const showAddJabatan = ref(false)

const newUnit = ref({ nama_unit: '', tempat_tugas: '' })
const newJabatan = ref({ nama_jabatan: '', eselon: '', golongan: '' })

const router = useRouter()

onMounted(async () => {
  try {
    units.value = await karyawanService.getUnits()
    jabatans.value = await karyawanService.getJabatans()
  } catch (error) {
    console.error('Gagal mengambil data unit/jabatan:', error)
  }
})

async function handleSubmit(data) {
  try {
    const formData = new FormData()
    for (const key in data) {
      if (data[key] !== null && data[key] !== undefined)
        formData.append(key, data[key])
    }

    await karyawanService.createKaryawan(formData)
    alert('Karyawan berhasil disimpan!')
    router.push('/dashboard')
  } catch (error) {
    console.error('Gagal menyimpan karyawan:', error)
    alert('Gagal menyimpan karyawan!')
  }
}

async function createUnit() {
  try {
    const res = await karyawanService.createUnit(newUnit.value)
    units.value.push(res)
    showAddUnit.value = false
    newUnit.value = { nama_unit: '', tempat_tugas: '' }
    alert('Unit baru berhasil ditambahkan!')
  } catch (error) {
    console.error('Gagal menambahkan unit:', error)
    alert('Gagal menambahkan unit!')
  }
}

async function createJabatan() {
  try {
    const res = await karyawanService.createJabatan(newJabatan.value)
    jabatans.value.push(res)
    showAddJabatan.value = false
    newJabatan.value = { nama_jabatan: '', eselon: '', golongan: '' }
    alert('Jabatan baru berhasil ditambahkan!')
  } catch (error) {
    console.error('Gagal menambahkan jabatan:', error)
    alert('Gagal menambahkan jabatan!')
  }
}
</script>
