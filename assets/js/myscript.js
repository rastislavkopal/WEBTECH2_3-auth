$(document).ready( function () {
    updateListOfOlympicWinners();
} );

function displayMessage(response)
{
    if($('#uploader_div').css('display') != 'none')
        $('#uploader_div').hide('slow');
    var message = $('<div class="alert alert-error error-message" style="display: none;">');
    var close = $('<button type="button" class="close" data-dismiss="alert">&times</button>');
    message.append(close); // adding the close button to the message
    message.append(response);
    message.appendTo($('body')).fadeIn(300).delay(3000).fadeOut(1500);
}


function createPerson()
{
    let data = $('#formAddPerson').serializeArray();

    for (let i = 0; i < 5; i++)
        if (!data[i].value.length) {
            displayMessage("Hodnota '" + data[i]["name"] + "' nesmie byt prazdna");
            return;
        }

    var formData = {
        "name": data[0]["value"],
        "surname": data[1]["value"],
        "birth_day": data[2]["value"],
        "birth_place": data[3]["value"],
        "birth_country": data[4]["value"],
        "death_day": data[5]["value"],
        "death_place": data[6]["value"],
        "death_country": data[7]["value"]
    };

    $.ajax({
        url: 'http://wt78.fei.stuba.sk/zadanie2/controllers/CreatePerson.php',
        type: 'POST',
        data: formData,
        dataType: 'text',
        success: displayMessage,
    });
}

function createPlacement()
{
    let data = $('#formAddPlacement').serializeArray();

    for (let i = 0; i < data.length; i++)
        if (!data[i].value.length) {
            displayMessage("Hodnota '" + data[i]["name"] + "' nesmie byt prazdna");
            return;
        }

    var formData = {
        "person_id": data[0]["value"],
        "oh_id": data[1]["value"],
        "placing": data[2]["value"],
        "discipline": data[3]["value"]
    };

    $.ajax({
        url: 'http://wt78.fei.stuba.sk/zadanie2/controllers/AddPlacement.php',
        type: 'POST',
        data: formData,
        dataType: 'text',
       success: displayMessage,
    });
}
