<?= views('layouts/header'); ?>

<body>
    <?= views('layouts/navbar'); ?>

    <div class="login">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center">Register</h1>
                <form action="/register/callback" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" required autofocus placeholder="Username" pattern="[a-zA-Z0-9]{4,}" minlength="4" maxlength="20">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" required placeholder="Email address" maxlength="50">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required placeholder="Password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="confirm_password" required placeholder="Confirm Password">
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                <div class="mt-3">
                    <a href="/login">Already have an account?</a>
                </div>
            </div>
        </div>
    </div>

    <?= views('layouts/footer'); ?>
</body>