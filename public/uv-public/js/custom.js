/* JS Document */

/******************************

[Table of Contents]

1. Vars and Inits
2. Set Header
3. Init Home Slider
4. Init Search
5. Init Menu
6. Init Isotope


******************************/

$(document).ready(function()
{
	"use strict";

	/*

	1. Vars and Inits

	*/

	var header = $('.header');
	var hambActive = false;
	var menuActive = false;

	setHeader();

	$(window).on('resize', function()
	{
		setHeader();
	});

	$(document).on('scroll', function()
	{
		setHeader();
	});

	initHomeSlider();
	initSearch();
	initMenu();
	initIsotope();
    addToCart();
    countCard();
    clearCart();
    makeOrder();

    $(document).on('change', '.cart-product-quantity', function(e){
        e.preventDefault();
        updateCartItem(this);
    });
    /*

    2. Set Header

    */

	function setHeader()
	{
		if($(window).scrollTop() > 100)
		{
			header.addClass('scrolled');
		}
		else
		{
			header.removeClass('scrolled');
		}
	}

	/*

	3. Init Home Slider

	*/

	function initHomeSlider()
	{
		if($('.home_slider').length)
		{
			var homeSlider = $('.home_slider');
			homeSlider.owlCarousel(
			{
				items:1,
				autoplay:true,
				autoplayTimeout:10000,
				loop:true,
				nav:false,
				smartSpeed:1200,
				dotsSpeed:1200,
				fluidSpeed:1200
			});

			/* Custom dots events */
			if($('.home_slider_custom_dot').length)
			{
				$('.home_slider_custom_dot').on('click', function()
				{
					$('.home_slider_custom_dot').removeClass('active');
					$(this).addClass('active');
					homeSlider.trigger('to.owl.carousel', [$(this).index(), 1200]);
				});
			}

			/* Change active class for dots when slide changes by nav or touch */
			homeSlider.on('changed.owl.carousel', function(event)
			{
				$('.home_slider_custom_dot').removeClass('active');
				$('.home_slider_custom_dots li').eq(event.page.index).addClass('active');
			});

			// add animate.css class(es) to the elements to be animated
			function setAnimation ( _elem, _InOut )
			{
				// Store all animationend event name in a string.
				// cf animate.css documentation
				var animationEndEvent = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';

				_elem.each ( function ()
				{
					var $elem = $(this);
					var $animationType = 'animated ' + $elem.data( 'animation-' + _InOut );

					$elem.addClass($animationType).one(animationEndEvent, function ()
					{
						$elem.removeClass($animationType); // remove animate.css Class at the end of the animations
					});
				});
			}

			// Fired before current slide change
			homeSlider.on('change.owl.carousel', function(event)
			{
				var $currentItem = $('.home_slider_item', homeSlider).eq(event.item.index);
				var $elemsToanim = $currentItem.find("[data-animation-out]");
				setAnimation ($elemsToanim, 'out');
			});

			// Fired after current slide has been changed
			homeSlider.on('changed.owl.carousel', function(event)
			{
				var $currentItem = $('.home_slider_item', homeSlider).eq(event.item.index);
				var $elemsToanim = $currentItem.find("[data-animation-in]");
				setAnimation ($elemsToanim, 'in');
			})
		}
	}

	/*

	4. Init Search

	*/

	function initSearch()
	{
		if($('.search').length && $('.search_panel').length)
		{
			var search = $('.search');
			var panel = $('.search_panel');

			search.on('click', function()
			{
				panel.toggleClass('active');
			});
		}
	}

	/*

	5. Init Menu

	*/

	function initMenu()
	{
		if($('.hamburger').length)
		{
			var hamb = $('.hamburger');

			hamb.on('click', function(event)
			{
				event.stopPropagation();

				if(!menuActive)
				{
					openMenu();

					$(document).one('click', function cls(e)
					{
						if($(e.target).hasClass('menu_mm'))
						{
							$(document).one('click', cls);
						}
						else
						{
							closeMenu();
						}
					});
				}
				else
				{
					$('.menu').removeClass('active');
					menuActive = false;
				}
			});

			//Handle page menu
			if($('.page_menu_item').length)
			{
				var items = $('.page_menu_item');
				items.each(function()
				{
					var item = $(this);

					item.on('click', function(evt)
					{
						if(item.hasClass('has-children'))
						{
							evt.preventDefault();
							evt.stopPropagation();
							var subItem = item.find('> ul');
						    if(subItem.hasClass('active'))
						    {
						    	subItem.toggleClass('active');
								TweenMax.to(subItem, 0.3, {height:0});
						    }
						    else
						    {
						    	subItem.toggleClass('active');
						    	TweenMax.set(subItem, {height:"auto"});
								TweenMax.from(subItem, 0.3, {height:0});
						    }
						}
						else
						{
							evt.stopPropagation();
						}
					});
				});
			}
		}
	}

	function openMenu()
	{
		var fs = $('.menu');
		fs.addClass('active');
		hambActive = true;
		menuActive = true;
	}

	function closeMenu()
	{
		var fs = $('.menu');
		fs.removeClass('active');
		hambActive = false;
		menuActive = false;
	}

	/*

	6. Init Isotope

	*/

	function initIsotope()
	{
		var sortingButtons = $('.product_sorting_btn');
		var sortNums = $('.num_sorting_btn');

		if($('.product_grid').length)
		{
			var grid = $('.product_grid').isotope({
				itemSelector: '.product',
				layoutMode: 'fitRows',
				fitRows:
				{
					gutter: 30
				},
	            getSortData:
	            {
	            	price: function(itemElement)
	            	{
	            		var priceEle = $(itemElement).find('.product_price').text().replace( '$', '' );
	            		return parseFloat(priceEle);
	            	},
	            	name: '.product_name',
	            	stars: function(itemElement)
	            	{
	            		var starsEle = $(itemElement).find('.rating');
	            		var stars = starsEle.attr("data-rating");
	            		return stars;
	            	}
	            },
	            animationOptions:
	            {
	                duration: 750,
	                easing: 'linear',
	                queue: false
	            }
	        });
		}
	}

	function addToCart(){
        $('#btnAddToCart').on('click', function(e){

            e.preventDefault();
            var info      = $('#cartInfo').html('');

            $.ajax({
                url:window.location+"/add-to-cart",
                method:"post",
                data: $("#product_form").serialize(),
                dataType:"json",
                success: function(res){
                    info.html(successMessage(res.message));
                    localStorage.setItem("countCard", res.countCart);
                    countCard();
                },
                error: function(res){
                    info.html(errorMessage(res.responseJSON.message));
                }
            })

        });
    }

    function successMessage(message){
	    var html = '<div class="alert alert-success">'+message+'</div>'

        return html;
    }

    function errorMessage(message){
        var html = '<div class="alert alert-danger">'+message+'</div>'

        return html;
    }


    function countCard(){
        var countCart = $('#countCart');

        if(localStorage.getItem("countCard") !== 'undefined' && localStorage.getItem("countCard") != null){
            countCart.html('('+ localStorage.getItem("countCard")+')');
        }else{
            countCart.html('(0)');
        }
    }

    function clearCart(){

        $('#btnClearCart').on('click', function (e) {
            var validator = confirm('Are you sure?');
            e.preventDefault();
            if(validator){
                $.ajax({

                    url: window.location+'/clear-cart',
                    method: "delete",
                    dataType: 'json',
                    data: $('#clearCart').serialize(),
                    success: function(){
                        localStorage.removeItem("countCard");
                        countCard();
                        cartNoContent();

                    },
                    error: function(data){
                    }
                });
            }
        })


    }

    function cartNoContent(){
        var html = `<div class="row row_cart_buttons">
                    <div class="col">
                        <div class="alert alert-danger">
                            There is no products in cart.
                        </div>
                        <div class="cart_buttons d-flex flex-lg-row flex-column align-items-start justify-content-start">
                            <div class="button continue_shopping_button"><a href="/products">Continue shopping</a></div>
                        </div>
                    </div>
                </div>`

        $('.cart_info .container').html(html);
    }


    function updateCartItem(thisParameter){

        var quantity   = $(thisParameter).val();
        var productId  = $(thisParameter).data('productid');
        $.ajax({
            url: window.location + '/update-cart-item',
            method: "post",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{
                quantity:  quantity,
                productId: productId
            },
            success: function(res){
                localStorage.setItem("countCard", res.countCart);
                writeCartItems(res.cart);
                countCard();
                $('#total_cart_price').html('$'+res.totalCartPrice);
                $('#total_for_pay').html('$'+res.totalForPay);

            }
        });

    }

    function writeCartItems(items){
	    var html = '';
	    var info = '';
        if(items)
        {
            for(let item of items){
                html += `<div class="cart_item d-flex flex-lg-row flex-column align-items-lg-center align-items-start justify-content-start">
                        <!-- Name -->
                        <div class="cart_item_product d-flex flex-row align-items-center justify-content-start">
                            <div class="cart_item_image">
                                <div><img src="uv-public/images/${item.image}" alt=""></div>
                            </div>
                            <div class="cart_item_name_container">
                                <div class="cart_item_name"><a href="${item.permalink}">${item.productName}</a></div>
                                <div class="cart_item_edit"><a href="#">Remove</a></div>
                            </div>
                        </div>
                        <!-- Price -->
                        <div class="cart_item_price">$${item.price}</div>
                        <!-- Quantity -->
                        <div class="cart_item_quantity">
                            <div class="product_quantity_container">
                                <div class="product_quantity clearfix">
                                    <span>Qty</span>
                                    <input class="cart-product-quantity" type="number" style="width: 100%;" pattern="[0-9]*" data-productId="${item.productId}" value="${item.quantity}" max="${item.maxQuantity}" min="1" onkeydown="return false">
                                </div>
                            </div>
                        </div>
                        <!-- Total -->
                        <div class="cart_item_total">$${item.totalPrice}</div>
                    </div>`
            }
        }
        info += ` <div class="alert alert-success">Cart successfully updated.</div>`;
        $('#updateCartInfo').html(info);
        $('#cartItems').html(html);
    }

    function makeOrder(){
        $('#btnMakeOrder').on('click', function(e){
            e.preventDefault();
            var info      = $('#updateCartInfo').html('');

            $.ajax({
                url:window.location+"/make-order",
                method:"post",
                data: $("#checkout_form").serialize(),
                dataType:"json",
                success: function(res){
                    localStorage.removeItem("countCard");
                    countCard();
                    writeOrderMadeMessage(res);
                    window.scrollTo(0, 0);
                },
                error: function(res){
                    info.html(writeError(res, info) );
                    window.scrollTo(0, 0);
                }
            })


        });
    }

    function writeError(res, error){
        if(res.status === 500){
            return errorMessage('Problem with server, please try again later');
        }else if(res.status === 400){
            var errors = res.responseJSON.error.message;
            if(errors){
                var html = '';
                for(const [key, value] of Object.entries(errors)){
                    html += `${value}<br/>`;
                }
                return errorMessage(html);
            }
        }
    }

    function writeOrderMadeMessage(data){
        var html = `<div class="row row_cart_buttons">
                    <div class="col">
                        <div class="alert alert-success">
                            Your order #${data.orderId} has been successfully made. Thank you.
                        </div>
                        <div class="cart_buttons d-flex flex-lg-row flex-column align-items-start justify-content-start">
                            <div class="button continue_shopping_button"><a href="/products">Continue shopping</a></div>
                        </div>
                    </div>
                </div>`

        $('.cart_info .container').html(html);
    }

});
