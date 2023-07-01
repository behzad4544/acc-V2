<?php
require "./assets/Helper/dataBase.php";
require "./assets/Helper/helpers.php";
if (isset($_SESSION['username'])) {
    session_destroy();
}
header("location:login.php");