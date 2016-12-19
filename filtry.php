<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<?php


$servername = "localhost";
$username = "mariuszs_prj";
$password = "pr0j3ct0";
$dbname = "mariuszs_projecto";
$conn = new mysqli($servername, $username, $password, $dbname);


$aProductsFilter = [];
$aPytanie3 = [1,2,3];
$aPytanie5 = [15,16];
$aPytanie6 = [17,18,19];
$aPytanie7 = [4,5,6,7];
$aPytanie8 = [22,23,41,42,43,44];
$aPytanie9 = [24,25,40,45];
$aPytanie10 = [26,27];
$aPytanie11 = [28,29];
$aPytanie12 = [30,31];
$aPytanie13 = [32,33,34];
$aPytanie15 = [20,21,39];

?>

<?php

$aFilters = $conn->query('SELECT * FROM products_filters ') or die('000'. $conn->error);

while($row = $aFilters->fetch_assoc()) 
	{
		
		if (in_array($row['filters_id'], $aPytanie3 ))
		{
			$aProductsFilter[$row['products_id']][3] = $row['filters_id'];
		}
		if (in_array ($row['filters_id'] , $aPytanie5 ))
		{
			$aProductsFilter[$row['products_id']][5] = $row['filters_id'];
		}
		if (in_array ($row['filters_id'] , $aPytanie6 ))
		{
			$aProductsFilter[$row['products_id']][6] = $row['filters_id'];
		}
		if (in_array ($row['filters_id'] , $aPytanie7 ))
		{
			$aProductsFilter[$row['products_id']][7] = $row['filters_id'];
		}
		if (in_array ($row['filters_id'] , $aPytanie8 ))
		{
			$aProductsFilter[$row['products_id']][8] = $row['filters_id'];
		}
		if (in_array ($row['filters_id'] , $aPytanie9 ))
		{
			$aProductsFilter[$row['products_id']][9] = $row['filters_id'];
		}
		if (in_array ($row['filters_id'] , $aPytanie10 ))
		{
			$aProductsFilter[$row['products_id']][10] = $row['filters_id'];
		}
		if (in_array ($row['filters_id'] , $aPytanie11 ))
		{
			$aProductsFilter[$row['products_id']][11] = $row['filters_id'];
		}
		if (in_array ($row['filters_id'] , $aPytanie12 ))
		{
			$aProductsFilter[$row['products_id']][12] = $row['filters_id'];
		}
		if (in_array ($row['filters_id'] , $aPytanie13 ))
		{
			$aProductsFilter[$row['products_id']][13] = $row['filters_id'];
		}
		if (in_array ($row['filters_id'] , $aPytanie15 ))
		{
			$aProductsFilter[$row['products_id']][15] = $row['filters_id'];
		}
       
    }
foreach ($aProductsFilter as $aFilterKey=>$aFilterValue)
{
	$aPrjs = $conn->query('SELECT name FROM products_descripton WHERE products_id='.$aFilterKey.' ') or die('111'. $conn->error);
	$aProducer = $conn->query('SELECT p.producers_id, prd.name FROM products p  LEFT JOIN producers prd ON (p.producers_id = prd.id) WHERE p.id='.$aFilterKey.' ') or die('222'. $conn->error);
	
	$aPrj = $aPrjs->fetch_assoc();
	$aPrd = $aProducer->fetch_assoc();
	$aProductsFilters[$aFilterKey]['id'] = $aFilterKey;
	$aProductsFilters[$aFilterKey]['name'] = $aPrj['name'];
	$aProductsFilters[$aFilterKey][3] = '';
	$aProductsFilters[$aFilterKey][5] = '';
	$aProductsFilters[$aFilterKey][6] = '';
	$aProductsFilters[$aFilterKey][3] = '';
	$aProductsFilters[$aFilterKey][7] = '';
	$aProductsFilters[$aFilterKey][8] = '';
	$aProductsFilters[$aFilterKey][9] = '';
	$aProductsFilters[$aFilterKey][10] = '';
	$aProductsFilters[$aFilterKey][11] = '';
	$aProductsFilters[$aFilterKey][12] = '';
	$aProductsFilters[$aFilterKey][13] = '';
	$aProductsFilters[$aFilterKey][15] = '';
	$aProductsFilters[$aFilterKey]['Dostawca'] = $aPrd['name'];
	

	foreach ($aFilterValue as $aKey=>$aValue)
	{
		$aProductsFilters[$aFilterKey][$aKey] = $aValue;
	}
}
$file = fopen('filters.csv', 'w');
foreach ($aProductsFilters as $filtersKey=>$filtersValue)
{
	fputcsv($file, $filtersValue);
}
  echo '<pre>'. print_r($aProductsFilters, TRUE);die();
