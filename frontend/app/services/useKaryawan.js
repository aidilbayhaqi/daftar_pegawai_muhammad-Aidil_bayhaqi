import axios from "axios";

const API_URL =
  import.meta.env.NUXT_PUBLIC_API_BASE_URL || "http://127.0.0.1:8000/api";

function authHeaders() {
  const token = localStorage.getItem("token");
  return { Authorization: `Bearer ${token}` };
}

export const karyawanService = {
  // get karyawan
  async getAll() {
    try {
      const res = await axios.get(`${API_URL}/karyawans`, {
        headers: authHeaders(),
      });
      return res.data;
    } catch (error) {
      console.error("Gagal mengambil daftar karyawan:", error);
      throw error;
    }
  },

  // create karyawan
  async createKaryawan(data) {
    try {
      const res = await axios.post(`${API_URL}/karyawans`, data, {
        headers: authHeaders(),
      });
      return res.data;
    } catch (error) {
      console.error("Gagal membuat karyawan:", error);
      throw error;
    }
  },

  // get karyawan by id
  async getById(id) {
    try {
      const res = await axios.get(`${API_URL}/karyawans/${id}`, {
        headers: authHeaders(),
      });
      return res.data.data || res.data;
    } catch (error) {
      console.error(`Gagal mengambil karyawan dengan ID ${id}:`, error);
      throw error;
    }
  },

  // update karyawan
  async update(id, formData) {
    try {
      const res = await axios.post(`${API_URL}/karyawans/${id}`, formData, {
        headers: {
          ...authHeaders(),
          "Content-Type": "multipart/form-data",
        },
      });
      return res.data;
    } catch (error) {
      console.error(`Gagal memperbarui karyawan dengan ID ${id}:`, error);
      throw error;
    }
  },

  // Delete karyawan
  async remove(id) {
    try {
      const res = await axios.delete(`${API_URL}/karyawans/${id}`, {
        headers: authHeaders(),
      });
      return res.data;
    } catch (error) {
      console.error(`Gagal menghapus karyawan dengan ID ${id}:`, error);
      throw error;
    }
  },

  // get unit
  async getUnits() {
    try {
      const res = await axios.get(`${API_URL}/units`, {
        headers: authHeaders(),
      });
      return res.data;
    } catch (error) {
      console.error("Gagal mengambil daftar unit:", error);
      throw error;
    }
  },

  // get jabatan
  async getJabatans() {
    try {
      const res = await axios.get(`${API_URL}/jabatans`, {
        headers: authHeaders(),
      });
      return res.data;
    } catch (error) {
      console.error("Gagal mengambil daftar jabatan:", error);
      throw error;
    }
  },

  // create unit
  async createUnit(data) {
    try {
      const res = await axios.post(`${API_URL}/units`, data, {
        headers: authHeaders(),
      });
      return res.data;
    } catch (error) {
      console.error("Gagal membuat unit:", error);
      throw error;
    }
  },

  // create jabatan
  async createJabatan(data) {
    try {
      const res = await axios.post(`${API_URL}/jabatans`, data, {
        headers: authHeaders(),
      });
      return res.data;
    } catch (error) {
      console.error("Gagal membuat jabatan:", error);
      throw error;
    }
  },
};
