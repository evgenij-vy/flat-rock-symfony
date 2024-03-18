import React from 'react';
import './App.css';
import {BrowserRouter, createBrowserRouter, Route, Routes} from "react-router-dom";
import Home from "./routes/home";
import RegisterForm from "./routes/register";
import LogInForm from "./routes/logIn";
import AccountForm from "./routes/account";
import QuizzesForm from "./routes/admin/quizzes";
import Quiz from "./routes/admin/quiz";

function App() {
    return (
      <BrowserRouter>
          <Routes>
              <Route path="/" element={<Home />}/>
              <Route path="/register" element={<RegisterForm />} />
              <Route path="/login" element={<LogInForm />} />
              <Route path="/account" element={<AccountForm />} />
              <Route path="/admin/quiz" element={<QuizzesForm />} />
              <Route path="/admin/quiz/:id" element={<Quiz />} />
          </Routes>
      </BrowserRouter>
    );
}

export default App;
