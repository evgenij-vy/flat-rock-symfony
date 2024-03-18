import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import App from './App';
import Menu from "./controller/menu";

ReactDOM.createRoot(document.getElementById('root') as HTMLElement).render(<App />);
ReactDOM.createRoot(document.getElementById('header') as HTMLElement).render(<Menu />);
