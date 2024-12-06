<?php 
require 'users/header.php';
$path = "users/pages/";
if (isset($_GET['page'])) {
  $page = $_GET['page'];

  if ($page == "home") {
    require $path . "$page.php";
  }else if ($page == "about") {
    require $path . "$page.php";
  }else if ($page == "product") {
    require $path . "$page.php";
  }

}else{
  require $path . "home.php";
}
