<?= views('layouts/header'); ?>

<body>
    <?= views('layouts/navbar'); ?>

    <main>
        <div class="card">
            <div class="card-body">
                <div class="post-title d-flex align-items-center">
                    <a href="/profile/<?= $result['account']['username'] ?>">
                        <img class="logo" src="<?= $result['account']['avatar'] ?>">
                    </a>
                    <div class="name">
                        <a href="/profile/<?= $result['account']['username'] ?>">
                            <?= $result['account']['displayname'] ?>
                        </a>
                    </div>
                    <div class="extra">
                        <?php
                        if (isset($_SESSION['account']) and $result['account']['id'] == $_SESSION['account']['id']) :
                        ?>
                            <div class="dropdown">
                                <div class="btn-group dropstart">
                                    <div class="dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </div>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <div class="dropdown-item" data-bs-toggle="modal" data-bs-target="#post-edit"><i class="bi bi-pencil-square"></i> แก้ไข</div>
                                        </li>
                                        <li>
                                            <div class="dropdown-item" data-bs-toggle="modal" data-bs-target="#post-delete"><i class="bi bi-trash-fill"></i> ลบ</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        <?php
                        endif;
                        ?>
                        <!-- button close -->
                        <div class="close">
                            <button type="button" class="btn-close" onclick="postClose()"></button>
                        </div>
                    </div>
                </div>
                <div class="post-info"><?= $result['post']['message'] ?></div>
                <?php
                if (count($result['images']) > 0) {
                    $p1 = count($result['images']) > 1 ? 2 : 1;
                    $p2 = count($result['images']) > 3 ? 2 : 1;
                    $p3 = count($result['images']) > 4 ? 3 : $p2;
                    echo '<div class="post-img">
                        <div class="row row-cols-1 row-cols-sm-' . $p1 . ' gx-1 gy-1">';
                    for ($i = 0; $i < count($result['images']) && $i < 2; $i++) {
                        echo '<div class="col">
                            <img src="' . $result['images'][$i] . '">
                        </div>';
                    }
                    echo '</div>';
                    if (count($result['images']) > 2) {
                        echo '<div class="row row-cols-1 row-cols-sm-' . $p2 . ' row-cols-md-' . $p3 . ' gx-1 gy-1 pt-1">';
                        for ($i = 2; $i < count($result['images']); $i++) {
                            echo '<div class="col">
                                <img src="' . $result['images'][$i] . '">
                            </div>';
                        }
                        echo '</div>';
                    }
                    echo '</div>';
                }
                ?>
                <div class="post-comment">
                    <div class="card">
                        <div class="card-body">
                            <div class="post-input d-flex align-items-center">
                                <?php
                                if (isset($_SESSION['account'])) :
                                ?>
                                    <a href="/profile/<?= $_SESSION['account']['username'] ?>">
                                        <img class="logo" src="<?= $_SESSION['account']['avatar'] ?>">
                                    </a>
                                    <div class="input">
                                        <button data-bs-toggle="modal" data-bs-target="#comment-input">แสดงความคิดเห็น</button>
                                    </div>
                                <?php
                                else :
                                ?>
                                    <div class="input">
                                        <a href="/login" target="_blank">แสดงความคิดเห็น</a>
                                    </div>
                                <?php
                                endif;
                                ?>
                            </div>
                            <hr>
                            <?php
                            for ($i = 0; $i < count($comments); $i++) :
                            ?>
                                <div class="mt-3 d-flex align-items-center">
                                    <a href="/profile/<?= $comments[$i]['account']['username'] ?>">
                                        <img class="logo" src="<?= $comments[$i]['account']['avatar'] ?>">
                                    </a>
                                    <div>
                                        <div class="name">
                                            <a href="/profile/<?= $comments[$i]['account']['username'] ?>">
                                                <?= $comments[$i]['account']['displayname'] ?>
                                            </a>
                                        </div>
                                        <div class="comment-info" id="comment-<?= $comments[$i]['comment']['id'] ?>"><?= $comments[$i]['comment']['message'] ?></div>
                                    </div>
                                    <div class="extra">
                                        <?php
                                        if ($comments[$i]['account']['id'] == $_SESSION['account']['id']) :
                                        ?>
                                            <div class="dropdown">
                                                <div class="btn-group dropend">
                                                    <div class="dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        <i class="bi bi-three-dots"></i>
                                                    </div>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#comment-edit" data-bs-id="<?= $comments[$i]['comment']['id'] ?>"><i class="bi bi-pencil-square"></i> แก้ไข</button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#comment-delete" data-bs-id="<?= $comments[$i]['comment']['id'] ?>"><i class="bi bi-trash-fill"></i> ลบ</button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        <?php
                                        endif;
                                        ?>
                                    </div>
                                </div>
                            <?php
                            endfor;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    if (isset($_SESSION['account'])) :
    ?>
        <div class="modal fade post-input" id="comment-input" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">แสดงความคิดเห็น</h3>
                        <div class="close">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form action="/post/<?= $result['post']['id'] ?>/comment" method="post" enctype="multipart/form-data">
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
                                <button type="submit" class="btn btn-primary">แสดงความคิดเห็น</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php
    endif;
    ?>

    <?php
    if (isset($_SESSION['account']) and $result['account']['id'] == $_SESSION['account']['id']) :
    ?>
        <div class="modal fade post-input" id="post-edit" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">แก้ไขโพสต์</h3>
                        <div class="close">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form action="/post/<?= $result['post']['id'] ?>/edit" method="post" enctype="multipart/form-data">
                            <div class="post-title d-flex align-items-center">
                                <img class="logo" src="<?= $_SESSION['account']['avatar'] ?>">
                                <div class="name">
                                    <?= $_SESSION['account']['displayname'] ?>
                                </div>
                            </div>
                            <div class="mt-2">
                                <textarea rows="10" name="message" placeholder="คุณคิดอะไรอยู่ <?= $_SESSION['account']['displayname'] ?>" required maxlength="1000"><?= $result['post']['message'] ?></textarea>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-pencil-square"></i> แก้ไข</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade post-input" id="post-delete" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">ลบโพสต์</h3>
                        <div class="close">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form action="/post/<?= $result['post']['id'] ?>/delete" method="post" enctype="multipart/form-data">
                            <div class="post-title d-flex align-items-center">
                                <img class="logo" src="<?= $_SESSION['account']['avatar'] ?>">
                                <div class="name">
                                    <?= $_SESSION['account']['displayname'] ?>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-danger">ลบ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php
    endif;
    ?>

    <?php
    if (isset($_SESSION['account'])) :
    ?>
        <div class="modal fade post-input" id="comment-edit" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">แก้ไขความคิดเห็น</h3>
                        <div class="close">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form action="/post/<?= $result['post']['id'] ?>/comment/edit" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="comment_id">
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
                                <button type="submit" class="btn btn-primary"><i class="bi bi-pencil-square"></i> แก้ไข</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade post-input" id="comment-delete" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">ลบความคิดเห็น</h3>
                        <div class="close">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form action="/post/<?= $result['post']['id'] ?>/comment/delete" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="comment_id">
                            <div class="post-title d-flex align-items-center">
                                <img class="logo" src="<?= $_SESSION['account']['avatar'] ?>">
                                <div class="name">
                                    <?= $_SESSION['account']['displayname'] ?>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-danger"><i class="bi bi-pencil-square"></i> ลบ</button>
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
        $('.post-info').linkify({
            target: "_blank"
        });
        
        function postClose() {
            window.close();
        }
    </script>
</body>