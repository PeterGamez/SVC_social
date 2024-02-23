<?php

use App\Controllers\Account;
use App\Controllers\Post;
use App\Controllers\Profile;

array_shift($agent_request);

if (empty($agent_request[0])) {
    return views('index');
}
if ($agent_request[0] == 'login') {
    if ($_SESSION['login'] == true) {
        return header('Location: /');
    }
    if (empty($agent_request[1])) {
        return views('login');
    }
    if ($agent_request[1] == 'callback') {
        return Account::login();
    }
}
if ($agent_request[0] == 'register') {
    if ($_SESSION['login'] == true) {
        return header('Location: /');
    }
    if (empty($agent_request[1])) {
        return views('register');
    }
    if ($agent_request[1] == 'callback') {
        return Account::register();
    }
}
if ($agent_request[0] == 'logout') {
    return Account::logout();
}

if ($agent_request[0] == 'post') {
    if (empty($agent_request[1])) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_SESSION['account'])) {
            return Post::create();
        }
        return header('Location: /');
    }
    if (empty($agent_request[2])) {
        return Post::index(['id' => $agent_request[1]]);
    }
    if ($agent_request[2] == 'edit') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST'and isset($_SESSION['account'])) {
            return Post::edit(['id' => $agent_request[1]]);
        }
    }
    if ($agent_request[2] == 'delete') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST'and isset($_SESSION['account'])) {
            return Post::delete(['id' => $agent_request[1]]);
        }
    }
    if ($agent_request[2] == 'comment') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST'and isset($_SESSION['account'])) {
            if (empty($agent_request[3])) {
                return Post::comment(['id' => $agent_request[1]]);
            }
            if ($agent_request[3] == 'edit') {
                return Post::comment_edit(['id' => $agent_request[1]]);
            }
            if ($agent_request[3] == 'delete') {
                return Post::comment_delete(['id' => $agent_request[1]]);
            }
        }
    }
}
if ($agent_request[0] == 'profile') {
    if (empty($agent_request[1])) {
        return header('Location: /profile/' . $_SESSION['account']['username']);
    }
    if (empty($agent_request[2])) {
        return Profile::index(['username' => $agent_request[1]]);
    }
    if ($agent_request[2] == 'edit') {
        if ($_SESSION['account']['username'] == $agent_request[1]) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST'and isset($_SESSION['account'])) {
                return Profile::edit();
            }
        }
    }
    if ($agent_request[2] == 'password') {
        if ($_SESSION['account']['username'] == $agent_request[1]) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST'and isset($_SESSION['account'])) {
                return Profile::password();
            }
        }
    }
}
return views('404');
