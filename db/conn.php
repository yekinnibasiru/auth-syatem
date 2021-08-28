<?php
defined('BASEPATH') OR exit("No direct script access allowed");

date_default_timezone_set('Africa/Lagos');

$conn=new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME) OR die("Error:Connecting to database".$conn->connect_error);

?>