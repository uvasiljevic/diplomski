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
                        <div class="section_title">Registration</div>
                        <div class="section_subtitle">Already have account? Log in <a href="{{url("/login")}}">here</a></div>
                        <div class="section_subtitle" id="regError" style="color: red;">
{{--                            @isset($errors)--}}
{{--                                @foreach($errors->all() as $error)--}}
{{--                                    {{ $error }}<br/>--}}
{{--                                @endforeach--}}
{{--                            @endisset--}}
                        </div>
                        <div class="checkout_form_container">
                            <form action="#" method="POST" id="register_form" class="checkout_form">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-6">
                                        <!-- Name -->
                                        <label for="checkout_name">First Name*</label>
                                        <input type="text" id="r_firstname" name="r_firstname" class="checkout_input" required="required">
                                    </div>
                                    <div class="col-xl-6 last_name_col">
                                        <!-- Last Name -->
                                        <label for="checkout_last_name">Last Name*</label>
                                        <input type="text" id="r_lastname" name="r_lastname" class="checkout_input" required="required">
                                    </div>
                                    <div class="col-xl-6">
                                        <!-- Name -->
                                        <label for="checkout_name">Email*</label>
                                        <input type="text" id="r_email" name="r_email" class="checkout_input" required="required">
                                    </div>
                                    <div class="col-xl-6 last_name_col">
                                        <!-- Last Name -->
                                        <label for="checkout_last_name">Phone*</label>
                                        <input type="text" id="r_phone" name="r_phone" class="checkout_input" required="required">
                                    </div>
                                    <div class="col-xl-6">
                                        <!-- Name -->
                                        <label for="checkout_name">City*</label>
                                        <input type="text" id="r_city" name="r_city" class="checkout_input" required="required">
                                    </div>
                                    <div class="col-xl-6 last_name_col">
                                        <!-- Last Name -->
                                        <label for="checkout_last_name">Zip code*</label>
                                        <input type="number" id="r_zip" name="r_zip" class="checkout_input" required="required">
                                    </div>
                                    <div class="col-xl-6">
                                        <!-- Name -->
                                        <label for="checkout_name">Street*</label>
                                        <input type="text" id="r_street" name="r_street" class="checkout_input" required="required">
                                    </div>
                                    <div class="col-xl-6 last_name_col">
                                        <!-- Last Name -->
                                        <label for="checkout_last_name">Street number*</label>
                                        <input type="text" id="r_streetNumber" name="r_streetNumber" class="checkout_input" required="required">
                                    </div>
                                    <div class="col-xl-6">
                                        <!-- Name -->
                                        <label for="checkout_name">Password*</label>
                                        <input type="password" id="r_password" name="r_password" class="checkout_input" required="required">
                                    </div>
                                    <div class="col-xl-6 last_name_col">
                                        <!-- Last Name -->
                                        <label for="checkout_last_name">Re-type password*</label>
                                        <input type="password" id="r_password_confirmation" name="r_password_confirmation" class="checkout_input" required="required">
                                    </div>
                                </div>
                                <div class="button order_button"><input type="button" name="r_btnReg" id="r_btnReg" value="Registration"/></div>
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
