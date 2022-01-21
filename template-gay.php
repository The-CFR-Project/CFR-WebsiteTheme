<?php
/*
Template Name: Gay API
*/
?>

<?php
$requestURL = "http://localhost:1801/?name=" . $_GET["label"];
echo shell_exec("curl " . $requestURL);
?>

