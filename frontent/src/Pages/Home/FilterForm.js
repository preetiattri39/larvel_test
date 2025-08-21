import React, { useState, useEffect } from "react";
import axios from "axios";

const FilterForm = ({ onTasksUpdate }) => {
  const [selectedDate, setSelectedDate] = useState('');
  const [selectedStatus, setSelectedStatus] = useState('');
  const [taskData, setTaskData] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  // Fetch unique dates and statuses from all tasks for dropdowns
  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get("http://localhost:8000/api/tasks");
        setTaskData(response.data.data);
      } catch (err) {
        setError(err.message);
      } finally {
        setLoading(false);
      }
    };
    fetchData();
  }, []);

  // Fetch filtered tasks whenever filters change
  useEffect(() => {
    const fetchFilteredTasks = async () => {
      try {
        const params = {};
        if (selectedStatus) params.status = selectedStatus;
        if (selectedDate) {
          params.due_date_from = selectedDate;
          params.due_date_to = selectedDate; // exact date filter
        }
        const response = await axios.get("http://localhost:8000/api/tasks", { params });
        if (onTasksUpdate) onTasksUpdate(response.data.data); // pass filtered tasks to parent
      } catch (err) {
        setError(err.message);
      }
    };

    if (selectedDate || selectedStatus) {
      fetchFilteredTasks();
    }
  }, [selectedDate, selectedStatus, onTasksUpdate]);

  const uniqueDates = [...new Set(taskData.map(card => card.due_date))];
  const uniqueStatuses = [...new Set(taskData.map(card => card.status))];

  if (loading) return <p>Loading...</p>;
  if (error) return <p>Error: {error}</p>;

  return (
    <form className="filter-form">
      <h6>Filter By</h6>

      <div className="input-group">
        <label htmlFor="filter-with-date" className="select-label">Due Date</label>
        <select
          id="filter-with-date"
          className="form-select"
          value={selectedDate}
          onChange={(e) => setSelectedDate(e.target.value)}
        >
          <option value="">All Dates</option>
          {uniqueDates.map((date, index) => (
            <option key={index} value={date}>{date}</option>
          ))}
        </select>
      </div>

      <div className="input-group">
        <label htmlFor="filter-with-status" className="select-label">Status</label>
        <select
          id="filter-with-status"
          className="form-select"
          value={selectedStatus}
          onChange={(e) => setSelectedStatus(e.target.value)}
        >
          <option value="">All Statuses</option>
          {uniqueStatuses.map((status, index) => (
            <option key={index} value={status}>{status}</option>
          ))}
        </select>
      </div>
    </form>
  );
};

export default FilterForm;
