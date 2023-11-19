import React from 'react'
import Register from './Register'
import Navbar from '../components/Navbar'
import Footer from '../components/Footer'
import { createRoot } from 'react-dom/client'

if(document.getElementById('register-page')) {
    const root = createRoot(document.getElementById('register-page'));
    root.render(
        <React.StrictMode>
            <Navbar />
            <Register />
            <Footer />
        </React.StrictMode>
    );
}
