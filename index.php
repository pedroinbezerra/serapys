<?php

require_once('./components/config.php');

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_SESSION['app_title'] ?> - Início</title>

    <?php require_once('components/script.php'); ?>

    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <div>
        <header class="flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 mp-zero">
            <?php require_once('components/navbar.php');    ?>
        </header>

        <div class="div-primary">
            <div class="mp-zero">
                <div class="col-md-8">
                    <br>
                    <center>
                        <h1>Respeitamos suas crenças</h1>
                        <img src="<?= $_SESSION['logo_only'] ?>" alt="" class="mt-5">

                        <div id="text-primary" class="mt-5">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <img id="img-primary" src="img/img-2.png">

</body>



</html>