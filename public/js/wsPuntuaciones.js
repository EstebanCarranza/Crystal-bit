var urlWebService = 'app/Http/Controllers/wsPuntuaciones.php';
//var urlWebService = 'public/wsPuntuaciones.php';
function agregarPartida(_gamename_01, _gamepoints_01, _gamename_02, _gamepoints_02)
{
    var dataToSend =
    {
        action: 'agregarPartida',
        gamename_01: _gamename_01,
        gamepoints_01: _gamepoints_01,
        gamename_02: _gamename_02,
        gamepoints_02: _gamepoints_02
    };

    $.ajax({
        url: urlWebService, 
        async: 'true',
        type: 'POST',
        data: dataToSend,
        dataType: 'json',

        success: function (respuesta) {
            var respuesta = JSON.parse( respuesta );
            if(respuesta != undefined){
                if(respuesta.code == '200'){
                    console.log(respuesta.code);
                }else{
                    console.log('Error: ' + respuesta.code + ', ' + respuesta.msg);
                }
            }else{
                console.log('No se pudo convertir el json');
            }
        },
        error: function (x, h, r) {
            alert("Error: " + x + h + r);

        }

    });
}
function obtenerPartida(_idPartida)
{
    var dataToSend =
    {
        action: 'obtenerPartida',
        idPartida: _idPartida
    };

    $.ajax({
        url: urlWebService,
        async: 'true',
        type: 'POST',
        data: dataToSend,
        dataType: 'json',

        success: function (respuesta) {
            var respuesta = JSON.parse( respuesta );
            if(respuesta != undefined){
                if(respuesta.code == '200'){
                    console.log(respuesta.code);
                }else{
                    console.log('Error: ' + respuesta.code + ', ' + respuesta.msg);
                }
            }else{
                console.log('No se pudo convertir el json');
            }
        },
        error: function (x, h, r) {
            alert("Error: " + x + h + r);

        }

    });
}
function obtenerPuntuaciones(_limit1, _limit2, _idTab)
{
    var dataToSend =
    {
        action: 'obtenerPuntuaciones',
        limit1: _limit1,
        limit2: _limit2,
        idTab: _idTab
    };
    $.ajax({
        
        url: urlWebService,
        async: 'true',
        type: 'POST',
        data: dataToSend,
        /*dataType: 'json',*/

        success: function (respuesta) {
            var respuesta = JSON.parse( respuesta );
            if(respuesta != undefined){
                if(respuesta.code == '200'){
                    for (var i = 0; i < respuesta.data.length; i++) {
                        if(respuesta.data[i].punPlayer1 > respuesta.data[i].punPlayer2)
                        {
                            $(respuesta.data[i]._idTab).append("<tr class='PUN_row'><td>" + respuesta.data[i].nomPlayer1 + "</td><td>" + respuesta.data[i].punPlayer1 + "</td></tr>");
                            $(respuesta.data[i]._idTab).append("<tr class='PUN_row'><td>" + respuesta.data[i].nomPlayer2 + "</td><td>" + respuesta.data[i].punPlayer2 + "</td></tr>");
                        }
                        else
                        {
                            $(respuesta.data[i]._idTab).append("<tr class='PUN_row'><td>" + respuesta.data[i].nomPlayer2 + "</td><td>" + respuesta.data[i].punPlayer2 + "</td></tr>");
                            $(respuesta.data[i]._idTab).append("<tr class='PUN_row'><td>" + respuesta.data[i].nomPlayer1 + "</td><td>" + respuesta.data[i].punPlayer1 + "</td></tr>");
                        }
                        
                    }
                }else{
                    console.log('Error: ' + respuesta.code + ', ' + respuesta.msg);
                }
            }else{
                console.log('No se pudo convertir el json');
            }

        },
        error: function (x, h, r) {
            alert("Error: " + x + h + r);
        }

    });
}