import React, { useEffect, useState } from 'react'
import CardProduct from '../components/CardProduct';
import axios from 'axios';

export default function Wishlist() {
    return (
        <>
            <div className="py-14 px-5 md:px-10 bg-green-50 flex flex-row flex-wrap items-center justify-between">
                <h1 className="font-bold text-2xl">WISHLIST</h1>
                <div className="flex flex-row items-center mt-3">
                    <p className="mr-2 text-sm">HOME</p>
                    <ion-icon name="chevron-forward-outline"></ion-icon>
                    <p className="mx-2 text-sm font-bold">WISHLIST</p>
                </div>
            </div>
            <div className='border-[1px] border-gray-100 grid grid-cols-5'>
                <div className='p-5 my-5'>
                    <CardProduct
                        handleDelete={''}
                        handleCart={''}
                        type={'1'}
                        title={'Undefined'}
                        category={''}
                        price={'30000'}
                        star={4.5}
                        label={'SALE'}
                    />
                </div>
            </div>
        </>
    )
}
