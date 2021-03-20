<?php ?>

<header class="flex-column flex-md-row align-items-center px-md-4 mb-3">
    <div class="row  mp-zero">
        <div class="col-md-6">
            <a href="index.php">
                <img src="<?= $_SESSION['logo'] ?>" alt="">
            </a>
        </div>
        <div class="col-md-6 mt-3">
            <nav class="my-4 my-md-0 me-md-4 float-right">
                <a class="p-2 text-dark" href="index.php">Início</a>
                <a class="p-2 text-dark" href="memorias.php">Memórias</a>
                <a class="p-2 text-dark" href="admin.php">Admin</a>
            </nav>
        </div>
    </div>
</header>