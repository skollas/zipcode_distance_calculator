<?php

include "dist.class.php";

$df = new Distance();
$zip1 = $df->getLnt($_GET['zip1']);
$zip2 = $df->getLnt($_GET['zip2']);
$result = $df->GetDistance($zip1, $zip2);

if(isset($_GET['unit'])) {
	$unit = $_GET['unit'];
	if($unit === 'km')
		echo $result['KM'] . ' KM';
	else
		echo $result['Mile'] . ' Miles';
}
else
	var_dump($result);
	

?>
