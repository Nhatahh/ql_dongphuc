require('./bootstrap');
import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';

function Home() {
  return <h1>Welcome to the Home Page!</h1>;
}

function Test() {
  const [message, setMessage] = useState('');

  useEffect(() => {
    // Gọi API từ Laravel
    axios.get('http://127.0.0.1:8000/api/hello')
      .then(response => {
        setMessage(response.data.message); // Nhận thông điệp từ API và hiển thị
      })
      .catch(error => {
        console.error('There was an error!', error);
      });
  }, []);

  return (
    <div>11111111
      <h1>{message}</h1>
    </div>
  );
}

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/test" element={<Test />} />
      </Routes>
    </Router>
  );
}

export default App;
