<template>
  <form @submit.prevent="onSubmit" class="space-y-4 p-4 bg-white rounded shadow">
    <!-- NIP & Nama -->
    <div class="flex gap-4">
      <div class="flex-1">
        <label class="block mb-1">NIP</label>
        <input
          v-model="form.nip"
          type="text"
          class="w-full border px-3 py-2 rounded"
          required
        />
      </div>
      <div class="flex-1">
        <label class="block mb-1">Nama</label>
        <input
          v-model="form.nama"
          type="text"
          class="w-full border px-3 py-2 rounded"
          required
        />
      </div>
    </div>

    <!-- Tempat & Tanggal Lahir -->
    <div class="flex gap-4">
      <div class="flex-1">
        <label class="block mb-1">Tempat Lahir</label>
        <input
          v-model="form.tempat_lahir"
          type="text"
          class="w-full border px-3 py-2 rounded"
          required
        />
      </div>
      <div class="flex-1">
        <label class="block mb-1">Tanggal Lahir</label>
        <input
          v-model="form.tanggal_lahir"
          type="date"
          class="w-full border px-3 py-2 rounded"
          required
        />
      </div>
    </div>

    <!-- Jenis Kelamin -->
    <div>
      <label class="block mb-1">Jenis Kelamin</label>
      <div class="flex gap-4">
        <label><input type="radio" value="L" v-model="form.jenis_kelamin" /> Laki-laki</label>
        <label><input type="radio" value="P" v-model="form.jenis_kelamin" /> Perempuan</label>
      </div>
    </div>

    <!-- Alamat -->
    <div>
      <label class="block mb-1">Alamat</label>
      <textarea v-model="form.alamat" class="w-full border px-3 py-2 rounded"></textarea>
    </div>

    <!-- No HP & NPWP -->
    <div class="flex gap-4">
      <div class="flex-1">
        <label class="block mb-1">No. HP</label>
        <input v-model="form.no_hp" type="text" class="w-full border px-3 py-2 rounded" />
      </div>
      <div class="flex-1">
        <label class="block mb-1">NPWP</label>
        <input v-model="form.npwp" type="text" class="w-full border px-3 py-2 rounded" />
      </div>
    </div>

    <!-- Agama -->
    <div>
      <label class="block mb-1">Agama</label>
      <input v-model="form.agama" type="text" class="w-full border px-3 py-2 rounded" />
    </div>

    <!-- Foto -->
    <div>
      <label class="block mb-1">Foto</label>

      <!-- Preview jika ada foto lama -->
      <div v-if="karyawan?.foto && !form.foto" class="mb-2">
        <img
          :src="karyawan.foto"
          alt="Foto Karyawan"
          class="w-32 h-32 object-cover rounded border"
        />
      </div>

      <input type="file" @change="onFileChange" class="w-full" />
    </div>

    <!-- Unit -->
    <div>
      <label class="block mb-1">Unit</label>
      <select v-model="form.unit_id" class="w-full border px-3 py-2 rounded" required>
        <option value="">Pilih Unit</option>
        <option v-for="u in units" :key="u.id" :value="u.id">
          {{ u.nama_unit }} ({{ u.tempat_tugas }})
        </option>
        <option value="add-new-unit">+ Tambah Unit Baru</option>
      </select>
    </div>

    <!-- Jabatan -->
    <div>
      <label class="block mb-1">Jabatan</label>
      <select v-model="form.jabatan_id" class="w-full border px-3 py-2 rounded" required>
        <option value="">Pilih Jabatan</option>
        <option v-for="j in jabatans" :key="j.id" :value="j.id">
          {{ j.nama_jabatan }} - {{ j.eselon }} - {{ j.golongan }}
        </option>
        <option value="add-new-jabatan">+ Tambah Jabatan Baru</option>
      </select>
    </div>

    <!-- Tombol -->
    <button
      type="submit"
      class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
    >
      Simpan
    </button>
  </form>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  units: { type: Array, default: () => [] },
  jabatans: { type: Array, default: () => [] },
  karyawan: { type: Object, default: () => ({}) },
})

const emit = defineEmits(['submit', 'add-unit', 'add-jabatan'])

const form = ref({
  nip: '',
  nama: '',
  tempat_lahir: '',
  tanggal_lahir: '',
  jenis_kelamin: 'L',
  alamat: '',
  no_hp: '',
  npwp: '',
  agama: '',
  foto: null,
  unit_id: '',
  jabatan_id: ''
})

// Ambil data dari props.karyawan (edit mode)
watch(
  () => props.karyawan,
  (val) => {
    if (val && Object.keys(val).length) {
      form.value = {
        ...form.value,
        ...val,
        foto: null 
      }
    }
  },
  { immediate: true }
)

// Tambah Unit Baru
watch(() => form.value.unit_id, (val) => {
  if (val === 'add-new-unit') {
    emit('add-unit')
    form.value.unit_id = ''
  }
})

// Tambah Jabatan Baru
watch(() => form.value.jabatan_id, (val) => {
  if (val === 'add-new-jabatan') {
    emit('add-jabatan')
    form.value.jabatan_id = ''
  }
})

function onFileChange(e) {
  const file = e.target.files[0]
  form.value.foto = file || null
}

function onSubmit() {
  emit('submit', form.value)
}
</script>
