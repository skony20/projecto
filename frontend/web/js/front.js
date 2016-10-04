
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
                        url: 'flash'
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

    });
