<?php

define("__ROOT__", dirname(__DIR__));

session_start();
if (empty($_SESSION['id'])) {
    $_SESSION['id'] = session_id();
    $_SESSION['login'] = false;
}

require_once __ROOT__ . '/app/function.php';

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "social";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

loaddir(__ROOT__ . '/app/Class');
loaddir(__ROOT__ . '/app/Controllers');

$agent_url = $_SERVER['REQUEST_URI'];
$agent_path = parse_url($agent_url, PHP_URL_PATH);
$agent_request = explode('/', $agent_path);

require_once __ROOT__ . '/routes/web.php';
