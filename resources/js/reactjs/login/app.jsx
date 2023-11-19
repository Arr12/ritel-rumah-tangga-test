import React from 'react'
import Login from './Login'
import Navbar from '../components/Navbar'
import Footer from '../components/Footer'
import { createRoot } from 'react-dom/client'

if(document.getElementById('login-page')) {
    const root = createRoot(document.getElementById('login-page'));
    root.render(
        <React.StrictMode>
            <Navbar />
            <Login />
            <Footer />
        </React.StrictMode>
    );
}
