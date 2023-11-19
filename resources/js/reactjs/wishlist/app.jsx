import React from 'react'
import { createRoot } from 'react-dom/client'
import Wishlist from './Wishlist'
import Navbar from '../components/Navbar'
import Footer from '../components/Footer'
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";

if(document.getElementById('wishlist-page')) {
    const root = createRoot(document.getElementById('wishlist-page'));
    root.render(
        <React.StrictMode>
            <Navbar />
            <Wishlist />
            <Footer />
        </React.StrictMode>
    );
}
