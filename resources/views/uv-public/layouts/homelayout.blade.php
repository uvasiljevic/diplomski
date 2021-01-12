<!DOCTYPE html>
<html lang="en">
<head>
    @include('uv-public.components.general.head')
    @yield('links')
</head>
<body>

<div class="super_container">

    <!-- Header -->

@include('uv-public.components.general.header')

<!-- Home -->

    <div class="home">
        @include('uv-public.components.home.homeslider')
    </div>

    <!-- Ads -->

@include('uv-public.components.home.ads')

<!-- Products -->

    <div class="products">
        @yield('products')
    </div>

    <!-- Ad -->

@include('uv-public.components.home.banner')

<!-- Icon Boxes -->

@include('uv-public.components.home.icons')


<!-- Footer -->

    <div class="footer_overlay"></div>
    <footer class="footer">
        @include('uv-public.components.general.footer')
    </footer>
</div>
@include('uv-public.components.general.scripts')
@yield('scripts')
</body>
</html>
