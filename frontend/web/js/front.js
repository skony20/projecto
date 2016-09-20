
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
            function(e)
            {
                //$('#set_filters').attr('action', 'site/projekty');
                 //$("#set_filters").submit();
            });


    });
