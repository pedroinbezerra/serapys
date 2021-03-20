function editMemorial(id_memorial) {
    $.ajax({
        type: "POST",
        url: "components/ajax/memorial_edit.php",
        data: {
            id_memorial: id_memorial
        },
        success: function (html) {
            $("#bodyEditMemorial").html(html);
        }
    });
}

function deleteMemorial(id_memorial) {
    $.ajax({
        type: "POST",
        url: "components/ajax/memorial_delete.php",
        data: {
            id_memorial: id_memorial
        },
        success: function (html) {
            $("#bodyDeleteMemorial").html(html);
        }
    });
}


function updateStatusClient(id_client) {
    $.ajax({
        type: "POST",
        url: "components/ajax/client/client_updateStatus.php",
        data: {
            id_client: id_client
        },
        success: function (html) {
            $("#bodyupdateStatusClient").html(html);
        }
    });
}