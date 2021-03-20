<?php

require_once('./components/config.php');
require_once('assist/classes/mMemorial.php');

$mMemorial = new mMemorial();

$page = $_GET["page"] ?? 1;
$begin = $page - 1;
$maximum = 4;
$begin = $maximum * $begin;

$total = $mMemorial->countMemorials();
$memories = $mMemorial->getMemorialsWithPagination($begin, $maximum);

if (isset($_POST['new_memorial'])) {
    if ($mMemorial->manageMemorial($_POST['name'], $_POST['surname'], $_POST['birth'], $_POST['death'], $_POST['biography'], $_FILES['image'], 'insert')) {
        header('location: memorias.php?created=1');
    } else {
        header('location: memorias.php?created=0');
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_SESSION['app_title'] ?> - Memórias</title>

    <?php require_once('components/script.php');    ?>

    <link rel="stylesheet" href="css/memorias.css">

    <script type="text/javascript" src="vendor/jQuery-Mask-Plugin/jquery.mask.min.js"></script>
    <script type="text/javascript" src="js/memorias.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.date').mask('00/00/0000');
        });
    </script>
</head>

<body>
    <header class="flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 mp-zero">
        <?php require_once('components/navbar.php');    ?>
    </header>

    <!-- Mesagens de feedback - Inicio -->
    <?php if (isset($_GET['created']) && $_GET['created'] == 1) { ?>
        <center><br>
            <div class="col-md-8">
                <div class="alert alert-success" role="alert">Memorial cadastrador com sucesso.</div>
            </div><br>
        </center>
    <?php }
    if (isset($_GET['created']) && $_GET['created'] == 0) { ?>
        <center><br>
            <div class="col-md-8">
                <div class="alert alert-danger" role="alert">Erro ao cadastrar memorial. Tente novamente</div>
            </div><br>
        </center>
    <?php } ?>
    <!-- Mesagens de feedback - Fim -->

    <div class="col-md-12 mb-5">
        <div class="row">

            <!-- Card de cadastro - Inicio -->
            <div class="col-lg-3 col-md-3 col-sm-12 card-form">
                <div class="card card-shadow">
                    <div class="card-body">
                        <form enctype="multipart/form-data" action="memorias.php" method="post">
                            <h5 class="text-center fw400">Crie uma memória</h5>
                            <div class="form-group">

                                <center>
                                    <div onclick="clickToUpload()">
                                        <img src="img/logo_only.png" alt="" class="moment-img">
                                        <p id="imgTextLabel" class="lightpink">Selecione uma imagem</p>
                                    </div>
                                </center>

                                <div class="col-md-12 mb-5">
                                    <input id="moment_img" name="image" type="file" class="d-none" accept="image/*" required onchange="changeImage()" />
                                </div>

                                <div class="row mt-5">
                                    <div class="ml-3 col-md-5 wrap-input">
                                        <label for="name" class="lightpink">Nome</label>
                                        <input class="input-width-100" type="text" name="name" maxlength="64" required>
                                    </div>

                                    <div class="col-md-5 wrap-input ml-2">
                                        <label for="surname" class="lightpink">Sobrenome</label>
                                        <input class="input-width-100" type="text" name="surname" maxlength="64" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="ml-3 col-md-5 wrap-input">
                                        <label for="birth" class="lightpink">Data de Nascimento</label>
                                        <input class="input-width-100 date" type="text" name="birth" required>
                                    </div>

                                    <div class="ml-3 col-md-5 wrap-input">
                                        <label for="death" class="lightpink">Data de Falecimento</label>
                                        <input class="input-width-100 date" type="text" name="death" required>
                                    </div>
                                </div>

                                <center>
                                    <div class="col-md-12 wrap-input">
                                        <label for="death" class="lightpink">Biografia</label>
                                        <input class="input-width-100" type="text" name="biography">
                                    </div>
                                    <br>
                                </center>
                            </div>

                            <center>
                                <button type="submit" class="btn btn-primary card-button mb-2" name="new_memorial" onclick="verifyImage()">Cadastrar</button>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Card de cadastro - Fim -->

            <!-- Card de exemplo - Inicio -->
            <div class="col-lg-2 col-md-3 col-sm-12 card-example">
                <div class="card card-shadow">
                    <div class="card">
                        <img src="img/img-3.png" class="card-img-top img-card" alt="...">
                    </div>

                    <div class="card body-card">
                        <div class="card-body">
                            <h5 class="card-title text-center lightpink">Nome</h5>
                            <h5 class="card-title text-center fw300 mt-4">1995 - 2021</h5>
                            <p class="card-text mt-4">Com suporte a texto embaixo, que funciona como uma introdução a um conteúdo adicional.</p>
                            <center>
                                <span class="btn btn-primary card-button mt-4">Biografia</span>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card de exemplo - Fim -->

            <!-- Texto principal - Inicio -->
            <div class="mt-5 memorial-text">
                <h1>Sua aplicação de memorial digital</h1>
                <div class="memorial-text">
                    <p>
                        Um lugar para relembrar sua família ou pessoas queridas
                    </p>
                    <ul>
                        <li>Um espaço para memoriais</li>
                        <li>Envie mensagens e tributos</li>
                        <li>Guarde memórias</li>
                        <li>Crie um memorial</li>
                    </ul>
                </div>

            </div>
            <!-- Texto principal - Fim -->

        </div>
    </div>

    <center>
        <h1 class="section">Memoriais</h1>
    </center>

    <!-- Listagem de memoriais - Inicio -->
    <div class="row mt-5 ml-2 mr-2">
        <?php foreach ($memories as $m) { ?>
            <div class="col-md-3 mt-5">
                <div class="card card-shadow">
                    <div class="card">
                        <img src="<?= $m['IMAGE'] ?>" class="card-img-top img-card" alt="...">
                    </div>

                    <div class="card body-card">
                        <div class="card-body">
                            <h5 class="card-title text-center lightpink"><?= $m['NAME'] ?></h5>
                            <h5 class="card-title text-center fw300 mt-4"><?= $m['BIRTH'] ?> - <?= $m['DEATH'] ?></h5>
                            <p class="card-text mt-4 mb-5"><?= substr($m['BIOGRAPHY'], 0, 30)  ?></p>
                            <!-- <center>
                                <a href="#" class="btn btn-primary card-button mt-4">Biografia</a>
                            </center> -->
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <!-- Listagem de memoriais - Fim -->

    <!-- Paginação - Inicio -->
    <nav class="mt-5 mb-5">
        <ul class="pagination justify-content-center">
            <?php
            $back = $page - 1;
            $next = $page + 1;
            $pgs = ceil($total / $maximum);

            if ($pgs > 1) {
                echo "<br />";

                if ($back > 0) {
                    echo "<li class=\"page-item\"><a class=\"page-link\" href=\"" . $_SERVER['PHP_SELF'] . "?page={$back}\">Anterior</a></li>";
                }

                for ($i = 1; $i <= $pgs; $i++) {
                    if ($i != $page) {
                        echo "<li class=\"page-item\"><a class=\"page-link\" href=\"" . $_SERVER['PHP_SELF'] . "?page=" . ($i) . "\">$i</a></li>";
                    } else {
                        echo "<li class=\"page-item disabled\"><a class=\"page-link\" href=\"#\">$i</a></li>";
                    }
                }
                if ($next <= $pgs) {
                    echo "<li class=\"page-item\"><a class=\"page-link\" href=\"" . $_SERVER['PHP_SELF'] . "?page={$next}\">Próxima</a></li>";
                }
            }
            ?>
        </ul>
    </nav>
    <!-- Paginação - Fim -->
</body>

</html>