
$(document).on('ready pjax:success',
    function()
    {
        
        $('input[type=radio]').change(
            function()
            {
                $.ajax({
                        url: "site/reset"
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
                window.location.href = "projekty";
            });


    $('.reset_all_filters').click(
            function()
                {
                    $('.prj_select').prop('selectedIndex',0);
                    $.ajax({
                        url: 'reset'
			});  
                    $("#prj_set_filters").submit();
                }
    );

    $('.prj_select').change(function()
    {
        $.ajax({
            url: "remove-session?id=BarChange"
        }); 
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
    
    /*Koszyk*/
    $('.cart').mouseover(function()
    
        {
            $('.cart-container').css('display', 'block');

        }
    )
    $('.cart').mouseout(function()
    
        {
            $('.cart-container').css('display', 'none');
        }
    )
    
    
    
    
    /*Dodawanie produktu*/
    $('.prj_add_cart').click(
            function()
            {
                var iPrjId = $(this).attr('rel');
                $.ajax({
                    url: "cart/add-cart?iPrjId="+iPrjId,
                    success: function(data) {   
                        //$('.cart-items').html(data);
                        $("#cart-items").load("/projecto/projekty #cart-items");
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
    /*Usuwanie porduktu z koszyka*/
     $('.delete-from-cart').click(
            function()
            {
                var iPrjId = $(this).attr('rel');
                $.ajax({
                    url: "/projecto/cart/remove-from-cart?iPrjId="+iPrjId,
                    success: function(data) {   
                        //$('.cart-items').html(data);
                        window.location.href = window.location.href;
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
                    url: "/projecto/favorites/add-favorites?iPrjId="+iPrjId
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
    $('.want-invoice').click(function()
        {
           $('.invoice').toggle();
           $('.invoice-caption').toggle();
           
        }
    );
    $('.want-invoice-order').click(function()
        {
           $('.invoice').toggle();
           $('.invoice-caption').toggle();
           if($('.want-invoice-order').children().is(':checked')) {
                $('.want-invoice-order').children().prop( "checked", false );
            } else {
                $('.want-invoice-order').children().prop( "checked", true );
            }
           
        }
    );
    if($('.want-invoice-order').children().is(':checked')) {
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
