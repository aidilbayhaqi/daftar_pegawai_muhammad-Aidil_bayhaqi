<template>
  <div>
    <!-- FILTER DAN PENCARIAN -->
    <div class="flex gap-3 mb-4">
      <input
        v-model="search"
        placeholder="Cari nama..."
        class="border px-3 py-2 rounded w-64"
      />
      <select v-model="selectedUnit" class="border px-3 py-2 rounded">
  <option value="">Semua Unit</option>
  <option v-for="u in unitList" :key="u" :value="u">{{ u }}</option>
</select>

 <button
        @click="goToForm()"
        class="ml-auto bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
      >
        Tambah Karyawan
      </button>
       <button
        @click="printTable"
        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
      >
        🖨️ Cetak
      </button>
    </div>

    <!-- TABEL KARYAWAN -->
    <table id="karyawanTable" class="min-w-full border border-gray-300 rounded-lg shadow-sm text-sm">
      <thead class="bg-gray-100">
        <tr>
          <th class="py-2 px-4 text-left border-b">NIP</th>
          <th class="py-2 px-4 text-left border-b">Foto</th>
          <th class="py-2 px-4 text-left border-b">Nama</th>
          <th class="py-2 px-4 text-left border-b">Alamat</th>
          <th class="py-2 px-4 text-left border-b">No. HP</th>
          <th class="py-2 px-4 text-left border-b">Tempat Lahir</th>
          <th class="py-2 px-4 text-left border-b">Tanggal Lahir</th>
          <th class="py-2 px-4 text-left border-b">Nama Unit</th>
          <th class="py-2 px-4 text-left border-b">tempat Tugas</th>
          <th class="py-2 px-4 text-left border-b">Nama Jabatan</th>
          <th class="py-2 px-4 text-left border-b">Eselon</th>
          <th class="py-2 px-4 text-left border-b">Golongan</th>
          <th class="py-2 px-4 text-left border-b">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="k in pagedData"
          :key="k.id"
          class="hover:bg-gray-50 transition"
        >
          <td class="py-2 px-4 border-b">{{ k.nip }}</td>
           <td class="border p-2 text-center">
            <img
              v-if="k.foto"
              :src="getFotoUrl(k.foto_url)"
              alt="Foto Karyawan"
              class="w-10 h-10 object-cover rounded-full mx-auto border"
            />
            <div v-else class="text-gray-400 italic text-sm">Tidak ada foto</div></td>
          <td class="py-2 px-4 border-b">{{ k.nama }}</td>
          <td class="py-2 px-4 border-b">{{ k.alamat }}</td>
          <td class="py-2 px-4 border-b">{{ k.no_hp }}</td>
          <td class="py-2 px-4 border-b">{{ k.tempat_lahir }}</td>
          <td class="py-2 px-4 border-b">{{ k.tanggal_lahir }}</td>
          <td class="py-2 px-4 border-b">{{ k.unit?.nama_unit ?? '-' }}</td>
          <td class="py-2 px-4 border-b">{{ k.unit?.tempat_tugas ?? '-' }}</td>
          <td class="py-2 px-4 border-b">{{ k.jabatan?.nama_jabatan ?? '-' }}</td>
          <td class="py-2 px-4 border-b">{{ k.jabatan?.eselon ?? '-' }}</td>
          <td class="py-2 px-4 border-b">{{ k.jabatan?.golongan ?? '-' }}</td>
          <td class="py-2 px-4 border-b">
            <button class="text-blue-600 mr-2" @click="$emit('edit', k.id)">
              Edit
            </button>
            <button class="text-red-600" @click="$emit('delete', k.id)">
              Hapus
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- PAGING -->
    <div class="mt-4 flex justify-center gap-2">
      <button
        class="px-3 py-1 border rounded"
        :disabled="currentPage === 1"
        @click="prevPage"
      >
        Prev
      </button>
      <span class="px-3 py-1 border rounded">
        Halaman {{ currentPage }} dari {{ totalPages }}
      </span>
      <button
        class="px-3 py-1 border rounded"
        :disabled="currentPage === totalPages"
        @click="nextPage"
      >
        Next
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import { karyawanService } from '~/services/useKaryawan'

const employees = ref([])

const search = ref('')
const selectedUnit = ref('')
const currentPage = ref(1)
const itemsPerPage = 10
const router = useRouter()
const BASE_URL =   import.meta.env.NUXT_PUBLIC_API_BASE_URL || "http://127.0.0.1:8000/api";

// Ambil data dari backend
onMounted(async () => {
  try {
    employees.value = await karyawanService.getAll()
  } catch (error) {
    console.error("Gagal memuat data karyawan:", error)
  }
})

// Daftar unit
const unitList = computed(() => {
  const list = employees.value
    .filter(k => k.unit && k.unit.nama_unit)
    .map(k => k.unit.nama_unit)
  return [...new Set(list)] 
})

// Filter data
const filteredData = computed(() => {
  return employees.value.filter(k =>
    k.nama.toLowerCase().includes(search.value.toLowerCase()) &&
    (!selectedUnit.value || k.unit?.nama_unit === selectedUnit.value)
  )
})

// Total halaman
const totalPages = computed(() => Math.ceil(filteredData.value.length / itemsPerPage))

// Data per halaman
const pagedData = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage
  const end = start + itemsPerPage
  return filteredData.value.slice(start, end)
})

// Paging functions
function prevPage() {
  if (currentPage.value > 1) currentPage.value--
}
function nextPage() {
  if (currentPage.value < totalPages.value) currentPage.value++
}

// ambil foto
function getFotoUrl(foto) {
  if (!foto) return ''
  if (foto.startsWith('http')) return foto
  return `${BASE_URL}/${foto}`
}

// Reset halaman jika filter/search berubah
watch([search, selectedUnit], () => { currentPage.value = 1 })

function goToForm(){
  router.push('/karyawan-form')
}

function printTable() {
  const printContents = document.getElementById('karyawanTable').outerHTML
  const win = window.open('', '', 'width=900,height=700')
  win.document.write(`
    <html>
      <head>
        <title>Cetak Data Karyawan</title>
        <style>
          table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
          }
          th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
          }
          th {
            background-color: #f3f3f3;
          }
          h2 {
            text-align: center;
            margin-bottom: 20px;
          }
          img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
          }
        </style>
      </head>
      <body>
        <h2>Daftar Karyawan</h2>
        ${printContents}
      </body>
    </html>
  `)
  win.document.close()
  win.focus()
  win.print()
  win.close()
}

</script>
