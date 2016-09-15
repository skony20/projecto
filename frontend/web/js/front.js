
$(document).ready(
    function()
    {   
        var arr = [];
     $('input[type=radio]').change(
			function() {
                            arr.push(this.value);
                            $('div.array_content').html(arr+'<br>');
			}
		);
});
    
