import React, { useState, useEffect } from 'react';
import axios from 'axios';
import './CommentForm.scss';

const CommentForm = ({ taskId }) => {
  const [name, setName] = useState('');
  const [comment, setComment] = useState('');
  const [comments, setComments] = useState([]);

  // Fetch existing comments for this task
  useEffect(() => {
    const fetchComments = async () => {
      try {
        const response = await axios.get(`http://localhost:8000/api/tasks/${taskId}/comments`);
        if (response.data.status) {
          setComments(response.data.data);
        }
      } catch (err) {
        console.error(err);
      }
    };

    fetchComments();
  }, [taskId]);

  // Submit new comment
  const handleSubmit = async (e) => {
    e.preventDefault();
    if (name && comment) {
      try {
        const response = await axios.post(`http://localhost:8000/api/tasks/${taskId}/comments`, {
          content: comment,
          author_name: name,
        });
        if (response.data.status) {
          setComments([...comments, response.data.data]);
          setName('');
          setComment('');
        }
      } catch (err) {
        console.error('Error submitting comment:', err.response?.data || err.message);
      }
    }
  };

  return (
    <>
      <form className="comment-form" onSubmit={handleSubmit}>
        <div className="col-12 col-md-4 mb-3">
          <input
            type="text"
            className="form-control"
            placeholder="Name"
            value={name}
            onChange={(e) => setName(e.target.value)}
          />
        </div>

        <div className="col-12 col-md-4 mb-4">
          <textarea
            className="form-control"
            placeholder="Please add a comment"
            rows="3"
            value={comment}
            onChange={(e) => setComment(e.target.value)}
          />
        </div>

        <button type="submit" className="btn btn-secondary px-4 mt-2 mb-4">
          Submit
        </button>
      </form>

      <hr />
      <h4>Comments</h4>
      <ul className="comment-list mt-4">
        {comments.map((c, index) => (
          <li key={index}>
            <span>{c.author_name}</span> {c.content}
          </li>
        ))}
      </ul>
    </>
  );
};

export default CommentForm;
