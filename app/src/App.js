import logo from './logo.svg';
import './App.css';
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import Login from './components/login/Login';
import Register from './components/Register';
import { Routes, Route, Link } from "react-router-dom";
import Dashboard from './pages/dashboard/Dashboard';

function App() {
  return (
    <div className="App">
       
    
      <Routes>
        <Route path="/" element={<Register />} />
        <Route path="login" element={<Login />} />
        <Route path="dashboard" element={<Dashboard />} />
      </Routes>  
    </div>
  );
}

export default App;
