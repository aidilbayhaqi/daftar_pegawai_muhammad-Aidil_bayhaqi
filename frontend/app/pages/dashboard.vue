<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Karyawan</h1>
    <KaryawanTable
      :karyawanList="karyawanList"
      :units="unitList"
      @edit="editKaryawan"
      @delete="deleteKaryawan"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import KaryawanTable from '~/components/KaryawanTable.vue'
import { karyawanService } from '~/services/useKaryawan.js'

const karyawanList = ref([])
const router = useRouter()

onMounted(async () => {
  karyawanList.value = await karyawanService.getAll()
})

const unitList = ref([]) 

function editKaryawan(id) {
  router.push(`/karyawan-form/${id}`)
}

async function deleteKaryawan(id) {
if (!confirm('Apakah Anda yakin ingin menghapus karyawan ini?')) return
  try {
    await karyawanService.remove(id)
    karyawanList.value = karyawanList.value.filter(k => k.id !== id)
    alert('Karyawan berhasil dihapus')
  } catch (error) {
    console.error('Error delete:', error)
    alert('Gagal menghapus karyawan')
  }
}
</script>
