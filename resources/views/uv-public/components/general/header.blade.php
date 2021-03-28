<header class="header">
    <div class="header_container">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header_content d-flex flex-row align-items-center justify-content-start">
                        <div class="logo"><a href="/">Sublime.</a></div>
                        <nav class="main_nav">
                            <ul>
                                @foreach($menu as $m)
                                    @isset($m->categories)
                                        @if(count($m->categories)>0)
                                            <li class="hassubs">
                                        @else
                                            <li>
                                                @endif
                                                @endisset
                                                <a href="{{url("/$m->permalink")}}">{{$m->title}}</a>
                                                @isset($m->categories)
                                                    @if(count($m->categories)>0)
                                                        <ul>
                                                            @foreach($m->categories as $mc)
                                                                <li><a href="{{url("/$mc->permalink")}}">{{$mc->name}}</a></li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                @endisset
                                            </li>
                                            @endforeach
                                            @if(session()->has('user') && session()->get('user')->roleId == 1)
                                                <li><a href="{{url("/admin")}}">Admin</a></li>
                                            @endif
                                            @if(session()->has('user') && session()->get('user')->roleId == 2)
                                                <li><a href="{{url("/myaccount")}}">My account</a></li>
                                            @endif
                            </ul>
                        </nav>

                        <div class="header_extra ml-auto">
                                <div class="shopping_cart">
                                    <a href="/cart">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             viewBox="0 0 489 489" style="enable-background:new 0 0 489 489;" xml:space="preserve">
											<g>
                                                <path d="M440.1,422.7l-28-315.3c-0.6-7-6.5-12.3-13.4-12.3h-57.6C340.3,42.5,297.3,0,244.5,0s-95.8,42.5-96.6,95.1H90.3
													c-7,0-12.8,5.3-13.4,12.3l-28,315.3c0,0.4-0.1,0.8-0.1,1.2c0,35.9,32.9,65.1,73.4,65.1h244.6c40.5,0,73.4-29.2,73.4-65.1
													C440.2,423.5,440.2,423.1,440.1,422.7z M244.5,27c37.9,0,68.8,30.4,69.6,68.1H174.9C175.7,57.4,206.6,27,244.5,27z M366.8,462
													H122.2c-25.4,0-46-16.8-46.4-37.5l26.8-302.3h45.2v41c0,7.5,6,13.5,13.5,13.5s13.5-6,13.5-13.5v-41h139.3v41
													c0,7.5,6,13.5,13.5,13.5s13.5-6,13.5-13.5v-41h45.2l26.9,302.3C412.8,445.2,392.1,462,366.8,462z"/>
                                            </g>
										</svg>
                                        <div>Cart <span id="countCart">
                                                @if(session()->has('cart'))
                                                ({{$countCart}})
                                                @else
                                                (0)
                                                @endif
                                        </span></div>
                                    </a>
                                </div>
                            @if(!session()->has('user'))
                                <div class="search">
                                    <div class="search_icon">
                                        <a href="{{url("/login")}}" title="Log in"><i class="glyphicon glyphicon-user"></i></a>
                                    </div>
                                </div>

                            @else
                                <div class="search">
                                    <a href="{{url("/logout")}}" title="Log out"><i class="glyphicon glyphicon-log-out"></i></a>
                                </div>
                            @endif
                            <div class="hamburger"><i class="fa fa-bars" aria-hidden="true"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Social -->
    <div class="header_social">
        <ul>
            <li><a href="https://www.pinterest.com/" target="blank"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
            <li><a href="https://www.instagram.com/" target="blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
            <li><a href="https://www.facebook.com/" target="blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
            <li><a href="https://www.twitter.com/" target="blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
        </ul>
    </div>
</header>

<!-- Menu -->

<div class="menu menu_mm trans_300">
    <div class="menu_container menu_mm">
        <div class="page_menu_content">

            <ul class="page_menu_nav menu_mm">

                @foreach($menu as $m)
                    @isset($m->categories)
                        @if(count($m->categories)>0)
                            <li class="page_menu_item has-children menu_mm">
                        @else
                            <li class="page_menu_item menu_mm">
                                @endif
                                @endisset
                                <a href="{{url("/$m->permalink")}}">{{$m->title}}<i class="fa fa-angle-down"></i></a>
                                @isset($m->categories)
                                    @if(count($m->categories)>0)
                                        <ul class="page_menu_selection menu_mm">
                                            @foreach($m->categories as $mc)
                                                <li class="page_menu_item menu_mm"><a href="{{url("/$mc->permalink")}}">{{$mc->name}}</a></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @endisset
                            </li>
                            @endforeach
                            @if(session()->has('user') && session()->get('user')->roleId == 1)
                                <li class="page_menu_item menu_mm"><a href="{{url("/admin")}}">Admin</a></li>
                            @endif
                            @if(session()->has('user') && session()->get('user')->roleId == 2)
                                <li><a href="{{url("/myaccount")}}">My account</a></li>
                            @endif
                            @if(!session()->has('user'))
                                <li class="page_menu_item menu_mm"><a href="/login" title="Log in">Login</a></li>
                            @else
                                <li class="page_menu_item menu_mm"><a href="/logout" title="Log out">Log out</a></li>
                            @endif
            </ul>

        </div>
    </div>

    <div class="menu_close"><i class="fa fa-times" aria-hidden="true"></i></div>

    <div class="menu_social">
        <ul>
            <li><a href="https://www.pinterest.com/" target="blank"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
            <li><a href="https://www.instagram.com/" target="blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
            <li><a href="https://www.facebook.com/" target="blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
            <li><a href="https://www.twitter.com/" target="blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
        </ul>
    </div>
</div>
