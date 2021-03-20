<?php
require_once('../../assist/classes/mConnect.php');

if (isset($_POST['id_memorial'])) {

    require_once('../../assist/classes/mMemorial.php');
    $mMemorial = new mMemorial();
    $memorial = $mMemorial->getMemorial($_POST['id_memorial']);
?>
    <div class="col-md-12">
        <strong>Confirma a exclusão do memorial abaixo?</strong>
        <br><br>
        <center>
            <img src="<?= $memorial['IMAGE'] ?>" alt="" width="40%">
            <br><br>
            <h5><?= $memorial['NAME'] ?></h5>
        </center>

        <input type="hidden" name="id" value="<?= $memorial['ID'] ?>">
    </div>
<?php } ?>