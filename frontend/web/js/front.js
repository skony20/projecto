
$(document).on('ready pjax:success',


    function()
    {
        $('#prj_set_filters').submit(function() {
            var osoby = '';
            var ksztalt ='';
            var styl = '';
            if ($("[name='7']").val() !== '' ) 
            {
                osoby = '/'+$("[name='7']").val();
            }
            if ($("[name='3']").val() !== '' ) 
            {
                ksztalt = '/'+$("[name='3']").val();
            }
            if ($("[name='5']").val() !== '' ) 
            {
                styl = '/'+$("[name='5']").val();
            }
            window.location = $(this).attr("action") + '/HouseSize/' +  $("[name='HouseSize']").val()+'/filters/'+osoby+ksztalt+styl;
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
        $('input[type=text]').change(
            function()
            {
                $("#set_filters").submit();
                
            }
        );
        $('#prj_sizex, #prj_sizey').change(
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


    $('.project_ready').click(
            function()
            {
                $.ajax({
                    url: "site/save-filters"
                });
                window.location.href = "projekty";
            });


    $('.reset_all_filters').click(
            function()
                {
                    $('.prj_select').prop('selectedIndex',0);
                    
                    $.ajax({
                        url: '/projecto/projekty/reset',
                        success:
                            function()
                                {
                                    window.location.href = "projekty"
                                }
			}); 
                    
                }
    );
    $('.prj_select').change(function()
    {
//        $.ajax({
//            url: "projekty/remove-session?id=BarChange"
//        }); 
        $("#prj_set_filters").submit();
    });

    $('.remove-filter').click(
            function()
            {
                var iFilterGroupId = $(this).attr('rel');
                $('select[name="'+iFilterGroupId+'"]').prop('selectedIndex',0);
                $("#prj_set_filters").submit();
                

            }
    );
    $('.search-submit').click(
            function()
            {
                var sSearch = $('.search-input').val();

                if (sSearch.length > 0)
                {
                    window.location.href = "/projecto/projekty/szukaj/"+sSearch;
                }
            }
    );
    
    /*Koszyk*/
    $('.cart').mouseover(function()
    
        {
            $('.cart-container').css('display', 'block');

        }
    );
    $('.cart').mouseout(function()
    
        {
            $('.cart-container').css('display', 'none');
        }
    );
    
    
    
    
    /*Dodawanie produktu*/
    $('.prj_add_cart').click(
            function()
            {
                var iPrjId = $(this).attr('rel');
                $.ajax({
                    url: "/projecto/cart/add-cart?iPrjId="+iPrjId,
                    success: function(data) {   
                        //$('.cart-items').html(data);
                        $("#cart-items").load("/projecto/projekty #cart-items");
                        $('#system-messages').html(data).stop().fadeIn().animate({opacity: 1.0}, 4000).fadeOut('slow');
                    }

                    }); 
            }
    );
    /*Dodawanie produktu projekt*/
    $('.prj-add-button').click(
            function()
            {
                var iPrjId = $(this).attr('rel');
                $.ajax({
                    url: "/projecto/cart/add-cart?iPrjId="+iPrjId,
                    success: function(data) {   
                        //$('.cart-items').html(data);
                        $("#cart-items").load("/projecto/projekt/"+iPrjId +" #cart-items");
                        $('#system-messages').html(data).stop().fadeIn().animate({opacity: 1.0}, 4000).fadeOut('slow');
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
                    url: "/projecto/cart/remove-from-cart?iPrjId="+iPrjId,
                    success: function(data) { 
                        window.location.href = window.location.href;
                        $('#system-messages').html(data).stop().fadeIn().animate({opacity: 1.0}, 4000).fadeOut('slow');
                        
                    }

                    }); 
            }
    );
    /*Dodawanie ulubionych*/
    $('.prj_add_favorites').click(
            function()
            {
                var iPrjId = $(this).attr('rel');
                $.ajax({
                    url: "/projecto/favorites/add-favorites?iPrjId="+iPrjId,
                    success: function(data) {   
                        //$('.cart-items').html(data);
                         $('#system-messages').html(data).stop().fadeIn().animate({opacity: 1.0}, 4000).fadeOut('slow');
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
                    url: "/projecto/favorites/delete-favorites?iPrjId="+iPrjId,
                    success: function(data) {   
                        window.location.href = window.location.href;
                        $('#system-messages').html(data).stop().fadeIn().animate({opacity: 1.0}, 4000).fadeOut('slow');
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

    if($('#orders-is_invoice').is(':checked')) {
        $('.invoice').show();
        $('.invoice-caption').show();
    } else {
        $('.invoice').hide();
           $('.invoice-caption').hide();
    }
    
    /*formualrz sortowania*/
    $('.prj_sort').change(function()
    {
        $("#prj_sort").submit();
    });
    
    });
