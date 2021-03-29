$(document).ready( function () {
    loadStats();
} );

function loadStats()
{
    $.ajax({
        url: "https://wt78.fei.stuba.sk/zadanie3/api/stats",
        type: 'GET',
        dataType: 'json',
        success: response => {
            let data = JSON.parse(JSON.stringify(response));
            $("#log-basic").append("oauth login: " + data[1] )
            $("#log-oauth").append("basic login: " + data[0])
            $("#log-ldap").append("ldap login: " + data[2])
        }
    });
}

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

function goLdap()
{
    $("#ldap-form").css("display", "block");
    $("#register-form").css("display", "none");
    $("#login-form").css("display", "none");
}

function loginLdap()
{
    let data = $('#ldap-form').serializeArray();
    var formData = { "login_name": data[0]["value"], "password": data[1]["value"] };

    $.ajax({
        url: 'https://wt78.fei.stuba.sk/zadanie3/api/ldap',
        type: 'POST',
        data: formData,
        dataType: 'text',
        success: response => {
            if (response[0] == "1") {
                displayMessage(response.substring(1));
                location.reload();
            } else {
                displayMessage(response);
            }
        }
    });
}

function goRegister()
{
    $("#login-form").css("display", "none");
    $("#register-form").css("display", "block");
    $("#ldap-form").css("display", "none");

    $("#2fa-register").empty();

    $.ajax({
        url: "https://wt78.fei.stuba.sk/zadanie3/api/register/2fa",
        type: 'GET',
        dataType: 'json',
        success: function(response){
            $("#2fa-register").append("<p>Uložte si svoj overovací klúč: <b>" + response['secret'] + "</b></p>")
            $("#2fa-register").append('<input name="secret" value="' + response['secret'] + '" type="hidden">')
            $("#2fa-register").append('<span id="scan-qr">Oskenujte následujúci QR kód v mobilnej aplikácií Google Authenticator</span><br>')
            $("#2fa-register").append("<img src='" + response['qrCodeUrl'] + "'>")
        }
    });
}


function goLogin()
{
    $("#login-form").css("display", "block");
    $("#register-form").css("display", "none");
    $("#ldap-form").css("display", "none");
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
        "first_name": data[1]["value"],
        "surname": data[2]["value"],
        "password": data[3]["value"],
        "password-again": data[4]["value"],
        "secret": data[5]["value"],
    };
    console.log(formData)

    $.ajax({
        url: 'https://wt78.fei.stuba.sk/zadanie3/api/register',
        type: 'POST',
        data: formData,
        dataType: 'text',
        success: res => {
            goLogin();
            displayMessage(res)
        },
    });
}


function logoutUser()
{
    $.ajax({
        url: "https://wt78.fei.stuba.sk/zadanie3/api/logout",
        type: 'GET',
        dataType: 'json',
        success: displayMessage
    });
}

function updateHistory()
{
    $.get("https://wt78.fei.stuba.sk/zadanie3/api/userhistory",
        function (data) {
            json = JSON.parse(data)
            $("#table_id").DataTable({
                data: json,
                "searching": false,
                "bInfo": false,
                "paging": false,
                "scrollY":"80%",
                "scrollCollapse": true,
                "destroy": true,
                "order": [[ 2, "desc" ]],
                "columns" : [
                    { "data" : "id", title:'id prihlásenia' },
                    { "data" : "user_email", title:'Email'  },
                    { "data" : "login_time", title:'Čas prihlásenia' },
                    { "data" : "login_type", title:'Typ prihlásenia' },
                ],
            });
        });
}
