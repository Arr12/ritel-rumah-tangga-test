<!DOCTYPE html>
<html lang="en" itemscope="itemscope" itemtype="https://schema.org/WebPage" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
    <head profile="https://gmpg.org/xfn/11">
        @include('includes.head')
        @stack('after-style')
        @stack('head-script')
        @vite('resources/css/app.css')
        @vite('resources/sass/styles.scss')
    </head>
    <body>
        @include('includes.navbar')

        @yield('content')

        @include('includes.footer')
        @stack('after-script')
        @vite('resources/js/reactjs/landing-page/app.jsx')
        @vite('resources/js/reactjs/checkout/app.jsx')
        @vite('resources/js/reactjs/wishlist/app.jsx')
        @vite('resources/js/reactjs/profile/app.jsx')
        @vite('resources/js/reactjs/login/app.jsx')
        @vite('resources/js/reactjs/register/app.jsx')
        @vite('resources/js/reactjs/profile/information/app.jsx')
        {{-- @vite('resources/js/reactjs/profile/order/app.jsx') --}}
        @vite('resources/js/app.js')
    </body>
</html>
