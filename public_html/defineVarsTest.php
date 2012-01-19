<?
include("../include/defineVars.php");

$myOtherVar = "testing";

extract(defineVars("test", "a", "b"));

echo "<br>returnedVars test = $test and a = $a and b = $b";

?>
