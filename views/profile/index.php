<?= views('layouts/header'); ?>

<body>
    <?= views('layouts/navbar'); ?>

    <main>
        <div class="card">
            <div class="card-body">
                <div class="profile-title d-flex align-items-center">
                    <img class="logo" src="<?= $result['account']['avatar'] ?>">
                    <div class="name">
                        <div class="displayname"><?= $result['account']['displayname'] ?></div>
                        <div class="main"><?= $result['account']['username'] ?></div>
                    </div>
                    <?php
                    if (isset($_SESSION['account']) and $_SESSION['account']['username'] == $result['account']['username']) :
                    ?>
                        <div class="extra">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#profile-edit"><i class="bi bi-pencil-square"></i> แก้ไขข้อมูลส่วนตัว</button>
                        </div>
                    <?php
                    endif;
                    ?>
                </div>

                <?php
                if (isset($_SESSION['account']) and $_SESSION['account']['id'] == $result['account']['id']) :
                ?>
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="post-input d-flex align-items-center">
                                <a href="/profile/<?= $_SESSION['account']['username'] ?>">
                                    <img class="logo" src="<?= $_SESSION['account']['avatar'] ?>">
                                </a>
                                <div class="input">
                                    <button data-bs-toggle="modal" data-bs-target="#post-input">คุณคิดอะไรอยู่ <?= $_SESSION['account']['displayname'] ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                endif;
                ?>
                <?php
                for ($i = 0; $i < count($post); $i++) :
                ?>
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="post-title d-flex align-items-center">
                                <img class="logo" src="<?= $result['account']['avatar'] ?>"></a>
                                <div class="name">
                                    <?= $result['account']['displayname'] ?>
                                </div>
                                <div class="extra">
                                    <a href="/post/<?= $post[$i]['post']['id'] ?>" target="_blank">
                                        <i class="bi bi-three-dots"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="post-info"><?= $post[$i]['post']['message'] ?></div>
                            <?php
                            if (count($post[$i]['images']) > 0) {
                                $p1 = count($post[$i]['images']) > 1 ? 2 : 1;
                                $p2 = count($post[$i]['images']) > 3 ? 2 : 1;
                                $p3 = count($post[$i]['images']) > 4 ? 3 : $p2;
                                echo '<div class="post-img">
                                        <div class="row row-cols-1 row-cols-sm-' . $p1 . ' gx-1 gy-1">';
                                for ($j = 0; $j < count($post[$i]['images']) && $j < 2; $j++) {
                                    echo '<div class="col">
                                            <img src="' . $post[$i]['images'][$j] . '">
                                        </div>';
                                }
                                echo '</div>';
                                if (count($post[$i]['images']) > 2) {
                                    echo '<div class="row row-cols-1 row-cols-sm-' . $p2 . ' row-cols-md-' . $p3 . ' gx-1 gy-1 pt-1">';
                                    for ($i = 2; $j < count($post[$i]['images']); $j++) {
                                        echo '<div class="col">
                                                <img src="' . $post[$i]['images'][$j] . '">
                                            </div>';
                                    }
                                    echo '</div>';
                                }
                                echo '</div>';
                            }
                            ?>
                            <div class="post-comment"><a class="btn" href="/post/<?= $post[$i]['post']['id'] ?>" target="_blank">ความคิดเห็น จำนวน <?= $post[$i]['post']['comment'] ?> ข้อความ</a></div>
                        </div>
                    </div>
                <?php
                endfor;
                ?>
            </div>
        </div>
    </main>

    <?php
    if (isset($_SESSION['account']) and $_SESSION['account']['id'] == $result['account']['id']) :
    ?>
        <div class="modal fade profile" id="profile-edit" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">แก้ไขโปรไฟล์</h3>
                        <div class="close">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                    <!-- item center -->
                    <div class="modal-body">
                        <form class="row gy-2" action="/profile/<?= $_SESSION['account']['username'] ?>/edit" method="POST" enctype="multipart/form-data">
                            <div class="col-12 col-md-4">
                                ชื่อผู้ใช้ <span class="text-danger">*</span>
                            </div>
                            <div class="col-12 col-md-8">
                                <input type="text" class="form-control" name="username" value="<?= $_SESSION['account']['username'] ?>" required minlength="4" maxlength="20">
                            </div>

                            <div class="col-12 col-md-4">
                                อีเมล <span class="text-danger">*</span>
                            </div>
                            <div class="col-12 col-md-8">
                                <input type="email" class="form-control" name="email" value="<?= $_SESSION['account']['email'] ?>" required>
                            </div>

                            <div class="col-12 col-md-4">
                                ชื่อที่แสดง <span class="text-danger">*</span>
                            </div>
                            <div class="col-12 col-md-8">
                                <input type="text" class="form-control" name="displayname" value="<?= $_SESSION['account']['displayname'] ?>" required minlength="4" maxlength="30">
                            </div>

                            <div class="col-12 col-md-4">
                                รูปโปรไฟล์
                            </div>
                            <div class="col-12 col-md-8">
                                <input type="file" class="form-control" name="avatar" accept="image/*">
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-floppy-fill"></i> บันทึก</button>
                            </div>
                        </form>
                        <form class="row gy-2 mt-3" action="/profile/<?= $_SESSION['account']['username'] ?>/password" method="POST">
                            <div class="col-12 col-md-4">
                                เปลี่ยนรหัสผ่าน <span class="text-danger">*</span>
                            </div>
                            <div class="col-12 col-md-8">
                                <input type="password" class="form-control" name="password">
                            </div>

                            <div class="col-12 col-md-4">
                                ยืนยันรหัสผ่าน <span class="text-danger">*</span>
                            </div>
                            <div class="col-12 col-md-8">
                                <input type="password" class="form-control" name="confirm_password">
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-floppy-fill"></i> บันทึก</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade post-input" id="post-input" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">สร้างโพสต์</h3>
                        <div class="close">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form action="/post" method="post" enctype="multipart/form-data">
                            <div class="post-title d-flex align-items-center">
                                <img class="logo" src="<?= $_SESSION['account']['avatar'] ?>">
                                <div class="name">
                                    <?= $_SESSION['account']['displayname'] ?>
                                </div>
                            </div>
                            <div class="mt-2">
                                <textarea rows="10" name="message" placeholder="คุณคิดอะไรอยู่ <?= $_SESSION['account']['displayname'] ?>" required maxlength="1000"></textarea>
                            </div>
                            <div class="mt-2">
                                <input class="form-control" type="file" name="file[]" multiple accept="image/*">
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary">โพสต์</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php
    endif;
    ?>

    <?= views('layouts/footer'); ?>

    <script>
        $('#posts').linkify({
            target: "_blank"
        });
    </script>
</body>