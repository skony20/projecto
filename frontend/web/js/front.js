
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
                $.ajax({
                    url: 'site/delete-bar'
                    });    
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
                    $('.prj_select').prop('selectedIndex',0);
                    $.ajax({
                        url: 'reset'
			});
                    $.ajax({
                        url: 'site/delete-bar'
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

    $('.prj_select').change(function()
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
                $('select[name="'+iFilterGroupId+'"]').prop('selectedIndex',0);
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

            }
        );

    });
