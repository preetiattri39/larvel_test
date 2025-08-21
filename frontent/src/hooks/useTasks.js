import { create } from "zustand";
import axios from "axios";

const useTaskStore = create((set, get) => ({
  tasks: [],
  filterDate: "",
  filterStatus: "",
  loading: false,
  error: null,

  fetchTasks: async () => {
    set({ loading: true, error: null });
    const { filterDate, filterStatus } = get();
    const params = {};
    if (filterStatus) params.status = filterStatus;
    if (filterDate) {
      params.due_date_from = filterDate;
      params.due_date_to = filterDate; // exact match
    }

    try {
      const res = await axios.get("http://localhost:8000/api/tasks", { params });
      set({ tasks: res.data.data, loading: false });
    } catch (err) {
      set({ error: err.message, loading: false });
    }
  },

  setFilterDate: (date) => {
    set({ filterDate: date });
    get().fetchTasks();
  },

  setFilterStatus: (status) => {
    set({ filterStatus: status });
    get().fetchTasks();
  },
}));

export default useTaskStore;
