<?= views('layouts/header'); ?>

<body>
    <?= views('layouts/navbar'); ?>

    <div class="error-404">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center">404</h1>
                <div class="text-center">
                    <p>Page not found</p>
                    <a href="/">Go back to home</a>
                </div>
            </div>
        </div>
    </div>
    
    <?= views('layouts/footer'); ?>
</body>