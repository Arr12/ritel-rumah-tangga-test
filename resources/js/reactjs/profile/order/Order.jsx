import React, { useEffect, useState } from "react";
import axios from "axios";

export default function Order() {
    const [ addressDetailModal, setAddressDetailModal ] = useState(false);
    const [ informationDetailModal, setInformationDetailModal ] = useState(false);
    return (
        <>
            <div className="py-14 px-5 md:px-10 bg-green-50 flex flex-row items-center justify-between">
                <h1 className="font-bold text-2xl">ORDER</h1>
                <div className="flex flex-row items-center">
                    <p className="mx-2 text-sm">HOME</p>
                    <ion-icon name="chevron-forward-outline"></ion-icon>
                    <p className="mx-2 text-sm">PAGES</p>
                    <ion-icon name="chevron-forward-outline"></ion-icon>
                    <p className="mx-2 text-sm font-bold">ORDER</p>
                </div>
            </div>
            <div className="flex flex-col-reverse md:flex-row items-start px-10 pt-10 mb-10">
                <div className="flex flex-col w-full md:w-2/3 lg:w-1/4 pt-10 items-center bg-gray-100">
                    <img
                        className="object-cover rounded-full h-40 w-40"
                        src="/images/blank-pp.png"
                        alt="Blank Profiles"
                        srcSet="/images/blank-pp.png"
                    />
                    <div className="flex flex-col items-center my-3">
                        <h2 className="font-bold text-lg">Undefined</h2>
                        <p>info@example.com</p>
                    </div>
                    <div className="flex flex-col justify-start w-full">
                        <div className="p-4 cursor-pointer bg-white" onClick={() => window.location.replace('/buyer/profile/info')}>
                            <p className="text-base">Informasi Akun</p>
                        </div>
                        <div className="p-4 cursor-pointer" onClick={() => window.location.replace('/buyer/profile')}>
                            <p className="text-base">Profil</p>
                        </div>
                        <div className="p-4 cursor-pointer">
                            <p className="text-base">Keluar</p>
                        </div>
                    </div>
                </div>
            </div>
            {
                informationDetailModal && (
                    <div className="bg-[#0006] w-screen h-screen fixed z-20 top-0 left-0 flex items-center">
                        <div className="bg-white w-6/12 h-[90%] md:h-auto overflow-y-auto m-auto p-7 rounded-md">
                            <ion-icon onClick={() => setInformationDetailModal(false)} className="text-2xl mb-5 cursor-pointer" name="close-outline"></ion-icon>
                            <div className="grid grid-cols-1 mt-5">
                                <form action="">
                                    <label className="mb-5 flex flex-col items-center py-28 md:py-32 justify-center h-32 px-4 transition bg-white border-2 border-gray-300 border-dashed rounded-md appearance-none cursor-pointer hover:border-gray-400 focus:outline-none">
                                        <span className="flex items-center space-x-2">
                                            {
                                                <img
                                                    src={`${"/images/blank-pp.png"}`}
                                                    srcSet={`${"/images/blank-pp.png"}`}
                                                    className="w-48 p-5 bg-[#F6F6F6]"
                                                    width={"auto"}
                                                    height={"auto"}
                                                    onError={(e) =>
                                                        (e.target.src = "/images/no-image.png")
                                                    }
                                                />
                                            }
                                        </span>
                                        <input
                                            type="file"
                                            onChange={(e) => handleUploadFile(e.target.files)}
                                            name="file_upload"
                                            className="hidden"
                                        />
                                    </label>
                                    <div className="flex flex-col pr-3 w-full mb-5">
                                        <label className="mr-3">Nama :</label>
                                        <input className="mt-2 rounded-md border-gray-300" type="text" placeholder="Nama..." name="name" />
                                    </div>
                                    <div className="flex flex-col pr-3 w-full mb-5">
                                        <label className="mr-3 w-28">Email :</label>
                                        <input className="mt-2 rounded-md border-gray-300" type="text" placeholder="Email..." name="email" />
                                    </div>
                                    <button type="submit" className="mt-5 bg-red-400 px-5 py-3 rounded-lg text-white">
                                        <p>Submit</p>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                )
            }
            {
                addressDetailModal && (
                    <div className="bg-[#0006] w-screen h-screen fixed z-20 top-0 left-0 flex items-center">
                        <div className="bg-white w-6/12 h-[90%] md:h-auto overflow-y-auto m-auto p-7 rounded-md">
                            <ion-icon onClick={() => setAddressDetailModal(false)} className="text-right text-2xl mb-5 cursor-pointer" name="close-outline"></ion-icon>
                            <div className="grid grid-cols-1">
                                <form action="">
                                    <div className="flex flex-col pr-3 w-full my-5">
                                        <label className="mr-3 mb-3">Alamat :</label>
                                        <input className="mt-2 rounded-md border-gray-300" type="text" placeholder="Nama..." name="name" />
                                    </div>
                                    <div className="flex flex-col pr-3 w-full mb-5">
                                        <label className="mr-3 mb-3">Kota/Kabupaten :</label>
                                        <select name="city" id="">
                                            <option value="">Pilih Kota</option>
                                        </select>
                                    </div>
                                    <button type="submit" className="mt-5 bg-red-400 px-5 py-3 rounded-lg text-white">
                                        <p>Submit</p>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                )
            }
        </>
    );
}
