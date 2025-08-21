import React, { useEffect } from "react";
import useTaskStore from "../../hooks/useTasks";
import CardComponent from "./TaskCard";

const CardWrapper = () => {
  const { tasks, loading, error, fetchTasks } = useTaskStore();

  useEffect(() => {
    fetchTasks();
  }, []);

  if (loading) return <p>Loading...</p>;
  if (error) return <p>Error: {error}</p>;

  return (
    <div className="col-12 card-wrapper">
      {tasks.map((task) => (
        <CardComponent
          key={task.id}
          id={task.id}
          title={task.title}
          status={task.status}
          date={task.due_date}
        />
      ))}
    </div>
  );
};

export default CardWrapper;
