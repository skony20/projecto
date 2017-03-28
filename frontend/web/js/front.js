
$(document).on('ready pjax:success',
    function()
    {
        
        $('#prj_set_filters').submit(function(e) {
            e.preventDefault();
            this.submit();
            
            var filter = '';
            var filters = '';
            var sHouseSize = '';
            var sSzerokosc = '';
            var sGlebokosc = '';
            var bBarChange = $.cookie("bBarChange");
            var sPracownia = '';
            
            iMin = document.getElementsByClassName("irs-min")[0];
            iMax = document.getElementsByClassName("irs-max")[0];
            iFrom = document.getElementsByClassName("irs-from")[0];
            iTo = document.getElementsByClassName("irs-to")[0];

            if (bBarChange === '1' && (iMin.innerHTML !== iFrom.innerHTML || iMax.innerHTML !== iTo.innerHTML))
            {     
                
                sHouseSize = '/HouseSize/' +  $("[name='HouseSize']").val();
            }
            $('input:checkbox:checked').each(function() 
            {
                filter += '/'+($(this).val());
            });

            if (filter !== '')
            {
                filters = '/filters'+filter;
            }

//            if ($("[name='SizeX']")[0].defaultValue !== $("[name='SizeX']").val())
//            {
//                sSzerokosc = '/szerokosc/' +  $("[name='SizeX']").val();
//            }
//             if ($("[name='SizeY']")[0].defaultValue !== $("[name='SizeY']").val())
//            {
//                sGlebokosc = '/glebokosc/' +  $("[name='SizeY']").val();
//            }
            if (filters === '' && sHouseSize === '')
            {   
                
                $.ajax({
                        url: '/projekty/reset'
                        });
            }
            if ($('#pracownia').val() != '')
            {
                sPracownia = '/pracownia/' + $('#pracownia').val();
            }
            window.location = $(this).attr("action") + sPracownia + sSzerokosc + sGlebokosc  +  sHouseSize  + filters ;
            
            return false;
            });
        
        $('input[type=radio]').change(
            function()
            {
                
                $.ajax({
                        url: "projekty/reset"
                    }); 
                $("#set_filters").submit();
            }
        );
//        $('input[type=text]').change(
//            function()
//            {
//                
//                $("#set_filters").submit();
//                
//            }
//        );
        $('#prj_sizex, #prj_sizey').change(
            function()
            { 
               $("#prj_set_filters").submit();
            }
        );
        $('input[type=checkbox]').change(
            function()
            { 
              var frm = $('#set_filters');
                frm.submit(function (ev) {
                    $.ajax({
                        type: frm.attr('method'),
                        url: frm.attr('action'),
                        data: frm.serialize(),
                        success: function (data) {
                            alert('ok');
                        }
                    });

                    ev.preventDefault();
                });
            }
        );
        $('#pracownia').change(
            function()
            { 
               
               $("#prj_set_filters").submit();
            }
        );
        $('.reset_filter').click(
            function()
            {
                var iFilterGroupId = $(this).attr('rel');
                $('input[name="'+iFilterGroupId+'"]').prop('checked', false);
                
                $("#set_filters").submit();

            }
        );
        $('#set_filters').submit(function() {
             $('.loader').show();
            });


    $('.project_ready').click(
            function()
            {
                var filter = '';
                var filters = '';
                var sHouseSize = '';
                var sSzerokosc = '';
                var sGlebokosc = '';
                var bBarChange = $.cookie("bBarChange");
                iMin = document.getElementsByClassName("irs-min")[0];
                iMax = document.getElementsByClassName("irs-max")[0];
                iFrom = document.getElementsByClassName("irs-from")[0];
                iTo = document.getElementsByClassName("irs-to")[0];

                if (bBarChange === '1' && (iMin.innerHTML !== iFrom.innerHTML || iMax.innerHTML !== iTo.innerHTML))
                {     
                    sHouseSize = '/HouseSize/' +  $("[name='HouseSize']").val();
                }
                $(":checked").each(function() {
                    filter += '/'+($(this).val());
                });
                if (filter !== '')
                {
                    filters = '/filters'+filter;
                }
                
                
                $.ajax({
                    url: "site/save-filters"
                });
                window.location = "projekty" + sSzerokosc + sGlebokosc  +  sHouseSize + filters;
            });


    $('.reset_all_filters').click(
            function()
                {
                    $('.prj_select').prop('selectedIndex',0);
                    
                    $.ajax({
                        url: '/projekty/reset',
                        success:
                            function()
                                {
                                    window.location.href = '/projekty'
                                }
			}); 
                    
                }
    );
    $('.prj_select').change(function()
    {
//        $.ajax({
//            url: "projekty/remove-session?id=BarChange"
//        }); 
        $.removeCookie("bBarChange");
        $("#prj_set_filters").submit();
    });

    $('.remove-filter').click(
            function()
            {
                var iFilterGroupId = $(this).attr('rel');
                $('input:checkbox[name="'+iFilterGroupId+'[]"]').prop('checked', false);
                //$('select[name="'+iFilterGroupId+'"]').prop('selectedIndex',0);
                $("#prj_set_filters").submit();
                

            }
    );
    $('.search-submit').click(
            function()
            {
                var sSearch = $('.search-input').val();

                if (sSearch.length > 0)
                {
                    window.location.href = "/projekty/szukaj/"+sSearch;
                }
            }
    );
    
    $('.menu-bar').click(function()
    {
        $.cookie("bBarChange", 1);
        $.ajax({
            url: '/projekty/barchange'
            });
    });
    
    /*Obsługa accordion*/
    $('.filter_question_row').click(
            function()
            {
                var iAccordion = $(this).attr('rel');
                $.ajax({
                    url: "/accordion?iId="+iAccordion,

                    }); 
            })
       $('.filter_ansver_row').click(
            function()
            {
                var iAccordion = $(this).attr('rel');
                $.ajax({
                    url: "/accordion?iId="+iAccordion,

                    }); 
            })
    
    /*Koszyk*/

    $('.cart').hover(function()
        {
            $('.cart-container').stop(true, true).fadeIn(300);

        }, function()
        {
            $('.cart-container').stop(true, true).fadeOut(300);
        }
    );
    
    
    
    
    
    /*Dodawanie produktu*/
    $('.prj-add-cart').click(
            function()
            {
                var iPrjId = $(this).attr('rel');
                $.ajax({
                    url: "/cart/add-cart?iPrjId="+iPrjId,
                    success: function(data) {   
                        $("#cart-items").load("/projekty #cart-items");
                        $('#system-messages').html(data).stop().fadeIn().animate({opacity: 1.0}, 1000).fadeOut('slow');
                    }
                    
                    }); 
                $.ajax({
                    url: "/cart/count-cart",
                    success: function(data) {   
                        $("#cart-count").text(data);
                    }
                    
                    }); 
            }
    );
    /*Dodawanie produktu projekt*/
    $('.prj-add-button').click(
            function()
            {
                var iPrjId = $(this).attr('rel');
                var nicename = $(this).attr('rel2');
                $.ajax({
                    url: "/cart/add-cart?iPrjId="+iPrjId,
                    success: function(data) {   

                        //$('.cart-items').html(data);
                        $("#cart-items").load("/projekt/"+nicename +" #cart-items");
                        $('#system-messages').html(data).stop().fadeIn().animate({opacity: 1.0}, 1000).fadeOut('slow');
                    }

                    }); 
                    $.ajax({
                    url: "/cart/count-cart",
                    success: function(data) {   
                        $("#cart-count").text(data);
                    }
                    
                    }); 
            }
    );
    $('.remove-cart').click(
            function()
            {
                $.ajax({
                    url: "../cart/reset-cart",
                    success: function(data) {   
                        $('.cart-items').html('');
                        
                    }
                    }); 
                
            }
    );
    /*Usuwanie produktu z koszyka*/
     $('.delete-from-cart').click(
            function()
            {
                var iPrjId = $(this).attr('rel');
                $.ajax({
                    url: "/cart/remove-from-cart?iPrjId="+iPrjId,
                    success: function(data) { 
                        window.location.href = window.location.href;
                        $('#system-messages').html(data).stop().fadeIn().animate({opacity: 1.0}, 1000).fadeOut('slow');
                        
                    }

                    }); 
            }
    );
    /*Dodawanie ulubionych*/
    $('.prj-add-favorites').click(
            function()
            {
                var iPrjId = $(this).attr('rel');
                $.ajax({
                    url: "/favorites/add-favorites?iPrjId="+iPrjId,
                    success: function(data) {   
                        //$('.cart-items').html(data);
                         $('#system-messages').html(data).stop().fadeIn().animate({opacity: 1.0}, 1000).fadeOut('slow');
                    }
                    }); 
            }
    );
    
    /*Usuwanie z ulubionych*/
    $('.prj_del_favorites').click(
            function()
            {
                var iPrjId = $(this).attr('rel');
                $.ajax({
                    url: "/favorites/delete-favorites?iPrjId="+iPrjId,
                    success: function(data) {   
                        window.location.href = window.location.href;
                        $('#system-messages').html(data).stop().fadeIn().animate({opacity: 1.0}, 1000).fadeOut('slow');
                    }
                    }); 
            }
    );
    
    /*TABS*/
    $('ul.tabs li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('ul.tabs li').removeClass('current');
		$('.tab-content').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	});




    /*Pokaż dane do faktury*/
    $('#orders-is_invoice').click(function()
        {
           $('.invoice').toggle();
           $('.invoice-caption').toggle();
           
        }
    );
    $('.want-invoice').click(function()
    {
        $(".invoice-caption").toggle();
        $(".invoice").toggle();
    });
    if($('#orders-is_invoice').is(':checked')) {
        $('.invoice').show();
        $('.invoice-caption').show();
    } else {
        $('.invoice').hide();
           $('.invoice-caption').hide();
    }
    
    
    
    
    
    
    /*formularz sortowania*/
    $('.prj-sort').change(function()
    {
        $("#prj-sort").submit();
    });
    
    
    /*Pokaz div nad obrazkiem*/
    $('.prj-img').mouseover(function()
    {
        var iPrjId = $(this).attr('rel');
        var sClassName = '.prjs-'+iPrjId;
        $(sClassName).addClass('visible-true');
    });
    $('.prj-img').mouseout(function()
    {
        var iPrjId = $(this).attr('rel');
        var sClassName = '.prjs-'+iPrjId;
        $(sClassName).removeClass('visible-true');
    });
    
    
/*Zapisane na newslatter footer*/
    $('.submit-newslatter').click(function()
    {
        var sEmail = $('#newsletter-input').val();
        $.ajax({
            url: "/newslatter/add?sEmail="+sEmail,
            success: function(data) {   
                        $('#system-messages').html(data).stop().fadeIn().animate({opacity: 1.0}, 1000).fadeOut('slow');
                    }
        });
        
    });
    /*ENTER W WYSZUKIWARCE*/
    $('.search-input').keypress(function (e) {
    if (e.which === 13) {
    var sSearch = $('.search-input').val();
    if (sSearch.length > 0)
        {
            window.location.href = "/projekty/szukaj/"+sSearch;
        }
    return false;
  }
});
    /*Input dla rozmiarów domu*/
    var $range = $(".irs-hidden-input"),
    $inputMin = $(".HouseMin"),
    $inputMax = $(".HouseMax"),
    instance,
    min = 0,
    max = 1000;
    
    instance = $range.data("ionRangeSlider");
    
    $inputMin.change(function () {
        var val = $(this).prop("value");

        if (val < min) {
            val = min;
        } else if (val > max) {
            val = max;
        }

        instance.update({
            from: val
        });
    });
    $inputMax.change( function () {
        var val = $(this).prop("value");

        if (val < min) {
            val = min;
        } else if (val > max) {
            val = max;
        }

        instance.update({
            to: val
        });
    });
});
    
