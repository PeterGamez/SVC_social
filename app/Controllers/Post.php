<?php

namespace App\Controllers;

use App\Class\Alert;
use WebSocket;

class Post
{
    public static function index($data)
    {
        extract($data);

        global $conn;
        $sql = "SELECT
                post.id, post.message,
                GROUP_CONCAT(post_image.image) AS images,
                account.id AS account_id, account.username, account.avatar, account.displayname
            FROM post
            LEFT JOIN post_image ON post_image.post_id = post.id
            LEFT JOIN account ON account.id = post.account_id
            WHERE post.id = $id";
        $query = mysqli_query($conn, $sql);
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

        if (empty($result)) {
            return views('404');
        }

        $result = $result[0];

        $data = [
            "post" => [
                "id" => $result['id'],
                "message" => $result['message']
            ],
            "images" => $result['images'] ? explode(',', $result['images']) : [],
            "account" => [
                "id" => $result['account_id'],
                "username" => $result['username'],
                "avatar" => $result['avatar'],
                "displayname" => $result['displayname']
            ]
        ];

        $sql = "SELECT
                post_comment.id, post_comment.message,
                account.id AS account_id, account.username, account.avatar, account.displayname
            FROM post_comment
            LEFT JOIN account ON account.id = post_comment.account_id
            WHERE post_comment.post_id = $id";
        $query = mysqli_query($conn, $sql);
        $comments = mysqli_fetch_all($query, MYSQLI_ASSOC);

        $comments = array_map(function ($comment) {
            return [
                "comment" => [
                    "id" => $comment['id'],
                    "message" => $comment['message']
                ],
                "account" => [
                    "id" => $comment['account_id'],
                    "username" => $comment['username'],
                    "avatar" => $comment['avatar'],
                    "displayname" => $comment['displayname']
                ]
            ];
        }, $comments);

        return views('post/index', ['result' => $data, 'comments' => $comments]);
    }

    public static function create()
    {
        $message = $_POST['message'];
        $files = $_FILES['file'];

        global $conn;
        $sql = "INSERT INTO post (account_id, message) VALUES (" . $_SESSION['account']['id'] . ", '$message')";
        mysqli_query($conn, $sql);
        $post_id = mysqli_insert_id($conn);

        $image = [];

        // if has image
        if (($files['name'][0])) {
            // upload multiple files to path /uploads check error and move file
            // filename is time() + index of file end with file extension
            for ($i = 0; $i < count($files['name']); $i++) {
                if ($files['error'][$i] == 0) {
                    $filename = time() . $i . '.' . pathinfo($files['name'][$i], PATHINFO_EXTENSION);
                    $path = 'uploads/post/' . $filename;
                    if (move_uploaded_file($files['tmp_name'][$i], $path)) {
                        $image[] = '/' . $path;
                    }
                }
            }

            $data = array_map(function ($image) use ($post_id) {
                return "($post_id, '$image')";
            }, $image);

            $sql = "INSERT INTO post_image (post_id, image) VALUES " . implode(',', $data);
            mysqli_query($conn, $sql);
        }

        require_once __ROOT__ . '/vendor/autoload.php';
        $ws = new WebSocket\Client("ws://localhost:8080");
        $ws->send(json_encode([
            "op" => 2,
            "t" => "NEW_POST",
            "d" => [
                "token" => "sss",
                "id" => $post_id,
            ]
        ]));
        $ws->close();

        header('Location: /profile/' . $_SESSION['account']['username']);
    }

    public static function edit($data)
    {
        extract($data);

        $message = $_POST['message'];

        global $conn;
        $sql = "UPDATE post SET message = '$message' WHERE id = $id";
        mysqli_query($conn, $sql);

        echo Alert::alerts('แก้ไขโพสต์สำเร็จ', 'success', 1500, 'window.location.href = "/post/' . $id . '"');
    }

    public static function delete($data)
    {
        extract($data);

        global $conn;
        $sql = "DELETE FROM post WHERE id = $id";
        mysqli_query($conn, $sql);

        $sql = "SELECT image FROM post_image WHERE post_id = $id";
        $query = mysqli_query($conn, $sql);
        $images = mysqli_fetch_all($query, MYSQLI_ASSOC);
        foreach ($images as $image) {
            unlink(__ROOT__ . '/public' . $image['image']);
        }
        $sql = "DELETE FROM post_image WHERE post_id = $id";
        mysqli_query($conn, $sql);

        $sql = "DELETE FROM post_comment WHERE post_id = $id";
        mysqli_query($conn, $sql);

        echo Alert::alerts('ลบโพสต์สำเร็จ', 'success', 1500, 'window.location.href = "/profile/' . $_SESSION['account']['username'] . '"');
    }

    public static function comment($data)
    {
        extract($data);

        $message = $_POST['message'];

        global $conn;
        $sql = "INSERT INTO post_comment (account_id, post_id, message) VALUES (" . $_SESSION['account']['id'] . ", $id, '$message')";
        mysqli_query($conn, $sql);

        header("Location: /post/$id");
    }

    public static function comment_edit($data)
    {
        extract($data);

        $comment_id = $_POST['comment_id'];
        $message = $_POST['message'];

        global $conn;
        $sql = "UPDATE post_comment SET message = '$message' WHERE id = $comment_id";
        mysqli_query($conn, $sql);

        header("Location: /post/$id");
    }

    public static function comment_delete($data)
    {
        extract($data);

        $comment_id = $_POST['comment_id'];

        global $conn;
        $sql = "DELETE FROM post_comment WHERE id = $comment_id";
        mysqli_query($conn, $sql);

        header("Location: /post/$id");
    }
}
