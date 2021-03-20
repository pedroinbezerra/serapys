function clickToUpload() {
    $("#moment_img").click();
}

function changeImage() {
    try {
        var filename = $("#moment_img").val();
        var splitFileName = filename.split('\\');
        var lastArrayPosition = splitFileName.length - 1;

        filename = splitFileName[lastArrayPosition];

        if (filename == "") {
            $("#imgTextLabel").html("Selecione uma imagem");
        } else {
            $("#imgTextLabel").html(filename);
        }
    } catch (error) {
        $("#imgTextLabel").html("Selecione uma imagem");
    }
}

function verifyImage() {
    if ($("#moment_img").val() == "") {
        alert("Selecione uma imagem")
    }
}