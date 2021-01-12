@extends('uv-public.layouts.authlayout')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{asset('uv-public/styles/main_styles.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('uv-public/styles/responsive.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('uv-public/styles/checkout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('uv-public/styles/checkout_responsive.css')}}">
@endsection

@section('content')
    <div class="checkout">
        <div class="container">
            <div class="row">

                <div class="col-lg-12">
                    <div class="billing checkout_section">
                        <div class="section_title">Log in</div>
                        <div class="section_subtitle">Don't have acount? Register <a href="{{url("/registration")}}">here</a></div>
                        <div class="section_subtitle" id="loginError" style="color: red;">
                            @isset($errors)
                                @foreach($errors->all() as $error)
                                    {{ $error }}<br/>
                                @endforeach
                            @endisset
                        </div>
                        <div class="section_subtitle" style="color: red;">
                            @if(session('messageError'))
                                {{ session('messageError') }}
                            @endif
                        </div>

                        <div class="checkout_form_container">
                            <form action="#" method="POST" id="login_form" class="checkout_form">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-6">
                                        <!-- Name -->
                                        <label for="checkout_name">Email*</label>
                                        <input type="text" id="email" name="email" class="checkout_input" required="required">
                                    </div>
                                    <div class="col-xl-6 last_name_col">
                                        <!-- Last Name -->
                                        <label for="checkout_last_name">Password*</label>
                                        <input type="password" id="password" name="password" class="checkout_input" required="required">
                                    </div>
                                </div>
                                <div class="button order_button"><input type="button" id="btnLog" name="btnLog" value="Log in"/></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('uv-public/js/auth.js')}}"></script>
@endsection
