/* 
 */
$(document).ready(
    function()
    {   
        function nicename(string)
        {
            var sNicename = string.replace(/\s+/g,"-");
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
        
        $("#blogpost-title").change(
            function()
            {
                var sTitle = $('#blogpost-title').val();
                $('#blogpost-title_clean').val(nicename(sTitle));
            }
                
        );
        $("#blogcategory-name").change(
            function()
            {
                var sTitle = $('#blogcategory-name').val();
                $('#blogcategory-nice_name').val(nicename(sTitle));
            }
                
        );
    }
)