<?php
require_once('./components/config.php');
require_once('assist/classes/mMemorial.php');

$mMemorial = new mMemorial();

if (isset($_POST['createMemorial'])) {
    if ($mMemorial->manageMemorial($_POST['name'], $_POST['surname'], $_POST['birth'], $_POST['death'], $_POST['biography'], $_FILES['image'], 'insert')) {
        header('location: admin.php?create=1');
    } else {
        header('location: admin.php?create=0');
    }
}

if (isset($_POST['editMemorial'])) {
    if ($_FILES['image']['size'] == 0) {
        $_FILES['image'] = '';
    }

    if ($mMemorial->manageMemorial($_POST['name'], $_POST['surname'], $_POST['birth'], $_POST['death'], $_POST['biography'], $_FILES['image'], 'update', $_POST['id'])) {
        header('location: admin.php?edit=1');
    } else {
        header('location: admin.php?edit=0');
    }
}

if (isset($_POST['deleteMemorial'])) {
    if ($mMemorial->deleteMemorial($_POST['id'])) {
        header('location: admin.php?delete=1');
    } else {
        header('location: admin.php?delete=0');
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_SESSION['app_title'] ?> - Memoriais</title>

    <link rel="stylesheet" href="css/navbar.css">

    <?php require_once('components/script.php'); ?>

    <script type="text/javascript" src="js/admin.js"></script>
    <script type="text/javascript" src="vendor/jquery.quicksearch.js"></script>
    <script type="text/javascript" src="vendor/jQuery-Mask-Plugin/jquery.mask.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.date').mask('00/00/0000');
        });
    </script>
</head>

<body>

    <?php require_once('./components/navbar.php'); ?>
    <br>
    <center>
        <h1 class="mb-5">Memoriais</h1>
    </center>

    <?php if (isset($_GET['create']) && $_GET['create'] == 1) { ?>
        <center><br>
            <div class="col-md-8">
                <div class="alert alert-success" role="alert">Memorial cadastrador com sucesso.</div>
            </div><br>
        </center>
    <?php }
    if (isset($_GET['create']) && $_GET['create'] == 0) { ?>
        <center><br>
            <div class="col-md-8">
                <div class="alert alert-danger" role="alert">Erro ao cadastrar memorial.</div>
            </div><br>
        </center>
    <?php }
    if (isset($_GET['edit']) && $_GET['edit'] == 1) { ?>
        <center><br>
            <div class="col-md-8">
                <div class="alert alert-success" role="alert">Memorial editado com sucesso.</div>
            </div><br>
        </center>
    <?php }
    if (isset($_GET['edit']) && $_GET['edit'] == 0) { ?>
        <center><br>
            <div class="col-md-8">
                <div class="alert alert-danger" role="alert">Erro ao editar memorial.</div>
            </div><br>
        </center>
    <?php }
    if (isset($_GET['delete']) && $_GET['delete'] == 1) { ?>
        <center><br>
            <div class="col-md-8">
                <div class="alert alert-success" role="alert">Memorial excluído com sucesso.</div>
            </div><br>
        </center>
    <?php }
    if (isset($_GET['delete']) && $_GET['delete'] == 0) { ?>
        <center><br>
            <div class="col-md-8">
                <div class="alert alert-danger" role="alert">Erro ao excluir memorial.</div>
            </div><br>
        </center>
    <?php } ?>

    <div class="form-group input-group col-md-12">
        <div class="col-md-2">
            <!-- Button trigger modal novo memorial -->
            <button type="button" class="btn btn-primary btn-row mb-2" data-toggle="modal" data-target="#createMemorial">
                Novo memorial
            </button>
        </div>
        <div class="col-md-6"></div>
        <div class="col-md-4">
            <input name="consulta" id="txt_consulta" placeholder="Buscar" type="text" class="form-control">
        </div>
    </div>
    <br>

    <table id="tabela" class="table table-hover table-responsive-xl">
        <thead>
            <tr>
                <th></th>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Sobrenome</th>
                <th scope="col">Nascimento</th>
                <th scope="col">Falecimento</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>

            <?php
            $memorials = $mMemorial->getMemorials();

            foreach ($memorials as $m) {
            ?>
                <tr>
                    <td></td>
                    <td><?= $m['ID'] ?></td>
                    <td><?= $m['NAME'] ?></td>
                    <td><?= $m['SURNAME'] ?></td>
                    <td><?= $m['BIRTH'] ?></td>
                    <td><?= $m['DEATH'] ?></td>
                    <td>
                        <div class="row">
                            <button type="button" class="btn btn-primary btn-row mr-1" title="Editar" data-toggle="modal" data-target="#editMemorial" onclick="editMemorial(<?= $m['ID'] ?>)">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-row mr-1" title="Excluir" data-toggle="modal" data-target="#deleteMemorial" onclick="deleteMemorial(<?= $m['ID'] ?>)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Modal novo memorial-->
    <div class="modal fade" id="createMemorial" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form enctype="multipart/form-data" action="admin.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title">Novo memorial</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div>
                                <label for="image">Imagem</label>
                                <input class="form-control" id="moment_img" name="image" type="file" accept="image/*" required onchange="changeImage()" />
                            </div>

                            <div class="mt-2">
                                <label for="name">Nome</label>
                                <input class="form-control" type="text" name="name" maxlength="64" required>
                            </div>

                            <div class="mt-2">
                                <label for="surname">Sobrenome</label>
                                <input class="form-control" type="text" name="surname" maxlength="64" required>
                            </div>

                            <div class="mt-2">
                                <label for="birth">Data de Nascimento</label>
                                <input class="form-control date" type="text" name="birth" required>
                            </div>

                            <div class="mt-2">
                                <label for="death">Data de Falecimento</label>
                                <input class="form-control date" type="text" name="death" required>
                            </div>

                            <div class="mt-2 mb-4">
                                <label for="death">Biografia</label>
                                <input class="form-control" type="textarea" name="biography" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            <input type="submit" name="createMemorial" class="btn btn-success" value="Salvar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal editar memorial-->
    <div class="modal fade" id="editMemorial" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form enctype="multipart/form-data" action="admin.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar memorial</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="bodyEditMemorial">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <input type="submit" name="editMemorial" class="btn btn-success" value="Salvar alterações">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal excluir memorial-->
    <div class="modal fade" id="deleteMemorial" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="admin.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title">Excluir memorial</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="bodyDeleteMemorial">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <input type="submit" name="deleteMemorial" class="btn btn-success" value="Excluir" title="Essa ação não pode ser desfeita">
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

<script>
    $('input#txt_consulta').quicksearch('table#tabela tbody tr');

    setTimeout(() => {
        $(".alert").fadeOut("3000")
    }, 5000);
</script>

</html>