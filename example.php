<?php

if(isset($_GET['zip1'])) {
include "dist.class.php";

$df = new Distance();
$zip1 = $df->getLnt($_GET['zip1']);
$zip2 = $df->getLnt($_GET['zip2']);
$result = $df->ConvertLatLong($zip1, $zip2);

if(isset($_GET['unit'])) {
	$unit = $_GET['unit'];
	if($unit === 'km')
		echo $result['KM'] . ' KM';
	else
		echo $result['Mile'] . ' Miles';
}
else
	echo $result['Mile'] . ' Miles<br>' . $result['KM'] . ' KM';
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Calculate Distance between 2 Zip/Postal Codes</title>
</head>

<body>
<form action="#" method="GET">
	<label for="zip1">Zip Code From</label><input type="number" name="zip1" />
	<label for="zip2">Zip Code To</label><input type="number" name="zip2" />
	<label for="unit">Zip Code To</label><select name="unit" >
	<option value="km">KM</option>
	<option value="miles">Miles</option>
	<option value="">Both</option>
	</select>
	<input type="submit" name="submit" />
</form>
</body>

</html>
