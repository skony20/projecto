
<?php
$CartItemy = (isset($CartItems) ? $CartItems : isset($_SESSION['Cart']) ? $_SESSION['Cart'] :[] );
foreach ($CartItemy as $CartItem)
{
    echo $CartItem['iPrjId'] . 'x' .$CartItem['iQty'] .'<br>'; 
}
?>

