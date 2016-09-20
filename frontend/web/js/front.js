
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
                
                var formData = $("#set_filters").serializeArray();
                alert (formData);
                $.ajax({
                    url: 'site/projekty',
                    type: 'POST',
                    data: formData,
                    success: function(data) 
                    {
                        
                    }
					
                });
				
			});
    
    
    });    
