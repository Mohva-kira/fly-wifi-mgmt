import logo from './logo.svg';
import './App.css';
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import Login from './components/login/Login';
import Register from './components/Register';
import { Routes, Route, Link } from "react-router-dom";

function App() {
  return (
    <div className="App">
       
       <h1>Welcome to FLY WIFI</h1>
      <Routes>
        <Route path="/" element={<Register />} />
        <Route path="login" element={<Login />} />
      </Routes>  
    </div>
  );
}

export default App;
