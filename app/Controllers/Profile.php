<?php

namespace App\Controllers;

use App\Class\Alert;

class Profile
{
    public static function index($data)
    {
        extract($data);

        global $conn;

        $sql = "SELECT * FROM account WHERE username = '$username'";
        $query = mysqli_query($conn, $sql);
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

        if (!$result) {
            return views('404');
        }
        $result = [
            "account" => [
                "id" => $result[0]['id'],
                "username" => $result[0]['username'],
                "avatar" => $result[0]['avatar'],
                "displayname" => $result[0]['displayname']
            ]
        ];

        $sql = "SELECT
                post.id, post.message,
                COUNT(post_comment.id) AS comment,
                GROUP_CONCAT(post_image.image) AS images
            FROM post
            LEFT JOIN post_comment ON post_comment.post_id = post.id
            LEFT JOIN post_image ON post_image.post_id = post.id
            LEFT JOIN account ON account.id = post.account_id
            WHERE account.username = '$username'
            GROUP BY post.id
            ORDER BY post.id DESC";
        $query = mysqli_query($conn, $sql);
        $post = mysqli_fetch_all($query, MYSQLI_ASSOC);

        $post = array_map(function ($post) {
            return [
                "post" => [
                    "id" => $post['id'],
                    "message" => $post['message'],
                    "comment" => $post['comment']
                ],
                "images" => $post['images'] ? explode(',', $post['images']) : []
            ];
        }, $post);



        return views('profile/index', ['result' => $result, 'post' => $post]);
    }

    public static function edit()
    {
        $username = strtolower($_POST['username']);
        $email = strtolower($_POST['email']);
        $displayname = $_POST['displayname'];
        $avatar = $_FILES['avatar'];

        if ($username != $_SESSION['account']['username']) {
            global $conn;
            $sql = "SELECT * FROM account WHERE username = '$username'";
            $query = mysqli_query($conn, $sql);
            $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

            if ($result) {
                echo Alert::alerts('ชื่อผู้ใช้นี้มีคนใช้แล้ว', 'danger', 1500, 'window.history.back()');
                exit;
            }
        }
        if ($email != $_SESSION['account']['email']) {
            global $conn;
            $sql = "SELECT * FROM account WHERE email = '$email'";
            $query = mysqli_query($conn, $sql);
            $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

            if ($result) {
                echo Alert::alerts('อีเมลนี้มีคนใช้แล้ว', 'danger', 1500, 'window.history.back()');
                exit;
            }
        }

        if ($avatar['name']) {
            if ($avatar['error'] == 0) {
                $filename = time() . '.' . pathinfo($avatar['name'], PATHINFO_EXTENSION);
                $path = 'uploads/profile/' . $filename;
                move_uploaded_file($avatar['tmp_name'], $path);

                $avatarurl = '/' . $path;
            } else {
                echo Alert::alerts('อัพโหลดรูปไม่สำเร็จ', 'danger', 1500, 'window.history.back()');
                exit;
            }
        }

        global $conn;
        $sql = "UPDATE account SET ";
        if ($username != $_SESSION['account']['username']) {
            $sql .= "username = '$username', ";
        }
        if ($email != $_SESSION['account']['email']) {
            $sql .= "email = '$email', ";
        }
        if ($displayname != $_SESSION['account']['displayname']) {
            $sql .= "displayname = '$displayname', ";
        }
        if ($avatarurl) {
            $sql .= "avatar = '$avatarurl', ";
        }
        $sql = rtrim($sql, ', ');
        $sql .= " WHERE id = " . $_SESSION['account']['id'];
        $query = mysqli_query($conn, $sql);

        if ($query) {
            if ($username != $_SESSION['account']['username']) {
                $_SESSION['account']['username'] = $username;
            }
            if ($email != $_SESSION['account']['email']) {
                $_SESSION['account']['email'] = $email;
            }
            if ($displayname != $_SESSION['account']['displayname']) {
                $_SESSION['account']['displayname'] = $displayname;
            }
            if ($avatarurl) {
                if ($_SESSION['account']['avatar'] != '/resources/images/default-avatar.png') {
                    unlink(__ROOT__ . '/public' . $_SESSION['account']['avatar']);
                }
                $_SESSION['account']['avatar'] = $avatarurl;
            }

            echo Alert::alerts('แก้ไขโปรไฟล์สำเร็จ', 'success', 1500, 'window.history.back()');
        } else {
            echo Alert::alerts('แก้ไขโปรไฟล์ไม่สำเร็จ', 'danger', 1500, 'window.history.back()');
        }
    }

    public static function password()
    {
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password != $confirm_password) {
            echo Alert::alerts('รหัสผ่านไม่ตรงกัน', 'danger', 1500, 'window.history.back()');
            exit;
        }

        $password = password_hash($password, PASSWORD_DEFAULT);

        global $conn;
        $sql = "UPDATE account SET password = '$password' WHERE id = " . $_SESSION['account']['id'];
        $query = mysqli_query($conn, $sql);

        if ($query) {
            echo Alert::alerts('เปลี่ยนรหัสผ่านสำเร็จ', 'success', 1500, 'window.history.back()');
        } else {
            echo Alert::alerts('เปลี่ยนรหัสผ่านไม่สำเร็จ', 'danger', 1500, 'window.history.back()');
        }
    }
}
