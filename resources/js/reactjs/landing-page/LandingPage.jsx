import React, { useEffect, useState } from 'react'
import { Carousel } from 'react-carousel-minimal'
import Slider from 'react-slick'
import axios from 'axios';
import CardProduct from '../components/CardProduct';
import { formatRupiah } from '../../helpers/function_react';

export default function LandingPage() {
    const settings = {
        infinite: true,
        speed: 500,
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [
            {
              breakpoint: 320,
              settings: {
                slidesToShow: 1,
              },
              arrows: false,
            },
            {
              breakpoint: 350,
              settings: {
                slidesToShow: 2,
              },
              arrows: false,
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 2,
              },
              arrows: false,
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 3,
              },
              arrows: false,
            },
        ],
    };
    const [ dataProductCategories, setDataProductCategories ] = useState([])
    const fetchDataProductCategories = () => {
        axios
        .get('/api/categories')
        .then((response) => {
            setDataProductCategories(response)
        })
        .catch((e) => {
            console.log(e);
        })
    }
    useEffect(() => {
        if(dataProductCategories.length === 0) {
            fetchDataProductCategories()
        }
    }, [dataProductCategories])

    const [ dataCategories, setDataCategories ] = useState([])
    const fetchDataCategories = () => {
        axios.get('/api/categories')
        .then((response) => {
            setDataCategories(response);
            setActiveProduct(response?.data?.data[0].products[0].categories_id);
            fetchDataProduct(response?.data?.data[0].products[0].categories_id, 12, 0);
        })
        .catch((e) => {
            console.log(e);
        })
    }

    useEffect(() => {
        if(dataCategories.length === 0) {
            fetchDataCategories()
        }
    }, [dataCategories])

    const [ activeProduct, setActiveProduct ] = useState(1)
    const [ dataProduct, setDataProduct ] = useState([])
    const fetchDataProduct = async (categories_id, limit, skip) => {
        await axios
        .get(`/api/products/edit?type=categories&categories_id=${categories_id}`)
        .then((response) => {
            setDataProduct(response)
            // setActiveProduct(response?.data?.data[0].id)
        })
        .catch((e) => {
            console.log(e);
        })
    }

    const handleClickCategories = (category) => {
        setActiveProduct(category)
        fetchDataProduct(category, 10, 0)
    }

    const data = [
        {
          image: "https://upload.wikimedia.org/wikipedia/commons/thumb/0/0c/GoldenGateBridge-001.jpg/1200px-GoldenGateBridge-001.jpg",
          caption:`
                <div class="block md:hidden mt-[40px] bg-white w-52 m-auto p-5">
                    <h2 class="text-base md:text-3xl font-bold mb-5 text-gray-700 md:text-white">High Performance <br /> Industrial Tools</h2>
                    <a href="#" class="px-3 py-2 bg-orange-500 text-xs font-semibold">
                        ORDER NOW
                    </a>
                </div>
                <div class="hidden md:block mt-[200px]">
                    <p class="text-sm md:text-base italic">We are leading hand tools manufacturer</p>
                    <h2 class="text-base md:text-3xl font-bold my-5">High Performance <br /> Industrial Tools</h2>
                    <p class="text-sm md:text-base mb-5">We are leading hand tools manufacturer</p>
                    <a href="#" class="px-3 py-2 bg-orange-500 text-xs font-semibold">
                        ORDER NOW
                    </a>
                </div>
          `
        },
        {
          image: "https://cdn.britannica.com/s:800x450,c:crop/35/204435-138-2F2B745A/Time-lapse-hyper-lapse-Isle-Skye-Scotland.jpg",
          caption: `
                <div class="block md:hidden mt-[40px] bg-white w-52 m-auto p-5">
                    <h2 class="text-base md:text-3xl font-bold text-gray-700 md:text-white mb-5">Profesional Tools</h2>
                    <a href="#" class="px-3 py-2 bg-orange-500 text-xs font-semibold">
                        ORDER NOW
                    </a>
                </div>
                <div class="hidden md:block mt-[200px]">
                    <p class="text-sm md:text-base italic">We are leading hand tools manufacturer</p>
                    <h2 class="text-base md:text-3xl font-bold my-5">Profesional Tools</h2>
                    <p class="text-sm md:text-base mb-5">We are leading hand tools manufacturer</p>
                    <a href="#" class="px-3 py-2 bg-orange-500 text-xs font-semibold">
                        ORDER NOW
                    </a>
                </div>
            `
        }
    ];

    return (
        <div>
            <Carousel
                data={data}
                time={4000}
                width="auto"
                height="580px"
                radius="0"
                captionPosition="top"
                automatic={true}
                dots={true}
                pauseIconColor="grey"
                pauseIconSize="40px"
                slideBackgroundColor="white"
                slideImageFit="cover"
            />
            <div className='flex flex-col items-center justify-center py-10 bg-green-50'>
                <h2 className='font-bold text-base md:text-3xl ml-3 mb-6'>BELANJA BERDASARKAN KATEGORI</h2>
                <Slider className='w-[80%] md:w-[90%] mx-auto' {...settings}>
                    {
                        dataProductCategories?.data?.data?.length > 0 && dataProductCategories?.data?.data?.map((v, i) => {
                            return (
                                <div className="flex flex-row justify-center items-center my-10 p-3 cursor-pointer">
                                    <div className='bg-white py-5'>
                                        <img className='h-40 object-cover m-auto' src={JSON.parse(v?.thumbnail)} alt={v.name} width={'auto'} height={'auto'} />
                                        <div className='text-center mt-3'>
                                            <h3 className='font-bold'>{v.name}</h3>
                                            <p>{v?.product?.length} Products</p>
                                        </div>
                                    </div>
                                </div>
                            )
                        })
                    }
                </Slider>
            </div>
            <div className='flex flex-col items-center justify-center py-12 w-[95%] mx-auto'>
                <div className='flex flex-row flex-wrap items-center'>
                    {
                        dataCategories?.data?.data?.length > 0 && dataCategories?.data?.data?.map((v, i) => {
                            return (
                                <p onClick={() => handleClickCategories(v.id) } className={`font-bold cursor-pointer text-sm md:text-xl mx-3 mb-3 pb-3 ${ activeProduct == v.id ? 'border-b-2 border-gray-700' : '' }`}>
                                    { v.name }
                                </p>
                            )
                        })
                    }
                </div>
                <div className='grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4'>
                    {
                        dataProduct?.data?.data?.length > 0 && dataProduct?.data?.data?.map((v, i) => {
                            return (
                                <div className='p-5 my-5'>
                                    <CardProduct
                                        handleDelete={''}
                                        handleCart={''}
                                        type={'2'}
                                        title={ v.name }
                                        category={ v.categories.name }
                                        price={ formatRupiah(v.price) }
                                        star={ v.rating }
                                        label={'SALE'}
                                    />
                                </div>
                            )
                        })
                    }
                </div>
                {/* <div className='flex flex-row items-center justify-center'>
                    <a href="#" class="mt-5 px-10 py-4 bg-cyan-500 text-lg font-semibold text-center text-white">
                        LIHAT SEMUA
                    </a>
                </div> */}
            </div>
            <div className='flex flex-col items-center justify-center px-4 py-5 w-[95%] mx-auto bg-cyan-500 text-white my-5'>
                <p>Agar kamu tidak salah pilih, <b>pastikan pembelian dilakukan secara cermat dan teliti.</b></p>
            </div>
            <div className='w-[95%] mx-auto flex flex-col md:flex-row items-center relative py-10'>
                <div className='flex flex-col w-full lg:w-[40%] relative'>
                    <img className='h-[380px] object-cover' src="/images/bg-1.jpg" alt="Promotion Picture 1" srcSet="/images/bg-1.jpg" />
                    <div className='absolute top-1/2 left-5'>
                        <h2 className='text-white font-bold text-3xl'>CONSTRUCTION <br />TOOLS</h2>
                        <p className='text-white font-bold mt-3'>25 Products</p>
                    </div>
                </div>
                <div className='flex flex-col w-full lg:w-[20%] relative h-full'>
                    <div className="text-white text-center relative lg:w-[90%] lg:mx-auto">
                        <img className='w-full object-cover h-[380px]' src="/images/themes-disc.jpg" alt="Theme Discount" srcSet="/images/themes-disc.jpg" width={'auto'} height={'auto'} />
                        <div className='absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 p-5'>
                            <p className='px-6 pb-5 font-bold'>SUPER SALE</p>
                            <h2 className='font-bold'>
                                GET 40%
                                <p className='text-4xl my-3'>OFF</p>
                                ALL PRODUCTS
                            </h2>
                        </div>
                    </div>
                </div>
                <div className='flex flex-col w-full lg:w-[40%] relative'>
                    <img className='h-[380px] object-cover' src="/images/bg-2.jpg" alt="Promotion Picture 1" srcSet="/images/bg-2.jpg" />
                    <div className='absolute top-1/2 right-5'>
                        <h2 className='text-white font-bold text-3xl'>GARDEN <br />TOOLS</h2>
                        <p className='text-white font-bold mt-3'>25 Products</p>
                    </div>
                </div>
            </div>
            <div className='p-5 flex flex-row items-center justify-center bg-red-500'>
                <svg className='w-11 h-11' fill="#fff" width="800px" height="800px" viewBox="0 -64 640 640" xmlns="http://www.w3.org/2000/svg"><path d="M624 352h-16V243.9c0-12.7-5.1-24.9-14.1-33.9L494 110.1c-9-9-21.2-14.1-33.9-14.1H416V48c0-26.5-21.5-48-48-48H112C85.5 0 64 21.5 64 48v48H8c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h272c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H40c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h208c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H8c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h208c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H64v128c0 53 43 96 96 96s96-43 96-96h128c0 53 43 96 96 96s96-43 96-96h48c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zM160 464c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm320 0c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm80-208H416V144h44.1l99.9 99.9V256z"/></svg>
                <p className='ml-3 text-white'><b>100% KIRIMAN CEPAT</b>- NIKMATI GRATIS ONGKIR</p>
                <a href="#" className="px-4 py-3 bg-slate-100 text-sm font-bold text-center text-gray-800 ml-3">
                    BELANJA SEKARANG
                </a>
            </div>
        </div>
    )
}
