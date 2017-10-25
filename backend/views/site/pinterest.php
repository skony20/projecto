
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>
<script>
$(document).ready(function(){
	$(".pinterestgo").click(
			function() {
                            var iCount =  $('#container form:last').attr('rel2');
                            var i=1;
                            for(i=1; i<=iCount; i++)
                            {
                            $.ajax({
                                type: "POST",
                                url: 'https://api.pinterest.com/v1/pins/?access_token=ARzrFd3gLmz3b9gne-d4YeZE5Yy1FOfa3qhl53JEWTTN7WA-bQAAAAA',
                                data: $("#form"+i).serialize(), // serializes the form's elements.
                                PrdId: $('.form'+i).attr('rel'),
                                success: function(data)
                                    {
                                        $.ajax({
                                            type: "GET",
                                            url:'https://projekttop.pl/backend/web/site/pintereston/'+PrdId.value,
                                            success: function()
                                                {
                                                    setTimeout(function () { location.reload(true); }, 200);
                                                }
                                            });
                                        console.log('Submission was successful.');
                                    }
                                });
                            }
				
			}
)});
</script>
<?php
/*  
    Projekt    : projekttop.pl
    Created on : 2017-09-26, 10:49:57
    Author     : Mariusz Skonieczny, mariuszskonieczny@hotmail.com
*/
function cut($tekst,$ile)
        {
 
        $tekst = strip_tags($tekst);
           if (strlen($tekst) > $ile) 
           {
                $tekst=substr($tekst, 0, $ile);
                for ($a=strlen($tekst)-1;$a>=0;$a--) 
                {
                   if ($tekst[$a]==" ") 
                    {
                        $tekst=substr($tekst, 0, $a)."...";
                        break;
                    };
                };
           };

        return $tekst;
}
$a=1;  
echo '<div id="container">';
echo '<button class="pinterestgo">DAWAJ</button>';
//$aProduct= $model;
foreach ($model as $aProduct)
{
    echo $a;
    $sOpis = $aProduct->productsDescriptons->name.' '. cut(strip_tags($aProduct->productsDescriptons->html_description), 200);
    echo '<form target="_blank" id="form'.$a.'" class="form'.$a.'" method="POST" action="https://api.pinterest.com/v1/pins/?access_token=ARzrFd3gLmz3b9gne-d4YeZE5Yy1FOfa3qhl53JEWTTN7WA-bQAAAAA" rel='.$aProduct->id.' rel2='.$a.'>';
    echo '<input type="hidden" id="PrdId" name="PrdId" value="'.$aProduct->id.'">';
    echo '<input type="text" id="board" name="board" value="kowalczykmarek78/projekty-domów">';
    echo '<input type="text" id="note" name="note" value="'.$sOpis.'">';
    echo '<input type="text" id="link" name="link" value="https://projekttop.pl/projekt/'.$aProduct->productsDescriptons->nicename_link.'.html">';
    echo '<input type="text" id="image_url" name="image_url" value="https://projekttop.pl/images/'.$aProduct->id.'/big/'.$aProduct->productsImages[0]->name.'">';
    echo '<button type="submit"> asasa </button>';
    echo '</form><br>';
    $a++;
    if ($a == 2)
    {
        break;
    }
}
echo '</div>';
?>


    