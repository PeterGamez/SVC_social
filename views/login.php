<?= views('layouts/header'); ?>

<body>
    <?= views('layouts/navbar'); ?>

    <div class="login">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center">Login</h1>
                <form action="/login/callback" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Username or Email address</label>
                        <input type="text" class="form-control" name="user" required autofocus placeholder="Username or Email address" minlength="4">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required placeholder="Password">
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                <div class="mt-3">
                    <a href="/register">Don't have an account?</a>
                </div>
            </div>
        </div>
    </div>

    <?= views('layouts/footer'); ?>
</body>