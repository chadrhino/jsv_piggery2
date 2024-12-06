
<?php
session_start();
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); 
ini_set('session.use_strict_mode', 1); 


// In your header or a central initialization file
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
     header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
     exit();
 }

function isValidUrl($url) {
     return preg_match('/^https?:\/\/(www\.)?jsvpiggery\.com/', $url);
 }
 
 // Example usage of the function
 $link = "https://jsvpiggery.com";
 if (isValidUrl($link)) {
     
 } else {
     echo "Invalid URL.";
 }

if (basename($_SERVER['PHP_SELF']) == './theme/head.php') {
     header("HTTP/1.1 403 Forbidden");
     exit("Access denied.");
 }

 // Add CSP header
 header("Content-Security-Policy: default-src 'self'; script-src 'self' https://jsvpiggery.com;");
 header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
 header("X-Content-Type-Options: nosniff");
 header("X-Frame-Options: DENY");
 header("X-XSS-Protection: 1; mode=block");
 header("Referrer-Policy: no-referrer");
 header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
 header('Pragma: no-cache');
 header('Expires: 0');
 header('Content-Type: text/html; charset=utf-8');
 header("X-Frame-Options: SAMEORIGIN");
 header("Referrer-Policy: strict-origin-when-cross-origin");
 header("Permissions-Policy: geolocation=()");
 

foreach ($_GET as $key => $value) {
    $_GET[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
foreach ($_POST as $key => $value) {
    $_POST[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
foreach ($_COOKIE as $key => $value) {
    $_COOKIE[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo NAME_; ?></title>
	
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta charset="UTF-8">
<!-- FILE BASED -->
<link rel="stylesheet" href="./plugin/w3.css">
<link rel="stylesheet" href="./plugin/bootstrap.min.css">
<script src="./plugin/jquery-2.2.4.min.js"></script>
<script src="./plugin/bootstrap.min.js"></script>
<link rel="stylesheet" href="./plugin/font-awesome.min.css">

<!-- CDN BASED  -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
<script
src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
</script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css">
<link href='https://fonts.googleapis.com/css?family=Baumans' rel='stylesheet'>


<style>
body {
    font-family: 'Baumans';
    background-color: #d4d8dd;
}
@media print{
	.dont-print{
		display: none !important;
	}
}
</style>

<script>
 $(document).ready(function(){
    $('#table').DataTable();
});

 $(document).ready(function(){
 	 $('#table_pig').DataTable();
    
 })
</script>

<script>
	$.fn.datepicker.defaults.format = "yyyy-mm-dd";
	$('.datepicker').datepicker();
</script>
</head>
<body>

