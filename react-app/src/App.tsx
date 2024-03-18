import React from 'react';
import './App.css';
import {BrowserRouter, Route, Routes} from "react-router-dom";
import Home from "./routes/home";
import RegisterForm from "./routes/register";
import LogInForm from "./routes/logIn";
import AccountForm from "./routes/account";

function App() {
    return (
      <BrowserRouter>
          <Routes>
              <Route path="/" element={<Home />}/>
              <Route path="/register" element={<RegisterForm />} />
              <Route path="/login" element={<LogInForm />} />
              <Route path="/account" element={<AccountForm />} />
              {/*<Route path="/admin/quiz" element={} />*/}
          </Routes>
      </BrowserRouter>
    );
}

export default App;
