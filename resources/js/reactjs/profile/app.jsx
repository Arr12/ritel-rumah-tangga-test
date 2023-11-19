import React from 'react'
import { createRoot } from 'react-dom/client'
import Profile from './Profile'
import Navbar from '../components/Navbar'
import Footer from '../components/Footer'
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";

if(document.getElementById('profile-page')) {
    const root = createRoot(document.getElementById('profile-page'));
    root.render(
        <React.StrictMode>
            <Navbar />
            <Profile />
            <Footer />
        </React.StrictMode>
    );
}
