<?php

namespace App\Controllers;

use App\Class\Alert;

class Account
{
    public static function login()
    {
        $user = strtolower($_POST['user']);
        $password = $_POST['password'];

        global $conn;
        $sql = "SELECT * FROM account WHERE username = '$user' OR email = '$user'";
        $query = mysqli_query($conn, $sql);
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

        if (empty($result)) {
            echo Alert::alerts('ชื่อผู้ใช้หรืออีเมลไม่ถูกต้อง', 'error', 1500, 'window.location.href = "/login"');
            exit;
        }

        if (!password_verify($password, $result[0]['password'])) {
            echo Alert::alerts('รหัสผ่านไม่ถูกต้อง', 'error', 1500, 'window.location.href = "/login"');
            exit;
        }

        $_SESSION['login'] = true;
        $_SESSION['account']['id'] = $result[0]['id'];
        $_SESSION['account']['username'] = $result[0]['username'];
        $_SESSION['account']['email'] = $result[0]['email'];
        $_SESSION['account']['avatar'] = $result[0]['avatar'];
        $_SESSION['account']['displayname'] = $result[0]['displayname'];

        echo Alert::alerts('เข้าสู่ระบบสำเร็จ', 'success', 1500, 'window.location.href = "/"');
    }

    public static function register()
    {
        $username = strtolower($_POST['username']);
        $email = strtolower($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        global $conn;
        $sql = "SELECT * FROM account WHERE username = '$username' OR email = '$email'";
        $query = mysqli_query($conn, $sql);
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

        if (count($result) > 0) {
            echo Alert::alerts('ชื่อผู้ใช้หรืออีเมลนี้มีผู้ใช้งานแล้ว', 'error', 1500, 'window.location.href = "/register"');
            exit;
        }

        if ($password != $confirm_password) {
            echo Alert::alerts('รหัสผ่านไม่ตรงกัน', 'error', 1500, 'window.location.href = "/register"');
            exit;
        }

        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO account (username, email, password, avatar, displayname) VALUES ('$username', '$email', '$password', '/resources/images/default-avatar.png', '" . ucfirst($username) . "')";
        $query = mysqli_query($conn, $sql);

        if ($query) {
            echo Alert::alerts('สมัครสมาชิกสำเร็จ', 'success', 1500, 'window.location.href = "/login"');
        } else {
            echo Alert::alerts('สมัครสมาชิกไม่สำเร็จ', 'error', 1500, 'window.location.href = "/register"');
        }
    }

    public static function logout()
    {
        session_destroy();

        return header('Location: /login');
    }
}
