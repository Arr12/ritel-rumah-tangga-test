import React from 'react'
import { createRoot } from 'react-dom/client'
import Information from './Information'
import Navbar from '../../components/Navbar'
import Footer from '../../components/Footer'
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";

if(document.getElementById('information-page')) {
    const root = createRoot(document.getElementById('information-page'));
    root.render(
        <React.StrictMode>
            <Navbar />
            <Information />
            <Footer />
        </React.StrictMode>
    );
}
