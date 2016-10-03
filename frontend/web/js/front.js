
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
                oFormData = $('form').serialize();
                $.ajax({
                    url: 'projekty',
                    type: 'post',
                    data: oFormData,
                    success: function(data)
                    {
                        $(".prj-items").html(data);
                    }

                });
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
                        url: 'delete-bar'
			});    
                    $.ajax({
                        url: 'projekty',
			success: function(data)
                        {
                            $(".prj-items").html(data);
                        }
			});
                }
    );

    $('.prj_select').change(function()
    {
        $.ajax({
            url: "remove-session?id=BarChange"
        }); 
        $(".prj-items").html(''); // czyscimy warstwe
        oFormData = $('form').serialize();
        $.ajax({
            url: 'projekty',
            type: 'post',
            data: oFormData,
            success: function(data)
            {
                $(".prj-items").html(data);
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
                            $(".prj-items").html(data);
                        }
			});

            }
        );

    });
