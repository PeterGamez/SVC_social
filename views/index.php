<?= views('layouts/header'); ?>

<body>
    <?= views('layouts/navbar'); ?>

    <main>
        <?php
        if (isset($_SESSION['account'])) :
        ?>
            <div class="card">
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
        <div id="posts">
        </div>
    </main>

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

    <?= views('layouts/footer'); ?>
</body>