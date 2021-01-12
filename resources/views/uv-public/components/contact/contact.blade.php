@extends('uv-public.layouts.pageslayout')
@section('links')
    <link rel="stylesheet" type="text/css" href="uv-public/styles/main_styles.css">
    <link rel="stylesheet" type="text/css" href="uv-public/styles/responsive.css">
    <link rel="stylesheet" type="text/css" href="uv-public/styles/contact.css">
    <link rel="stylesheet" type="text/css" href="uv-public/styles/contact_responsive.css">
@endsection
@section('content')
    <div class="contact">
        <div class="container">
            <div class="row">

                <!-- Get in touch -->
                <div class="col-lg-8 contact_col">
                    <div class="get_in_touch">
                        <div class="section_title" style="color: green;">Get in Touch</div>
                        <div class="section_subtitle">Say hello</div>
                        <div class="section_subtitle" style="color: green;">
                            @if(session('message'))
                                {{ session('message') }}
                            @endif
                        </div>
                        <div class="section_subtitle" style="color: red;">
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
                        <div class="contact_form_container">
                            <form action="{{url("/sendmail")}}" method="POST" id="contact_form" class="contact_form">
                                @csrf
                                <div>
                                    <!-- Subject -->
                                    <label for="contact_company">Your email</label>
                                    @if(session()->has('user'))
                                        <input type="email" id="contact_email" name="contact_email" class="contact_input" required="required" value="{{session()->get('user')->email}}"/>
                                    @else
                                        <input type="email" id="contact_email" name="contact_email" class="contact_input" required="required">
                                    @endif
                                </div>
                                <div>
                                    <label for="contact_textarea">Message*</label>
                                    <textarea id="contact_message" id="contact_message" name="contact_message" class="contact_input contact_textarea" required="required"></textarea>
                                </div>
                                <button class="button contact_button"><input type="submit" name="btnContact" value="Send message"/></button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-3 offset-xl-1 contact_col">
                    <div class="contact_info">
                        <div class="contact_info_section">
                            <div class="contact_info_title">Marketing</div>
                            <ul>
                                <li>Phone: <span>+53 345 7953 3245</span></li>
                                <li>Email: <span>yourmail@gmail.com</span></li>
                            </ul>
                        </div>
                        <div class="contact_info_section">
                            <div class="contact_info_title">Shippiing & Returns</div>
                            <ul>
                                <li>Phone: <span>+53 345 7953 3245</span></li>
                                <li>Email: <span>yourmail@gmail.com</span></li>
                            </ul>
                        </div>
                        <div class="contact_info_section">
                            <div class="contact_info_title">Information</div>
                            <ul>
                                <li>Phone: <span>+53 345 7953 3245</span></li>
                                <li>Email: <span>yourmail@gmail.com</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row map_row">
                <div class="col">

                    <!-- Google Map -->
                    <div class="map">
                        <div id="google_map" class="google_map">
                            <div class="map_container">
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCIwF204lFZg1y4kPSIhKaHEXMLYxxuMhA"></script>
    <script src="uv-public/js/contact.js"></script>
@endsection
