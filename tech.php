<?php

$servername = "localhost";
$username = "mariuszs_prj";
$password = "pr0j3ct0";
$dbname = "mariuszs_projecto";
$conn = new mysqli($servername, $username, $password, $dbname);
// polaczenie nawiazane ;-)

$aProductsAttribute = [];
?>

<?php
$aAttributes = $conn->query('SELECT * FROM attributes') or die('000'. $conn->error);

$aProducts = $conn->query('SELECT p.id, pd.name FROM products p LEFT JOIN products_descripton pd ON(p.id = pd.products_id)') or die('100'. $conn->error);
foreach ($aProducts as $aProductsData)
{
    foreach ($aAttributes as $aAttributesData)
    {
        $aProductsAttribute[$aProductsData['id']]['id'] = $aProductsData['id'];
        $aProductsAttribute[$aProductsData['id']]['name'] = $aProductsData['name'];
        $aProductsAttribute[$aProductsData['id']][$aAttributesData['id']] = '';
        $aAttributesInProducts = $conn->query('SELECT value FROM products_attributes WHERE products_id = '.$aProductsData['id'].' AND attributes_id = '.$aAttributesData['id'].'') or die('200'. $conn->error);
        while($row = $aAttributesInProducts->fetch_assoc()) 
	{
            
            $aProductsAttribute[$aProductsData['id']][$aAttributesData['id']] = $row['value'];
            //echo $aProductsData['id'] .' - '. $aAttributesData['id']. ' -- ' . $row['value'] .'<br>';
        }
    }
    
    
}
$file = fopen('tech.csv', 'w');
foreach ($aProductsAttribute as $filtersKey=>$filtersValue)
{
	fputcsv($file, $filtersValue);
}
//echo '<pre>'.print_r($aProductsAttribute, true);
 //die();
?>