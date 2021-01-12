<div class="avds">
    <div class="avds_container d-flex flex-lg-row flex-column align-items-start justify-content-between">
        <div class="avds_small">

            @php
                $image = $smallAd[0]->image;
                $imageDiscount = $smallAd[0]->imageDiscount;
                $link = $smallAd[0]->permalink;
                $discount = $smallAd[0]->discount;
                $titleSmall = $smallAd[0]->title;

                $imgLarge = $largeAd[0]->image;
                $titleLarge = $largeAd[0]->title;
                $text = $largeAd[0]->text;
                $linkLarge = $largeAd[0]->permalink;
            @endphp
            <div class="avds_background" style="background-image:url({{asset("uv-public/images/$image")}})"></div>
            <div class="avds_small_inner">
                <div class="avds_discount_container">
                    <img src="{{asset("uv-public/images/$imageDiscount")}}" alt="">
                    <div>
                        <div class="avds_discount">
                            <div>{{$discount}}<span>%</span></div>
                            <div>Discount</div>
                        </div>
                    </div>
                </div>
                <div class="avds_small_content">
                    <div class="avds_title">{{$titleSmall}}</div>
                    <div class="avds_link"><a href="{{url("/$link")}}">See More</a></div>
                </div>
            </div>
        </div>
        <div class="avds_large">
            <div class="avds_background" style="background-image:url({{asset("uv-public/images/$imgLarge")}})"></div>
            <div class="avds_large_container">
                <div class="avds_large_content">
                    <div class="avds_title">{{$titleLarge}}</div>
                    <div class="avds_text">{{$text}}</div>
                    <div class="avds_link avds_link_large"><a href="{{url("/$linkLarge")}}">See More</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
