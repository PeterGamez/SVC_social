<nav class="navbar navbar-expand fixed-top">
    <div class="container-fluid">
        <div class="nav-start">
            <div class="navbar-brand d-flex align-items-center">
                <a href="/"><img class="logo" src="/resources/images/logo.png"></a>
                <a class="d-none d-md-block name" href="/">สื่อสังคมออนไลน์</a>
            </div>
        </div>
        <ul class="navbar-nav me-auto d-none d-md-block">
            <li class="nav-item">
                <a class="nav-link fs-4" href="/"><i class="bi bi-house-fill"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto me-auto d-md-none d-block">
            <li class="nav-item">
                <a class="nav-link fs-4" href="/"><i class="bi bi-house-fill"></i></a>
            </li>
        </ul>

        <div class="nav-end">
            <ul class="navbar-nav">
                <?php
                if ($_SESSION['login'] == false) :
                ?>
                    <li class="nav-item">
                        <a href="/login" class="nav-link"><i class="bi bi-door-closed-fill"></i> Login</a>
                    </li>
                <?php
                else :
                ?>
                    <li class="nav-item">
                        <a href="/logout" class="nav-link"><i class="bi bi-door-open-fill"></i> Logout</a>
                    </li>
                <?php
                endif;
                ?>
            </ul>
        </div>
    </div>
</nav>