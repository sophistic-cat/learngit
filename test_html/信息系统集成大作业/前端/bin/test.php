<?php 
$a = array("w", "y", "x", "l", "f", "y");
$new_a = array();
$random_key = array_rand($a, 3);
echo $random_key[0] . $random_key[1] .$random_key[2] . "<br>";
foreach($random_key as $value)
{
	array_push($new_a, $a[$value]);
}
echo $new_a[0] . $new_a[1] .$new_a[2];
?>