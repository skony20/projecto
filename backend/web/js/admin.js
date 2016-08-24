/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(
    function()
    {   
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
    });
        