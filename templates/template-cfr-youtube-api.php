<?php
/*
Template Name: Cfr Youtube API
*/
?>

<?php
$requestURL = "http://localhost:3000/?videoURL=" . $_GET["videoURL"];
echo shell_exec("curl " . $requestURL);
?>
