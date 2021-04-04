<!DOCTYPE html>
<html lang="en">

<head>
    @include('uv-admin.components.general.head')
</head>

<body class="animsition">
<div class="page-wrapper">
    <!-- HEADER MOBILE-->
    @include('uv-admin.components.general.headermobile')

    <!-- END HEADER MOBILE-->

    <!-- MENU SIDEBAR-->
    @include('uv-admin.components.general.menu')
    <!-- END MENU SIDEBAR-->

    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <!-- HEADER DESKTOP-->
        @include('uv-admin.components.general.headerdesktop')
        <!-- HEADER DESKTOP-->

        <!-- MAIN CONTENT-->
        <div class="main-content">
            @yield('content')
        </div>
        <!-- END MAIN CONTENT-->
        <!-- END PAGE CONTAINER-->
    </div>

</div>

<!-- SCRIPTS-->
@include('uv-admin.components.general.scripts')
@yield('scripts')
<!-- END SCRIPTS-->

</body>

</html>
<!-- end document-->
