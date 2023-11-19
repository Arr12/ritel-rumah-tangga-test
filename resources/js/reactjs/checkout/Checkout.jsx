import React, { useEffect, useState } from 'react'
import { Carousel } from 'react-carousel-minimal'
import Slider from 'react-slick'
import axios from 'axios';

export default function Checkout() {
    const [ checkoutOpen, setCheckoutOpen ] = useState({
        status : false,
        value: false
    });
    return (
        <div className='p-5'>
            <div className='flex flex-row flex-wrap items-start'>
                <div className='grid grid-cols-1 mt-5 p-0 md:p-5 md:mt-0 w-full lg:w-1/2'>
                    <div className='border-[1px] border-gray-300'>
                        <h2 className='px-5 py-5 font-bold'>ALAMAT PENGIRIMAN</h2>
                        <p className='px-5 py-3'><a className="underline" href="">Masuk</a> atau <a className='underline' href="">Daftar</a> pembayaran.</p>
                        <div className='grid grid-cols-1 md:grid-cols-2'>
                            <div className='px-5 py-3'>
                                <label>Nama Depan *</label>
                                <input className="mt-3 w-full border-gray-300" type="text" name="" id="" />
                            </div>
                            <div className='px-5 py-3'>
                                <label>Nama Belakang *</label>
                                <input className="mt-3 w-full border-gray-300" type="text" name="" id="" />
                            </div>
                        </div>
                        <div className='grid grid-cols-1'>
                            <div className='flex flex-col px-5 py-3'>
                                <label>Alamat *</label>
                                <input className="mt-3 border-gray-300" type="text" name="" id="" />
                                <input className='mt-3 border-gray-300' type="text" name="" id="" />
                            </div>
                        </div>
                        <div className='grid grid-cols-1 md:grid-cols-2'>
                            <div className='px-5 py-3'>
                                <label>Kode Pos *</label>
                                <input className="mt-3 w-full border-gray-300" type="text" name="" id="" />
                            </div>
                            <div className='px-5 py-3'>
                                <label>Kota *</label>
                                <select className='mt-3 w-full border-gray-300' name="" id="">
                                    <option value="">Pilih Kota</option>
                                </select>
                            </div>
                        </div>
                        <div className='flex flex-row items-center px-5 py-5 w-full'>
                            <input type="checkbox" className='border-gray-300' name="" id="" />
                            <label className='ml-3'>Simpan alamat ke Akun</label>
                        </div>
                    </div>
                </div>
                <div className='grid grid-cols-1 mt-5 p-0 md:p-5 md:mt-0 w-full lg:w-1/2'>
                    <div className='border-[1px] mt-0 border-gray-300'>
                        <h2 className='px-5 py-5 font-bold'>METODE PENGIRIMAN</h2>
                        <div className='pb-4'>
                            <div className='px-5 py-1 flex flex-row items-center'>
                                <input type="radio" name="" id="" />
                                <label className='ml-3'>Pengiriman Standard (3-5 Hari Kerja)</label>
                            </div>
                            <div className='px-5 py-1 flex flex-row items-center'>
                                <input type="radio" name="" id="" />
                                <label className='ml-3'>Pengiriman Express (2-3 Hari Kerja)</label>
                            </div>
                            <div className='px-5 py-1 flex flex-row items-center'>
                                <input type="radio" name="" id="" />
                                <label className='ml-3'>Same - Day</label>
                            </div>
                        </div>
                    </div>
                    <div className='border-[1px] mt-5 border-gray-300'>
                        <h2 className='px-5 py-5 font-bold'>METODE PEMBAYARAN</h2>
                        <div className='px-4 pb-5'>
                            <div className='flex flex-col items-center mb-3'>
                                <div onClick={() => setCheckoutOpen({ status:!checkoutOpen.status, value: '1' }) } className='px-3 py-1 flex flex-row items-center border-[1px] border-gray-300 w-full cursor-pointer'>
                                    <p className={`py-3 w-full ${checkoutOpen.status && checkoutOpen.value === '1' ? 'text-red-500' : ''}`}>ShopeePay</p>
                                    <ion-icon className='text-xs' name="chevron-down-outline"></ion-icon>
                                </div>
                                <div className={`p-5 border-[1px] border-gray-300 ${checkoutOpen.status && checkoutOpen.value === '1' ? 'block' : 'hidden'}`}>
                                    <p>Lakukan pembayaran Anda langsung ke rekening bank kami. Silakan gunakan ID Pesanan Anda sebagai referensi pembayaran. Pesanan Anda tidak akan dikirim sampai dana telah masuk ke rekening kami.</p>
                                </div>
                            </div>
                            <div className='flex flex-col items-center mb-3'>
                                <div onClick={() => setCheckoutOpen({ status:!checkoutOpen.status, value: '2' }) } className='px-3 py-1 flex flex-row items-center border-[1px] border-gray-300 w-full cursor-pointer'>
                                    <p className={`py-3 w-full ${checkoutOpen.status && checkoutOpen.value === '2' ? 'text-red-500' : 'text-red-800'}`}>OVO</p>
                                    <ion-icon className='text-xs' name="chevron-down-outline"></ion-icon>
                                </div>
                                <div className={`p-5 border-[1px] border-gray-300 ${checkoutOpen.status && checkoutOpen.value === '2' ? 'block' : 'hidden'}`}>
                                    <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won't be shipped until the funds have cleared in our account.</p>
                                </div>
                            </div>
                            <div className='flex flex-col items-center mb-3'>
                                <div onClick={() => setCheckoutOpen({ status:!checkoutOpen.status, value: '3' }) } className='px-3 py-1 flex flex-row items-center border-[1px] border-gray-300 w-full cursor-pointer'>
                                    <p className={`py-3 w-full ${checkoutOpen.status && checkoutOpen.value === '3' ? 'text-red-500' : ''}`}>Gopay</p>
                                    <ion-icon className='text-xs' name="chevron-down-outline"></ion-icon>
                                </div>
                                <div className={`p-5 border-[1px] border-gray-300 ${checkoutOpen.status && checkoutOpen.value === '3' ? 'block' : 'hidden'}`}>
                                    <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won't be shipped until the funds have cleared in our account.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className='border-[1px] mt-5 border-gray-300'>
                        <h2 className='px-5 py-5 font-bold'>KOMENTAR PESANAN</h2>
                        <div className='px-5 pb-4'>
                            <textarea className="w-full h-36 rounded-md border-2 border-[#ccc]" name="" id="" cols="30" rows="10"></textarea>
                            <label>*Pengiriman Standard (3-5 Hari Kerja)</label>
                        </div>
                    </div>
                    <div className='border-[1px] mt-5 border-gray-300'>
                        <h2 className='px-5 py-5 font-bold'>KODE PROMO</h2>
                        <div className='px-5 pb-4 flex flex-row items-center'>
                            <input className="w-full border-[1px] border-gray-300 py-3" placeholder='Kode Promo..' type="text" name="" id="" />
                            <button className='px-5 py-3 font-bold text-white bg-slate-700'>APPLY</button>
                        </div>
                    </div>
                </div>
            </div>
            <div className='grid grid-cols-1 mt-5 p-0 md:p-5 md:mt-0 w-full'>
                <div className='flex flex-row flex-wrap items-start'>
                    <div className='px-0 md:pr-5 pb-5 w-full md:w-3/5'>
                        <div className='border-[1px] border-gray-300 overflow-x-auto'>
                            <h2 className='px-5 py-5 font-bold text-lg'>RINCIAN PESANAN</h2>
                            <div className='w-[680px] lg:w-full'>
                                <table className='w-full mt-5'>
                                    <thead>
                                        <tr className='border-b-2 border-b-gray-300'>
                                            <th className='pb-5 w-56 text-sm'>GAMBAR</th>
                                            <th className='pb-5 text-sm'>PRODUK</th>
                                            <th className='pb-5 text-sm'>QTY</th>
                                            <th className='pb-5 text-sm'>PRICE</th>
                                            <th className='pb-5 text-sm'>SUBTOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr className='border-b-[1px] border-b-slate-300'>
                                            <td className='py-5'>
                                                <div className='flex flex-row items-center px-5 w-full'>
                                                    <ion-icon class="text-2xl mr-3" name="close-outline"></ion-icon>
                                                    <img className="object-cover w-36 h-36" src="/images/no-image.png" alt="" srcSet="/images/no-image.png" width={'auto'} height={'auto'} />
                                                </div>
                                            </td>
                                            <td>
                                                <h3 className="mb-3 text-md">Obeng Bintang XL</h3>
                                                <p className="mb-3 text-sm font-light text-gray-400">Black / XL</p>
                                                <p className="text-md font-light">Rp 30.000,-</p>
                                            </td>
                                            <td>5</td>
                                            <td>Rp 30.000</td>
                                            <td>Rp 30.000</td>
                                        </tr>
                                        <tr className='border-b-[1px] border-b-slate-300'>
                                            <td className='py-5'>
                                                <div className='flex flex-row items-center px-5 w-full'>
                                                    <ion-icon class="text-2xl mr-3" name="close-outline"></ion-icon>
                                                    <img className="object-cover w-36 h-36" src="/images/no-image.png" alt="" srcSet="/images/no-image.png" width={'auto'} height={'auto'} />
                                                </div>
                                            </td>
                                            <td>
                                                <h3 className="mb-3 text-md">Obeng Bintang XL</h3>
                                                <p className="mb-3 text-sm font-light text-gray-400">Black / XL</p>
                                                <p className="text-md font-light">Rp 30.000,-</p>
                                            </td>
                                            <td>5</td>
                                            <td>Rp 30.000</td>
                                            <td>Rp 30.000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div className='p-5 w-full md:w-2/5 bg-emerald-50'>
                        <div className='pb-3 mb-5 flex flex-row items-center justify-between border-b-[1px] border-b-gray-300'>
                            <p className='font-bold'>SUBTOTAL</p>
                            <p className='font-bold text-xl'>Rp 30.000,-</p>
                        </div>
                        <div className='pb-3 mb-5 flex flex-row items-center justify-between border-b-[1px] border-b-gray-300'>
                            <p className='font-bold'>DISKON</p>
                            <p className='font-bold text-xl'>Rp 30.000,-</p>
                        </div>
                        <div className='pb-3 mb-5 flex flex-row items-center justify-between border-b-[1px] border-b-gray-300'>
                            <p className='font-bold'>TAX</p>
                            <p className='font-bold text-xl'>Rp 30.000,-</p>
                        </div>
                        <div className='pb-3 flex flex-row items-center justify-between'>
                            <p className='font-bold text-2xl'>TOTAL</p>
                            <p className='font-bold text-2xl'>Rp 30.000,-</p>
                        </div>
                        <button className='w-full px-5 py-4 mt-5 font-bold text-white bg-slate-700'>CHECKOUT PESANAN</button>
                        <img className='w-[80%] mx-auto mt-5' src="/images/safepayment.png" alt="Safe Payment" srcSet="/images/safepayment.png" width={'auto'} height={'auto'} />
                    </div>
                </div>
            </div>
        </div>
    )
}
