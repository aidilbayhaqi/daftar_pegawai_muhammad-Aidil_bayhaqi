import axios from "axios";

const API_URL =
  import.meta.env.NUXT_PUBLIC_API_BASE_URL || "http://127.0.0.1:8000/api";

const api = axios.create({
  baseURL: API_URL,
  headers: {
    "Content-Type": "application/json",
  },
});

export const authService = {
  // 🔹 Login user
  async login(credentials) {
    try {
      const res = await api.post("/login", credentials);

      if (res.data.access_token) {
        localStorage.setItem("token", res.data.access_token);
        localStorage.setItem("user", JSON.stringify(res.data.user));
      }

      return res.data;
    } catch (error) {
      console.error("Login error:", error.response?.data || error.message);
      throw new Error(error.response?.data?.message || "Login gagal");
    }
  },

  // 🔹 Register user baru
  async register(data) {
    try {
      const res = await api.post("/register", data);
      return res.data;
    } catch (error) {
      console.error("Register error:", error.response?.data || error.message);
      throw new Error(error.response?.data?.message || "Registrasi gagal");
    }
  },

  // 🔹 Ambil data user dari localStorage
  getCurrentUser() {
    try {
      const user = localStorage.getItem("user");
      return user ? JSON.parse(user) : null;
    } catch {
      return null;
    }
  },

  // 🔹 Logout
  async logout() {
    try {
      const token = localStorage.getItem("token");
      if (!token) return;

      await api.post(
        "/logout",
        {},
        {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        }
      );

      localStorage.removeItem("token");
      localStorage.removeItem("user");
    } catch (error) {
      console.error("Logout error:", error.response?.data || error.message);
    }
  },

  // 🔹 Cek apakah user sudah login
  isAuthenticated() {
    return !!localStorage.getItem("token");
  },
};
