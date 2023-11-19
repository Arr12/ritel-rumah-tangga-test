@php
        $headers = Session::get('headers');
        $title = $headers['title'];
        $author = $headers['author'];
        $site = url()->full();
        $thumbnail = "/images/logo.png";
        $keyword = $headers['keyword'];
        $description1 = $headers['description1'];
        $description2 = $headers['description2'];
        $style = $headers['style'];
        $url = url()->current();
@endphp

<meta charset="utf-8">
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width" />
<link rel="canonical" href="{{$url}}" />
<link rel="alternate" href="{{$url}}" hreflang="x-default" />
<link rel="alternate" href="{{$url}}" hreflang="en" />
<meta name="robots" content="noodp">
<title>{{$title}}</title>
<meta name="description" content="{{$description1}}" />
<meta name="keywords" itemprop="keywords" content="{{$keyword}}" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{{ $title }}" />
<meta property="og:description" content="{{$description2}}" />
<meta property="og:image" content="{{$thumbnail}}" />
<meta property="og:site_name" content="{{$site}}" />

<link rel="dns-prefetch" href="https://cdn.statically.io/">
<meta content='general' name='rating' />
<meta content='usa' name='geo.country' />
<meta name="theme-color" content="#444">
<meta name="robots" content="index,follow"/>
<meta name="googlebot-news" content="index,follow"/>
<meta name="googlebot" content="index,follow"/>
<meta name="copyright" content="Copyright © $YYYY {{$author}}" />
<meta name="Author" content="{{$author}}" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="" />
<meta name="twitter:title" content="{{ $title }}" />
<meta name="twitter:description" content="{{ $description2 }}" />
<meta name="twitter:image" content="???" />

<link rel="icon" href="/images/logo.png">
<link rel="apple-touch-icon" sizes="180x180" href="/images/logo.png">
<link rel="icon" type="image/png" sizes="32x32" href="/images/logo.png">
<link rel="icon" type="image/png" sizes="16x16" href="/images/logo.png">
<link rel="mask-icon" href="/images/logo.png" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-config" content="/sitemaps/sitemap_index.xml">
<meta name="theme-color" content="#ffffff">
