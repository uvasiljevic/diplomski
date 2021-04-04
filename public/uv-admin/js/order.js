/* JS Document */

/******************************

 [Table of Contents]

 1. Vars and Inits
 2. Set Header
 3. Init Search
 4. Init Menu
 5. Init Isotope


 ******************************/

$(document).ready(function()
{
    "use strict";
    $('#o_filter').click( function (e) {
        e.preventDefault();
        showData();

    });

    $(document).on('click', '.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        $('#o_page').val(page);
        showData();
    });

    function showData(){
        var page =  $('#o_page').val();
        $.ajax({

            url: window.location+'?page='+page,
            method: "post",
            dataType: "json",
            data:$('#order_form').serialize(),
            success: function(data){
                console.log(data);
                writeTable(data);
                showPagination(data);
            }
        });

    }

    function writeTable(data){
        var html = '';
        if(data){
            for(let d of data.data){
                html +=`<tr class="tr-shadow">
                                    <td>${d.id}</td>
                                    <td>
                                        <span>${d.firstName} ${d.lastName}</span><br/>
                                        <span class="block-email">${d.email}</span><br/>
                                        <span>${d.street} ${d.streetNumber}</span><br/>
                                        <span>${d.zipCode} ${d.city}</span>
                                    </td>
                                    <td class="desc"><span class="badge badge-primary">${d.paymentType}</span></td>
                                    <td>${d.dateCreate}</td>
                                    <td>
                                        <span class="status--process">Processed</span>
                                    </td>
                                    <td>${d.postage}</td>
                                    <td>${d.price}</td>
                                    <td>${d.ransom}</td>
                                    <td>
                                        <div class="table-data-feature">
                                            <button class="item" data-id="${d.id}" data-toggle="tooltip" data-placement="top" title="Send">
                                                <i class="zmdi zmdi-mail-send"></i>
                                            </button>
                                            <button class="item" data-id="${d.id}" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="zmdi zmdi-edit"></i>
                                            </button>
                                            <button class="item" data-id="${d.id}" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>`
            }
        }

        $('#order_table').html(html);
    }

    function showPagination(data){
        console.log(data)
        var html = `<nav>
        <ul class="pagination">`;
           for(let d of data.links){
               let active = d.active ? 'active' : '';
               html += `<li class="page-item ${active}"><a class="page-link" href="${d.url}">${d.label}</a></li>`;
            }
        html  += `</ul>
        </nav>`;
        $('#o_pagination').html(html);
    }

    $(document).on('click', '.offset', function(e){

        e.preventDefault()
        var sort      = $('#sort').val();
        var search    = $('#search').val();
        var offset    = $(this).data('id');

        $.ajax({

            url: window.location,
            method: "post",
            dataType: "json",
            data:{
                sort:  sort,
                search: search,
                offset: offset,
                _token: $("input[name='_token']").val()
            },
            success: function(data){
                var count = writeProducts(data)
                showPagination(count)
            }
        })
    })

});
