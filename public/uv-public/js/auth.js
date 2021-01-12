/* JS Document */

/******************************

[Table of Contents]

1. Vars and Inits
2. Set Header
3. Init Search
4. Init Menu
5. Init Quantity


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

	initSearch();
	initMenu();
	initQuantity();
    registration();
    login()

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

	3. Init Search

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

	4. Init Menu

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

	5. Init Quantity

	*/

	function initQuantity()
	{
		// Handle product quantity input
		if($('.product_quantity').length)
		{
			var input = $('#quantity_input');
			var incButton = $('#quantity_inc_button');
			var decButton = $('#quantity_dec_button');

			var originalVal;
			var endVal;

			incButton.on('click', function()
			{
				originalVal = input.val();
				endVal = parseFloat(originalVal) + 1;
				input.val(endVal);
			});

			decButton.on('click', function()
			{
				originalVal = input.val();
				if(originalVal > 0)
				{
					endVal = parseFloat(originalVal) - 1;
					input.val(endVal);
				}
			});
		}
	}

});

function registration(){

    var firstname    = $('#r_firstname');
    var lastname     = $('#r_lastname');
    var email        = $('#r_email');
    var phone        = $('#r_phone');
    var city         = $('#r_city');
    var zipCode      = $('#r_zip');
    var street       = $('#r_street');
    var streetNumber = $('#r_streetNumber');
    var password     = $('#r_password');
    var re_password  = $('#r_password_confirmation');

    requiredField(firstname);
    requiredField(lastname);
    requiredField(email);
    requiredField(phone);
    requiredField(city);
    requiredField(zipCode);
    requiredField(street);
    requiredField(streetNumber);
    requiredField(password);
    requiredField(re_password);
    matchPassword(password, re_password);

    $('#r_btnReg').on('click', function(e){
        e.preventDefault();

        var validator    = false;
        var error        = $("#regError");

        validator        =  matchPassword(password, re_password);
        error.html("");
        error.css({'color': 'red'});

        if(validator){
            $.ajax({
                url:"/insert-user",
                type:"post",
                data: $('#register_form').serialize(),
                dataType:"json",
                success: function(data){

                    firstname.val('');
                    lastname.val('');
                    email.val('');
                    phone.val('');
                    city.val('');
                    zipCode.val('');
                    street.val('');
                    streetNumber.val('');
                    password.val('');
                    re_password.val('');

                    error.html('Successfully registered! You can login now!').css({'color': 'green'});
                    //error.css({'color': '#6c6a74'});
                },
                error: function(res){
                    writeError(res, error)
                }
            })
        }else{
            error.html('Password and password confirmation does not match!');
        }


    })

}

function login(){

    var email        = $('#email');
    var password     = $('#password');

    requiredField(email);
    requiredField(password);


    $('#btnLog').on('click', function(e){
        e.preventDefault();

        var validator    = true;
        var error        = $("#loginError");

        if(password === "" || email === ""){
            validator = false;
        }

        error.html("");
        error.css({'color': 'red'});

        if(validator){
            $.ajax({
                url:"/do-login",
                type:"get",
                data: $('#login_form').serialize(),
                dataType:"json",
                success: function(res){
                    email.val('');
                    password.val('');
                    console.log(res);
                    if(res === 200){
                        location.replace('/')
                    }
                },
                error: function(res){
                    writeError(res, error)
                }
            })
        }else{
            error.html('Email and password are required!');
        }


    })

}

function requiredField(element){

    element.on("blur", function () {
        if(element.val() === ""){
            element.parent().children(':first-child').css({'color': 'red'});
            return false;
        }else{
            element.parent().children(':first-child').css({'color': '#6c6a74'});
            return true;
        }
    });

}

function matchPassword(password, re_password){
    if(password.val() != re_password.val()){
        password.parent().children(':first-child').css({'color': 'red'});
        re_password.parent().children(':first-child').css({'color': 'red'});
        return false;
    }else{
        password.parent().children(':first-child').css({'color': '#6c6a74'});
        re_password.parent().children(':first-child').css({'color': '#6c6a74'});
        return true;
    }
}

function writeError(res, error){
    if(res.status === 500){
        error.html('Problem with server, please try again later');
    }else if(res.status === 400){
        var errors = res.responseJSON.error.message;
        if(errors){
            var html = '';
            for(const [key, value] of Object.entries(errors)){
                html += `${value}<br/>`;
            }
            error.html(html);
        }
    }
}
