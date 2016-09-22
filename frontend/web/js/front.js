
$(document).on('ready pjax:success',
    function()
    {
        $('input[type=radio]').change(
            function()
            {
                $("#set_filters").submit();
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
                window.location.href = "site/projekty";
            });


    $('.reset_all_filters').click(
            function()
                {
                    $('input').prop('checked', false);
                    $.ajax({
                        url: 'reset'
				
			});
                    $.ajax({
                        url: 'projekty',
			success: function(data) 
                        {
                            $(".products-items").html(data);
                        }	
			});
                }
    );
    
    $('input[type=radio][class=prj_radio]').change(function() 
    {
        //$(".products-items").html(''); // czyscimy warstwe
	oFormData = $('form').serialize();
        $.ajax({
            url: 'projekty',
            type: 'POST',
            data: oFormData,
            success: function(data) 
            {
                $(".products-items").html(data);
            }
        });
    });

    $('.remove-filter').click(
            function()
            {

                var iFilterGroupId = $(this).attr('rel');
                $('input[name="'+iFilterGroupId+'"]').prop('checked', false);
                $("#set_filters").submit();
                $.ajax({
                        url: 'projekty',
			success: function(data) 
                        {
                            $(".products-items").html(data);
                        }	
			});

            }
        );

    });
