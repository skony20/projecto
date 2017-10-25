$(document).ready(
    function()
    {
        setTimeout(function() {
            $('#w8-success-0').animate({"top":"0px"}, "fast");
        }, 3000); // <-- time in milliseconds
        
        $('#check-all-similar').click(function() {
            $("form input:checkbox").attr( "checked" , true );
        });
        
        var sNameSimilar = $('.sNameSimilar').text();
        $( "label:contains("+sNameSimilar+")" ).css( "background-color", "#d7f2ff85" );
        
        function nicename(string)
        {
            
            var sNicename = string.replace(/\s+/g,"_");
            sNicename = sNicename.replace(/ę/ig,'e');
            sNicename = sNicename.replace(/ż/ig,'z');
            sNicename = sNicename.replace(/ó/ig,'o');
            sNicename = sNicename.replace(/ł/ig,'l');
            sNicename = sNicename.replace(/ć/ig,'c');
            sNicename = sNicename.replace(/ś/ig,'s');
            sNicename = sNicename.replace(/ź/ig,'z');
            sNicename = sNicename.replace(/ń/ig,'n');
            sNicename = sNicename.replace(/ą/ig,'a');
            sNicename = sNicename.replace(/\?/g,'');
            
            sNicename = sNicename.toLowerCase();
            return sNicename;
        }    
    $("#filtersgroup-name").change(
			function() {
                            var sTitle = $('#filtersgroup-name').val();
                            $('#filtersgroup-nicename_link').val(nicename(sTitle));
			}
		);
    $("#filters-name").change(
			function() {
                            var sTitle = $('#filters-name').val();
                            $('#filters-nicename_link').val(nicename(sTitle));
			}
		);
    $("#productsdescripton-name, #productsdescripton-name_model, #productsdescripton-name_subname").change(
			function() {
                            var sName = $('#productsdescripton-name').val();
                            var sModelName = $('#productsdescripton-name_model').val();
                            var sSubName = $('#productsdescripton-name_subname').val();
                            var sNameAll = sName + ' ' + sModelName + ' ' + sSubName;
                            
                            $('#productsdescripton-meta_title').val(sNameAll);
			});
    $("#productsdescripton-html_description_short").change(
			function() {
                            var sShortDesc = $('#productsdescripton-html_description_short').val();
                            var regex = /(<([^>]+)>)/ig;
                            sShortDesc = sShortDesc.replace(regex, "");

                            
                            $('#productsdescripton-meta_description').val(sShortDesc);
			}                            
		);    
    $("#productsdescripton-keywords").change(
                function() {
                    var sKeywords = $('#productsdescripton-keywords').val();
                    $('#productsdescripton-meta_keywords').val(sKeywords);
                }                            
        );
     $(".delete_image").click(
             function() {
                if (confirm("Jesteś pewien?")) {
                    iIdProduct = $(this).attr('rel');
                    sName = $(this).attr('rel2');
                    iIdImages = $(this).attr('rel3');
                    $.ajax({
                        url: '../products-images/deleteimages',
                        type: 'get',
                        data: {
                            iModelId:iIdProduct, 
                            sName:sName, 
                            iImageId:iIdImages
                        },
                        success: function(data) {
                            window.location.href = window.location.href;
                        }
                    });
         }
         });

         $(".active_prd").click(
             function() {
                iIdProduct = $(this).attr('rel');
                $.ajax({
                    url: '/backend/web/products/unactive/'+iIdProduct,
                    success: function(data) {
                        window.location.href = window.location.href;
                    }

             });
         });
         $(".unactive_prd").click(
             function() {
                iIdProduct = $(this).attr('rel');
                $.ajax({
                    url: '/backend/web/products/active/'+iIdProduct,
                success: function(data) {
                    window.location.href = window.location.href;
                }

             });
         });
         $(".archive_prd").click(
             function() {
                iIdProduct = $(this).attr('rel');
                $.ajax({
                    url: '/backend/web/products/unarchive/'+iIdProduct,
                    success: function(data) {
                        window.location.href = window.location.href;
                    }

             });
         });
         $(".unarchive_prd").click(
             function() {
                iIdProduct = $(this).attr('rel');
                $.ajax({
                    url: '/backend/web/products/archive/'+iIdProduct,
                success: function(data) {
                    window.location.href = window.location.href;
                }

             });
         });
         $(".active_faq").click(
             function() {
                iIdProduct = $(this).attr('rel');
                $.ajax({
                    url: 'faq/unactive/'+iIdProduct,
                    success: function(data) {
                        window.location.href = window.location.href;
                    }

             });
         });
         $(".unactive_faq").click(
             function() {
                iIdProduct = $(this).attr('rel');
                $.ajax({
                    url: 'faq/active/'+iIdProduct,
                success: function(data) {
                    window.location.href = window.location.href;
                }

             });
         });
         /*Usuwanie podobnych projektów*/
         $(".remove-similar").click(
             function() {
                
                iSimilarId = $(this).attr('rel');
                iMainId = $(this).attr('rel2');
                $.ajax({
                    url: '../../similar/delete',
                    type: 'get',
                    data: {
                        p_iSimilarId:iSimilarId, 
                        p_iMainId:iMainId
                    },
                    success: function(data) {
                       
                    }
                });
         });
         
    });
$(document).ready(function() {
		$(".fancybox").fancybox();
	});