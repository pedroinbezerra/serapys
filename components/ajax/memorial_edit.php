<?php
require_once('../../assist/classes/mConnect.php');

if (isset($_POST['id_memorial'])) {

    require_once('../../assist/classes/mMemorial.php');
    $mMemorial = new mMemorial();
    $memorial = $mMemorial->getMemorial($_POST['id_memorial']);
?>
    <div class="col-md-12">

        <input type="hidden" name="id" value="<?= $memorial['ID'] ?>">
        <center>
            <div class="mt-2">
                <label for="actual_image">Imagem atual</label>
                <br>
                <img id="actual_image" src="<?= $memorial['IMAGE'] ?>" alt="" width="30%">
            </div>
        </center>

        <div class="mt-2">
            <label for="moment_img">Nova imagem</label>
            <input class="form-control" id="moment_img" name="image" type="file" accept="image/*" onchange="changeImage()" />
        </div>

        <div class="mt-2">
            <label for="name">Nome</label>
            <input class="form-control" type="text" name="name" maxlength="64" value="<?= $memorial['NAME'] ?>" required>
        </div>

        <div class="mt-2">
            <label for="surname">Sobrenome</label>
            <input class="form-control" type="text" name="surname" maxlength="64" value="<?= $memorial['SURNAME'] ?>" required>
        </div>

        <div class="mt-2">
            <label for="birth">Data de Nascimento</label>
            <input class="form-control date" type="text" name="birth" value="<?= $memorial['BIRTH'] ?>" required>
        </div>

        <div class="mt-2">
            <label for="death">Data de Falecimento</label>
            <input class="form-control date" type="text" name="death" value="<?= $memorial['DEATH'] ?>" required>
        </div>

        <div class="mt-2 mb-4">
            <label for="death">Biografia</label>
            <input class="form-control" type="textarea" name="biography" value="<?= $memorial['BIOGRAPHY'] ?>" required>
        </div>
    </div>
<?php
} else {
    return 'error';
}
?>