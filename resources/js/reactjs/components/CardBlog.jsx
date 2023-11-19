import React, {useEffect, useState} from "react";

export default function CardProduct({handleDelete, handleCart, title, category, price, star, label}) {
    const [wishlistIcon, setWishlistIcon] = useState(false);
    const stars = []
    for(let i = 0; i < Math.ceil(star); i++) {
        stars.push(<ion-icon class="text-orange-500" name="star"></ion-icon>)
    }
    return (
        <>
            <div className="flex flex-col justify-start cursor-pointer relative hoverShowSlideInTop" onMouseLeave={() => setWishlistIcon(false) } onMouseEnter={() => setWishlistIcon(true) }>
                <div className="absolute z-20 left-0 top-0 px-3 py-2 font-bold text-white bg-red-500">{label}</div>
                <div onClick={handleDelete} className="p-2 w-10 h-10 flex flex-row items-center justify-center bg-slate-700 absolute top-[-10px] right-[-10px] z-20 rounded-full">
                    <ion-icon class="text-3xl text-white cursor-pointer" name="close-outline"></ion-icon>
                </div>
                <div className="relative overflow-hidden">
                    <img className='h-80 object-cover' src={!wishlistIcon ? '/images/no-image.png' : '/images/blank-pp.png'} alt={title} srcSet={!wishlistIcon ? '/images/no-image.png' : '/images/blank-pp.png'} width={'auto'} height={'auto'} />
                    <div className={`flex flex-row justify-center items-center`}>
                        <ion-icon class={`icons-box absolute bottom-3 p-3 shadow-lg bg-white text-2xl`} name="heart-outline"></ion-icon>
                    </div>
                </div>
                <div className='mt-3 text-center'>
                    <span className='text-sm font-light mb-3'>{category}</span>
                    <h3 className='font-bold text-xl mb-3'>{title}</h3>
                    <p className="mb-3">Rp {price}</p>
                    <div className="flex flex-row items-center justify-center">
                        { stars }
                    </div>
                    <button onClick={handleCart} className="bg-slate-700 text-white px-7 py-4 font-bold mt-5">
                        Masuk Keranjang
                    </button>
                </div>
            </div>
        </>
    )
}
