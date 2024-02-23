<?php

array_shift($agent_request);
array_shift($agent_request);

if (empty($agent_request[0])) {
    $error = [
        'code' => 400,
        'message' => 'Bad Request'
    ];
    http_response_code(400);
    echo json_encode($error);
    exit;
}

if ($agent_request[0] == 'v1') {
    array_shift($agent_request);

    if (empty($agent_request[0])) {
        $error = [
            'code' => 400,
            'message' => 'Bad Request'
        ];
        http_response_code(400);
        echo json_encode($error);
        exit;
    }

    if ($agent_request[0] == 'post') {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            return api('v1/post/put');
        }
    }
}

$error = [
    'code' => 404,
    'message' => 'Not Found'
];
http_response_code(404);
echo json_encode($error);
