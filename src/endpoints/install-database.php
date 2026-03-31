<?php

use CMSS\Database;

$host = $_POST['db_host'];
$name = $_POST['db_name'];
$username = $_POST['db_username'];
$password = $_POST['db_user_password'];

Database::getInstance()->install($host, $name, $username, $password);