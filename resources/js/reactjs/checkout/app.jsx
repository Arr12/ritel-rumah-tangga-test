import React from 'react'
import { createRoot } from 'react-dom/client'
import Checkout from './Checkout'
import Navbar from '../components/Navbar'
import Footer from '../components/Footer'
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";

if(document.getElementById('checkout-page')) {
    const root = createRoot(document.getElementById('checkout-page'));
    root.render(
        <React.StrictMode>
            <Navbar />
            <Checkout />
            <Footer />
        </React.StrictMode>
    );
}
