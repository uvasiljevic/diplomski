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

<!-- Checkout -->

@yield('content')

<!-- Footer -->

    <div class="footer_overlay"></div>
    <footer class="footer">
        @include('uv-public.components.general.footer')
    </footer>
</div>

@include('uv-public.components.general.scripts')
@yield('scripts')
</html>
