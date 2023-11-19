import React from 'react'
import { createRoot } from 'react-dom/client'
import Order from './Order'
import Navbar from '../../components/Navbar'
import Footer from '../../components/Footer'
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";

if(document.getElementById('order-page')) {
    const root = createRoot(document.getElementById('order-page'));
    root.render(
        <React.StrictMode>
            <Navbar />
            <Order />
            <Footer />
        </React.StrictMode>
    );
}
