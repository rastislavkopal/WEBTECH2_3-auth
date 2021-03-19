$(document).ready( function () {
    // setOauthLoginButton();
} );

// function setOauthLoginButton(){
//     $.get( "https://wt78.fei.stuba.sk/zadanie3/api/oauth", function( data ) {
//         $( "#google-oauth" ).attr("href", data)
//     }).always(function() {
//         console.log("done");
//     });
// }

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

function goRegister()
{
    $("#login-form").css("display", "none");
    $("#register-form").css("display", "block");

    $("#2fa-register").empty();

    $.ajax({
        url: "https://wt78.fei.stuba.sk/zadanie3/api/register/2fa",
        type: 'GET',
        dataType: 'json',
        success: function(response){
            $("#2fa-register").append("<p>Uložte si svoj overovací klúč: <b>" + response['secret'] + "</b></p>")
            $("#2fa-register").append('<input name="secret" value="' + response['secret'] + '" type="hidden">')
            $("#2fa-register").append("<img src='" + response['qrCodeUrl'] + "'>")
        }
    });
}


function goLogin()
{
    $("#login-form").css("display", "block");
    $("#register-form").css("display", "none");
}

function loginUser(){
    let data = $('#login-form').serializeArray();

    var formData = {
        "email": data[0]["value"],
        "password": data[1]["value"],
        "code": data[2]["value"],
    };

    $.ajax({
        url: 'https://wt78.fei.stuba.sk/zadanie3/api/login',
        type: 'POST',
        data: formData,
        dataType: 'text',
        success: function (response){
        if (response[0] == "1"){
            displayMessage(response.substring(1));
            location.reload();
        } else {
            displayMessage(response);
        }
    }
    });
}

function registerUser()
{
    let data = $('#register-form').serializeArray();

    var formData = {
        "email": data[0]["value"],
        "password": data[1]["value"],
        "password-again": data[2]["value"],
        "secret": data[3]["value"],
    };

    $.ajax({
        url: 'https://wt78.fei.stuba.sk/zadanie3/api/register',
        type: 'POST',
        data: formData,
        dataType: 'text',
        success: function (){
            location.reload();
        },
    });
}


function logoutUser()
{
    $.ajax({
        url: "http://wt78.fei.stuba.sk/zadanie3/api/logout",
        type: 'GET',
        dataType: 'json',
        success: displayMessage
    });
}
