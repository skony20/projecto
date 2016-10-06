
<?php
//echo print_r($CartItems, TRUE);
if (isset ($CartItems))
{
    foreach ($CartItems as $CartItem)
    {
        echo $CartItem['iPrjId'] . 'x' .$CartItem['iQty'] .'<br>'; 
    }
}
 else 
{
     echo 'Brak produktów';

}

?>
