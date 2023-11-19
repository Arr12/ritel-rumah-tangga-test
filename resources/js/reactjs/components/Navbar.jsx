import React, { useState } from "react";


export default function Navbar() {
    const Menus = [
        {
            title : 'Home',
            slug : '/'
        },
        {
            title : 'Shop',
            slug : '#shop'
        },
        {
            title : 'Product',
            slug : '#product'
        },
    ]
    const DropdownMenusUser = [
        {
            title : 'Sign In',
            slug : '/login',
            icon : <ion-icon class="text-xl mr-3" name="log-in-outline"></ion-icon>
        },
        {
            title : 'Register',
            slug : '/register',
            icon : <ion-icon class="text-xl mr-3" name="person-outline"></ion-icon>
        },
        {
            title : 'Profile',
            slug : '/profile',
            icon : <ion-icon class="text-xl mr-3" name="person-outline"></ion-icon>
        },
        // {
        //     title : 'Sign Out',
        //     slug : '/buyer/sign-out',
        //     icon : <ion-icon class="text-xl mr-3" name="log-out-outline"></ion-icon>
        // },
    ]
    const [isOpen, setIsOpen] = useState(false)
    const [isOpenCart, setIsOpenCart] = useState(false)
    const [isOpenDropdown, setIsOpenDropdown] = useState(false)
    return (
        <>
            <nav className="flex flex-row" itemScope itemType="http://schema.org/SiteNavigationElement">
                <div className="flex flex-row items-center justify-between w-full">
                    <div className="flex flex-col md:flex-row items-center">
                        <img onClick={() => window.location.replace('/')} className="h-16 lg:h-24 object-contain cursor-pointer" itemProp="name" src="/images/logo.png" alt="Logo" srcSet="/images/logo.png" width={'auto'} height={'auto'} />
                        <div className="hidden flex-col md:flex-row items-center lg:flex">
                            {
                                Menus.map((v, i) => {
                                    return (
                                        <a itemProp="name" className="mx-4" key={i} href={v.slug}>
                                            <p className="font-semibold">{v.title}</p>
                                        </a>
                                    )
                                })
                            }
                        </div>
                    </div>
                    <div className="p-2 flex-row items-center flex">
                        <div className="flex flex-row items-center mr-3">
                            <input className="hidden lg:block border-0 focus-visible:outline-none focus-visible:border-b-[1px] focus-visible:border-b-gray-500 p-2" type="text" name="" id="" placeholder="Search Here" />
                            <ion-icon class="text-2xl" name="search-outline"></ion-icon>
                        </div>
                        {/* <ion-icon class="text-2xl mx-3 cursor-pointer" name="settings-outline"></ion-icon> */}
                        <div className="relative">
                            <ion-icon onClick={() => setIsOpenDropdown(!isOpenDropdown)} class="text-2xl mx-3 cursor-pointer" name="person-outline"></ion-icon>
                            {
                                isOpenDropdown && (
                                    <div className="w-[170px] flex flex-col bg-white absolute top-8 left-[-30px] z-20 py-5 px-7 shadow-lg">
                                        {
                                            DropdownMenusUser.map((v, i) => {
                                                return (
                                                    <a href={v.slug}>
                                                        <div className="flex flex-row items-center my-2">
                                                            {v.icon}
                                                            <p>{v.title}</p>
                                                        </div>
                                                    </a>
                                                )
                                            })
                                        }
                                    </div>
                                )
                            }
                        </div>
                        <ion-icon onClick={() => window.location.replace('/buyer/wishlist')} class="text-2xl mx-3 cursor-pointer" name="heart-outline"></ion-icon>
                        <ion-icon onClick={() => setIsOpenCart(!isOpen)} class="text-2xl mx-3 cursor-pointer" name="cart-outline"></ion-icon>
                        <ion-icon onClick={() => setIsOpen(!isOpen)} class="block lg:hidden p-3 text-2xl cursor-pointer" name="menu-outline"></ion-icon>
                    </div>
                </div>
            </nav>
            {
                isOpenCart && (
                    <div className="fixed w-screen h-screen bg-[#00000096] top-0 z-50" itemScope itemType="http://schema.org/SiteNavigationElement">
                        <div className="fixed right-0 top-0 w-80 md:w-96 px-4 h-screen flex flex-col justify-between bg-white">
                            <div>
                                <div className="flex flex-row items-center py-5 border-b-[1px] border-b-gray-300 justify-between">
                                    <h3 className="font-bold">YOUR CART (2 ITEMS)</h3>
                                    <ion-icon onClick={() => setIsOpenCart(false)} class="text-2xl cursor-pointer" name="close-outline"></ion-icon>
                                </div>
                                <div className="flex flex-row items-center justify-between py-2 border-b-[1px] border-gray-300">
                                    <div className="flex flex-row items-center">
                                        <img className="object-contain w-28 h-36 mr-3" src="/images/no-image.png" alt="" srcSet="/images/no-image.png" width={'auto'} height={'auto'} />
                                        <div className="flex flex-col justify-center">
                                            <h3 className="mb-3 text-md">Obeng Bintang XL</h3>
                                            <p className="mb-3 text-sm font-light text-gray-400">Black / XL</p>
                                            <p className="text-md font-light">Rp 30.000,-</p>
                                        </div>
                                    </div>
                                    <ion-icon onClick={() => setIsOpenCart(false)} class="text-2xl cursor-pointer" name="close-outline"></ion-icon>
                                </div>
                            </div>
                            <div className="py-3">
                                <div className="flex items-center justify-between text-lg">
                                    <h3 className="font-bold">TOTAL:</h3>
                                    <p className="font-bold">Rp 30.000,-</p>
                                </div>
                                <div className="flex flex-row justify-between items-center mt-3">
                                    <button onClick={() => window.location.replace('/checkout')} className="bg-red-500 px-4 py-3 font-bold mr-1 text-white w-full">
                                        CHECK OUT
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                )
            }
            {
                isOpen && (
                    <div className="fixed left-0 top-0 w-56 h-screen flex flex-col bg-orange-500 z-20" itemScope itemType="http://schema.org/SiteNavigationElement">
                        <div className="flex justify-between w-full px-1 py-3 bg-orange-600">
                            <h3 className="ml-2 text-white font-semibold">MENU</h3>
                            <ion-icon onClick={() => setIsOpen(false)} class="text-white text-2xl" name="close-outline"></ion-icon>
                        </div>
                        <div className="flex flex-col">
                            {
                                Menus.map((v, i) => {
                                    return (
                                        <a itemProp="name" className="p-3 border-b-[1px] border-[#ffffff69]" key={i} href={v.slug}>
                                            <p className="text-sm text-white">{v.title}</p>
                                        </a>
                                    )
                                })
                            }
                        </div>
                        <div className="border-b-[1px] border-[#ffffff69] py-3">
                            <div className="flex flex-row items-center py-1 text-white">
                                <ion-icon class="text-xl mx-3" name="person-outline"></ion-icon>
                                <p className="text-sm">Register</p>
                            </div>
                            <div className="flex flex-row items-center py-1 text-white">
                                <ion-icon class="text-xl mx-3" name="log-in-outline"></ion-icon>
                                <p className="text-sm">Sign In</p>
                            </div>
                        </div>
                        <div className="border-b-[1px] border-[#ffffff69] py-3">
                            <h3 className="px-3 pb-2 font-bold text-white">Need Help?</h3>
                            <div className="flex flex-row items-center py-1 text-white">
                                <ion-icon class="text-xl mx-3" name="person-outline"></ion-icon>
                                <p className="text-sm">1366303</p>
                            </div>
                            <div className="flex flex-row items-center py-1 text-white">
                                <ion-icon class="text-xl mx-3" name="mail-outline"></ion-icon>
                                <p className="w-36 break-words text-sm">admin@tokoritelrumahtangga.com</p>
                            </div>
                        </div>
                        <div className="border-b-[1px] border-[#ffffff69] py-3">
                            <h3 className="px-3 pb-2 font-bold text-white">Follow Us?</h3>
                            <div className="flex flex-row items-center pt-1 text-white mx-3">
                                <ion-icon class="text-lg mr-2" name="logo-facebook"></ion-icon>
                                <ion-icon class="text-lg mr-2" name="logo-twitter"></ion-icon>
                                <ion-icon class="text-lg mr-2" name="logo-pinterest"></ion-icon>
                                <ion-icon class="text-lg mr-2" name="logo-linkedin"></ion-icon>
                                <ion-icon class="text-lg mr-2" name="logo-instagram"></ion-icon>
                                <ion-icon class="text-lg mr-2" name="logo-youtube"></ion-icon>
                            </div>
                        </div>
                    </div>
                )
            }
        </>
    )
}
