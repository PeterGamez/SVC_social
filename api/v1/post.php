<?php

if ($_SESSION['login'] == false) {
    $error = [
        'code' => 401,
        'message' => 'Unauthorized'
    ];
    http_response_code(401);
    echo json_encode($error);
    exit;
}

$body = file_get_contents('php://input');
$body = json_decode($body, true);

$message = $body['message'];
$file = $body['file'];

echo $message;
echo json_encode($file);
