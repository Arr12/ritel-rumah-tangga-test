import React from "react";

export default function Footer () {
    return (
        <>
            <div className="flex flex-col lg:flex-row items-start bg-gray-900 px-5 md:px-10 py-24">
                <div className="text-white">
                    <h2 className="font-bold mb-3">DAFTAR SEBAGAI NEWSLETTER</h2>
                    <p className="mb-3 text-xs">Subscribe to the mailing list to receive updates on new arrivals, special offers</p>
                    <input className="w-full mt-5 p-3" type="email" name="" id="" placeholder="Enter your email address..." />
                    <div className="flex flex-row items-center pt-10 text-white mr-3">
                        <ion-icon class="text-2xl mr-3" name="logo-facebook"></ion-icon>
                        <ion-icon class="text-2xl mr-3" name="logo-twitter"></ion-icon>
                        <ion-icon class="text-2xl mr-3" name="logo-pinterest"></ion-icon>
                        <ion-icon class="text-2xl mr-3" name="logo-linkedin"></ion-icon>
                        <ion-icon class="text-2xl mr-3" name="logo-instagram"></ion-icon>
                        <ion-icon class="text-2xl mr-3" name="logo-youtube"></ion-icon>
                    </div>
                </div>
                <div className="grid grid-cols-1 lg:grid-cols-3 text-white mt-10 lg:mt-auto lg:ml-10">
                    <div className="flex flex-col">
                        <h3 className="font-bold mb-5">AKUN</h3>
                        <a href="#" className="text-sm mb-5">
                            Akunku
                        </a>
                        <a href="#" className="text-sm mb-5">
                            Riwayat Order
                        </a>
                        <a href="#" className="text-sm mb-5">
                            Pusat Dukungan
                        </a>
                    </div>
                    <div className="flex flex-col">
                        <h3 className="font-bold mb-5">INFORMASI</h3>
                        <a href="#" className="text-sm mb-5">
                            Tentang Kami
                        </a>
                        <a href="#" className="text-sm mb-5">
                            Kontak Kami
                        </a>
                        <a href="#" className="text-sm mb-5">
                            Kabar Terbaru
                        </a>
                        <a href="#" className="text-sm mb-5">
                            Kebijakan Privasi
                        </a>
                        <a href="#" className="text-sm mb-5">
                            Syarat dan Ketentuan
                        </a>
                    </div>
                    <div>
                        <h3 className="font-bold mb-5">KONTAK INFO</h3>
                        <div>
                            <div className="flex flex-row items-center mb-3">
                                <ion-icon class="text-2xl mr-3" name="map-outline"></ion-icon>
                                <p>PURI SURYA JAYA TAMAN NAGOYA E4 - NO.43</p>
                            </div>
                            <div className="flex flex-row items-center my-3">
                                <ion-icon class="text-2xl mr-3" name="call-outline"></ion-icon>
                                <p>1366303</p>
                            </div>
                            <div className="flex flex-row items-center my-3">
                                <ion-icon class="text-2xl mr-3" name="mail-outline"></ion-icon>
                                <p className="break-words w-36 lg:w-48">info@ptritelrumahtanggaindonesia</p>
                            </div>
                            <div className="flex flex-row items-center my-3">
                                <ion-icon class="text-2xl mr-3" name="time-outline"></ion-icon>
                                <p>
                                    Working Hours :<br />
                                    Sen - Sab / 09:00 AM - 19:00 PM
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div className="py-6 bg-gray-900 border-t-[1px] border-t-gray-400">
                <p className="text-white ml-10">© 2023 PT Ritel Rumah Tangga Indonesia. All Rights Reserved.</p>
            </div>
        </>
    )
}
