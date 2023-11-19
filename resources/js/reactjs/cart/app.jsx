import React from 'react'
import { createRoot } from 'react-dom/client'
import Cart from './cart'
import Navbar from '../components/Navbar'
import Footer from '../components/Footer'
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";

if(document.getElementById('landing-page')) {
    const root = createRoot(document.getElementById('landing-page'));
    root.render(
        <React.StrictMode>
            <Navbar />
            <Cart />
            <Footer />
        </React.StrictMode>
    );
}
