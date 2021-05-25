var thisWebDomain = 'http://'+window.location.hostname+'/';

function objetoAjax()
{
    var xmlhttp = false;
    try
    {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch (e)
    {
        try
        {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch (E)
        {
            xmlhttp = false;
        }
    }

    if (!xmlhttp && typeof XMLHttpRequest!='undefined')
    {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}

function checkLoginUser()
{
    $("#data-loader").fadeIn(300);
    var strHTML = '';

    var data = {};
    var thisURL = thisWebDomain+"cpanel/_controlUser.php?email="+$('#login_email').val()+"&password="+$('#login_password').val();

    $.ajax({
        type: "GET",
        dataType: "json",
        data: JSON.stringify(data),
        url: thisURL,
        contentType: "application/json",
    })
        .done(function( data, textStatus, jqXHR )
        {
            //SI NO EXISTE EL USUARIO
            if (data.length == 0)
            {
                var strHTML = '<div class="media-left"><span class="icon-wrap icon-wrap-xs icon-circle alert-icon icon-2x"><i class="fa fa-user-times" aria-hidden="true"></i></span></div><div class="media-body"><h4 class="alert-title">Datos incorrectos</h4><p class="alert-message">El usuario no existe o la contraseña es incorrecta.</p></div>';

                $.niftyNoty({
                    type: "danger",
                    container: "#userAlert",
                    html: strHTML,
                    closeBtn: 1,
                    focus: true,
                    timer: 5000
                });
                $('#login_email').focus();
                $("#data-loader").fadeOut(300);
            }
            else
            {
                $(".btn-primary").fadeOut(300);
                document.getElementById("formSignInUser").submit();
            }
        });

}

function sendCenterInfo()
{
    //instanciamos el objetoAjax
    ajax = objetoAjax();
    //Abrimos una conexión AJAX pasando como parámetros el método de envío, y el archivo que realizará las operaciones deseadas
    ajax.open("POST", thisWebDomain+"_control/_controlSistemaElectoral.php?action=add_center", true);
    //cuando el objeto XMLHttpRequest cambia de estado, la función se inicia
    ajax.onreadystatechange = function()
    {
        //Cuando se completa la petición, mostrará los resultados
        if (ajax.readyState == 4)
        {
            //resultado.value = (ajax.responseText)
        }
    }
    //Llamamos al método setRequestHeader indicando que los datos a enviarse están codificados como un formulario.
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax.send("&departamento_id="+$("#departamento_id").val()+"&municipio_id="+$("#municipio_id").val()+"&center_name="+$("#center_name").val());

    //sessionStorage.setItem("centerIsCreated", true);

    location.reload();

}

function getPersonaInfo()
{
    $("#divFooter").fadeOut(300);

    $("#data-loader").fadeIn(300);
    var strHTML = '';

    var data = {};
    var thisURL = thisWebDomain+"_control/_controlSistemaElectoral.php?action=search_member&dni="+$('#member_dni').val();

    $.ajax({
        type: "GET",
        dataType: "json",
        data: JSON.stringify(data),
        url: thisURL,
        contentType: "application/json",
    })
        .done(function( data, textStatus, jqXHR )
        {
            //SI NO EXISTE EL USUARIO
            if (data.length == 0)
            {
                var strHTML = '<div class="media-left"><span class="icon-wrap icon-wrap-xs icon-circle alert-icon icon-2x"><i class="fa fa-user-times" aria-hidden="true"></i></span></div><div class="media-body"><h4 class="alert-title">Datos incorrectos</h4><p class="alert-message">El número de identidad no existe en la base de datos.</p></div>';

                $.niftyNoty({
                    type: "danger",
                    container: "#userAlert",
                    html: strHTML,
                    closeBtn: 1,
                    focus: true,
                    timer: 3000
                });
                $('#member_dni').focus();
                $("#data-loader").fadeOut(300);
            }
            else
            {
                sessionStorage.setItem('persona_nombre_1', data[0]["persona_nombre_1"]);
                sessionStorage.setItem('persona_nombre_2', data[0]["persona_nombre_2"]);
                sessionStorage.setItem('persona_apellido_1', data[0]["persona_apellido_1"]);
                sessionStorage.setItem('persona_apellido_2', data[0]["persona_apellido_2"]);
                sessionStorage.setItem('departamento_nombre', data[0]["departamento_nombre"]);
                sessionStorage.setItem('municipio_nombre', data[0]["municipio_nombre"]);

                checkMemberOnMER();
            }
        });
}

function checkMemberOnMER()
{
    $("#data-loader").fadeIn(300);
    var strHTML = '';

    var data = {};
    var thisURL = thisWebDomain+"_control/_controlSistemaElectoral.php?action=check_member&dni="+$('#member_dni').val();

    $.ajax({
        type: "GET",
        dataType: "json",
        data: JSON.stringify(data),
        url: thisURL,
        contentType: "application/json",
    })
        .done(function( data, textStatus, jqXHR )
        {
            //Si NO está asignado en una MER
            if (data.length == 0)
            {
                $("#data-loader").fadeOut(300);
                $("#member_firstname").val(sessionStorage.getItem("persona_nombre_1"));
                $("#member_secondname").val(sessionStorage.getItem("persona_nombre_2"));
                $("#member_surname").val(sessionStorage.getItem("persona_apellido_1"));
                $("#member_lastname").val(sessionStorage.getItem("persona_apellido_2"));
                $("#member_departamento").val(sessionStorage.getItem("departamento_nombre"));
                $("#member_municipio").val(sessionStorage.getItem("municipio_nombre"));

                sessionStorage.clear();

                var strHTML = '<div class="media-left"><span class="icon-wrap icon-wrap-xs icon-circle alert-icon icon-2x"><i class="fas fa-user-check"></i></span></div><div class="media-body"><h4 class="alert-title">¡Listo!</h4><p class="alert-message">El número de identidad fue encontrado.</p><p>El miembro puede ser asignado a la MER.</p></div>';

                $.niftyNoty({
                    type: "info",
                    container: "#userAlert",
                    html: strHTML,
                    closeBtn: 1,
                    focus: true,
                    timer: 4000
                });
                $('#member_dni').focus();
                $("#data-loader").fadeOut(300);

                $("#divFooter").fadeIn(300);
            }
            else
            {
                //Si está asignado en una MER
                var strHTML = '<div class="media-left"><span class="icon-wrap icon-wrap-xs icon-circle alert-icon icon-2x"><i class="fa fa-user-times" aria-hidden="true"></i></span></div><div class="media-body"><h4 class="alert-title">Datos incorrectos</h4><p class="alert-message">Esta persona ya está asignada en una MER.</p></div>';

                $.niftyNoty({
                    type: "warning",
                    container: "#userAlert",
                    html: strHTML,
                    closeBtn: 1,
                    focus: true,
                    timer: 3000
                });
                $('#member_dni').focus();
                $("#data-loader").fadeOut(300);
            }
        });
}

function addMERMember()
{
    //instanciamos el objetoAjax
    ajax = objetoAjax();
    //Abrimos una conexión AJAX pasando como parámetros el método de envío, y el archivo que realizará las operaciones deseadas
    ajax.open("POST", thisWebDomain+"_control/_controlSistemaElectoral.php?action=add_member&mer_id="+$("#txtMERId").val(), true);
    //cuando el objeto XMLHttpRequest cambia de estado, la función se inicia
    ajax.onreadystatechange = function()
    {
        //Cuando se completa la petición, mostrará los resultados
        if (ajax.readyState == 4)
        {
            //resultado.value = (ajax.responseText)
        }
    }
    //Llamamos al método setRequestHeader indicando que los datos a enviarse están codificados como un formulario.
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax.send("&member_dni="+$("#member_dni").val()+"&member_role="+$("#member_role").val());

    location.reload();
}

function dropMember(prmMember, memberDNI)
{
    Swal.fire({
        title: '¿Desea remover a\n'+prmMember+'?',
        text: "Esta acción no es reversible.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#8bc34a',
        confirmButtonText: 'Sí. Removerlo',
        cancelButtonColor: '#f55145',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            //instanciamos el objetoAjax
            ajax = objetoAjax();
            //Abrimos una conexión AJAX pasando como parámetros el método de envío, y el archivo que realizará las operaciones deseadas
            ajax.open("POST", thisWebDomain+"_control/_controlSistemaElectoral.php?action=remove_member&mer_id="+memberDNI, true);
            //cuando el objeto XMLHttpRequest cambia de estado, la función se inicia
            ajax.onreadystatechange = function()
            {
                //Cuando se completa la petición, mostrará los resultados
                if (ajax.readyState == 4)
                {
                    //resultado.value = (ajax.responseText)
                }
            }
            //Llamamos al método setRequestHeader indicando que los datos a enviarse están codificados como un formulario.
            ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
            ajax.send("&member_dni="+memberDNI);

            $("#member_"+memberDNI).fadeOut(300);

            Swal.fire(
                '¡Removido!',
                'El miembro fue removido de la MER.',
                'success'
            )
        }
    })
}

function createActionLog(actionID)
{
    //instanciamos el objetoAjax
    ajax = objetoAjax();
    //Abrimos una conexión AJAX pasando como parámetros el método de envío, y el archivo que realizará las operaciones deseadas
    ajax.open("POST", thisWebDomain+"_control/_controlSistemaElectoral.php?action=create_log_record", true);
    //cuando el objeto XMLHttpRequest cambia de estado, la función se inicia
    ajax.onreadystatechange = function()
    {
        //Cuando se completa la petición, mostrará los resultados
        if (ajax.readyState == 4)
        {
            //resultado.value = (ajax.responseText)
        }
    }
    //Llamamos al método setRequestHeader indicando que los datos a enviarse están codificados como un formulario.
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax.send("&persona_dni="+$("#persona_dni").val()+"&action_id="+actionID);

}

function LoginMERMember()
{
    $("#data-loader").fadeIn(300);
    var strHTML = '';

    var data = {};
    var thisURL = thisWebDomain+"_control/_controlSistemaElectoral.php?action=login_mer_member&dni="+$('#member_dni').val()+"&password="+$('#login_password').val();

    $.ajax({
        type: "GET",
        dataType: "json",
        data: JSON.stringify(data),
        url: thisURL,
        contentType: "application/json",
    })
        .done(function( data, textStatus, jqXHR )
        {
            //SI NO EXISTE EL USUARIO
            if (data.length == 0)
            {
                var strHTML = '<div class="media-left"><span class="icon-wrap icon-wrap-xs icon-circle alert-icon icon-2x"><i class="fa fa-user-times" aria-hidden="true"></i></span></div><div class="media-body"><h4 class="alert-title">Datos incorrectos</h4><p class="alert-message">El usuario no existe o la contraseña es incorrecta.</p></div>';

                $.niftyNoty({
                    type: "danger",
                    container: "#userAlert",
                    html: strHTML,
                    closeBtn: 1,
                    focus: true,
                    timer: 5000
                });
                $('#member_dni').focus();
                $("#data-loader").fadeOut(300);
            }
            else
            {
                $(".btn-primary").fadeOut(300);
                document.getElementById("formSignInMember").submit();
                createActionLog(101);
            }
        });

}

function getInfoVotante()
{
    $("#personaInfo").fadeOut(300);
    $("#data-loader").fadeIn(300);
    var strHTML = '';

    var data = {};
    var thisURL = thisWebDomain+"_control/_controlSistemaElectoral.php?action=search_voter&dni="+$('#persona_dni').val()+"&token="+$('#persona_token').val();

    console.log(thisURL);

    $.ajax({
        type: "GET",
        dataType: "json",
        data: JSON.stringify(data),
        url: thisURL,
        contentType: "application/json",
    })
        .done(function( data, textStatus, jqXHR )
        {
            //1. Revisar que el votante exista en la población
            if (data.length == 0)
            {
                //AQUÍ DEBO CREAR EL LOG DE BUSQUEDA DICIENDO QUE EL DATO NO HA SIDO ENCONTRADO
                createActionLog(205); //Buscó a [persona] y no la encontró en el registro de votantes.

                //Si no existe en la población
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: 'El número de identidad no está registrado en la base de datos de personas habilitadas para votar.<br>Confirme que el número de identidad y el Token hayan sido escritos correctamente.'
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $('#persona_dni').focus();
                    } else if (result.isDenied) {

                    }
                });

                $('#persona_dni').focus();
                $("#data-loader").fadeOut(300);
            }
            else
            {
                //Si existe en la población

                sessionStorage.setItem('persona_dni', data[0]["persona_dni"]);
                sessionStorage.setItem('persona_nombre_1', data[0]["persona_nombre_1"]);
                sessionStorage.setItem('persona_nombre_2', data[0]["persona_nombre_2"]);
                sessionStorage.setItem('persona_apellido_1', data[0]["persona_apellido_1"]);
                sessionStorage.setItem('persona_apellido_2', data[0]["persona_apellido_2"]);
                sessionStorage.setItem('departamento_nombre', data[0]["departamento_nombre"]);
                sessionStorage.setItem('municipio_nombre', data[0]["municipio_nombre"]);
                sessionStorage.setItem('mer_id', data[0]["mer_id"]);

                //Si el votante existe debo comprobar que le corresponde votar en la MER donde está el miembro MER
                comparePersonOnMER();

            }
        });
}

function logOutMERMember()
{
    Swal.fire({
        title: '¿Cerrar sesión?',
        text: "Para poder continuar recibiendo votantes deberá volver a iniciar sesión",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#92c755',
        cancelButtonColor: '#f44336',
        confirmButtonText: 'Sí, cerrar sesión',
        cancelButtonText : 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "../_control/_controlSistemaElectoral.php?action=logout_mer_member";
        }
    })
}

function comparePersonOnMER()
{
    var data = {};
    var thisURL = thisWebDomain+"_control/_controlSistemaElectoral.php?action=compare_mer_person&persona_dni="+$('#persona_dni').val();
    console.log(thisURL);
    $.ajax({
        type: "GET",
        dataType: "json",
        data: JSON.stringify(data),
        url: thisURL,
        contentType: "application/json",
    })
    .done(function( data, textStatus, jqXHR )
    {
        if (data.length == 0)
        {
            //SI NO PERTENECE A LA MER
            createActionLog(204);

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'La persona buscada no está habilitada para votar en la MER actual.'
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $('#persona_dni').focus();
                    $("#data-loader").fadeOut(300);
                } else if (result.isDenied) {

                }
            });
        }
        else
        {
            //SI PERTENCE A LA MER
            createActionLog(201);
            //Reviso que haya espacio para agregarlo a la lista de votantes activos
            checkAvailableSpace();
        }
    });
}

function checkAvailableSpace()
{
    //Reviso que haya espacio para agregarlo a la lista de votantes activos
    var data = {};
    var thisURL = thisWebDomain+"_control/_controlSistemaElectoral.php?action=check_available_space";

    $.ajax({
        type: "GET",
        dataType: "json",
        data: JSON.stringify(data),
        url: thisURL,
        contentType: "application/json",
    })
        .done(function( data, textStatus, jqXHR )
        {
            if (data.length >= 3)
            {
                //NO hay espacio en la lista de votantes
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Solo puede haber un máximo de 3 personas en lista de votantes.'
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $('#persona_dni').focus();
                        $("#data-loader").fadeOut(300);
                    } else if (result.isDenied) {

                    }
                });
            }
            else
            {
                //SÍ hay espacio en la lista de votantes
                //Reviso si el votante No se encuentra en la lista de votantes
                checkPersonVoting();
            }
        });
}

function checkPersonVoting()
{
    var data = {};
    var thisURL = thisWebDomain+"_control/_controlSistemaElectoral.php?action=check_person_voting&persona_dni="+$('#persona_dni').val();

    console.log(thisURL);

    $.ajax({
        type: "GET",
        dataType: "json",
        data: JSON.stringify(data),
        url: thisURL,
        contentType: "application/json",
    })
    .done(function( data, textStatus, jqXHR )
    {
        if (data.length == 0)
        {
            //NO está en la lista de votantes activos
            //Verifico que no haya realizado su voto
            checkPersonVoteDone()
        }
        else
        {
            //SÍ está en la lista de votantes activos
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Esta persona ya está en la lista de votantes activos.'
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $('#persona_dni').focus();
                    $("#data-loader").fadeOut(300);
                } else if (result.isDenied) {

                }
            });
        }
    });
}

function checkPersonVoteDone()
{
    var data = {};
    var thisURL = thisWebDomain+"_control/_controlSistemaElectoral.php?action=check_person_vote_done&persona_dni="+$('#persona_dni').val();

    $.ajax({
        type: "GET",
        dataType: "json",
        data: JSON.stringify(data),
        url: thisURL,
        contentType: "application/json",
    })
        .done(function( data, textStatus, jqXHR )
        {
            if (data.length == 0)
            {
                //NO ha realizado su voto
                addPersonVoting();
            }
            else
            {
                //SÍ ya realizó su voto
                createActionLog(206);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Esta persona ya realizó su voto.'
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $('#persona_dni').focus();
                        $("#data-loader").fadeOut(300);
                    } else if (result.isDenied) {

                    }
                });
            }
        });
}

function addPersonVoting() {
    //instanciamos el objetoAjax
    ajax = objetoAjax();
    //Abrimos una conexión AJAX pasando como parámetros el método de envío, y el archivo que realizará las operaciones deseadas
    ajax.open("POST", thisWebDomain+"_control/_controlSistemaElectoral.php?action=add_person_voting", true);
    //cuando el objeto XMLHttpRequest cambia de estado, la función se inicia
    ajax.onreadystatechange = function()
    {
        //Cuando se completa la petición, mostrará los resultados
        if (ajax.readyState == 4)
        {
            //resultado.value = (ajax.responseText)
        }
    }
    //Llamamos al método setRequestHeader indicando que los datos a enviarse están codificados como un formulario.
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax.send("&persona_dni="+$("#persona_dni").val());


    $("#persona_firstname").val(sessionStorage.getItem("persona_nombre_1"));
    $("#persona_secondname").val(sessionStorage.getItem("persona_nombre_2"));
    $("#persona_surname").val(sessionStorage.getItem("persona_apellido_1"));
    $("#persona_lastname").val(sessionStorage.getItem("persona_apellido_2"));
    $("#persona_departamento").val(sessionStorage.getItem("departamento_nombre"));
    $("#persona_municipio").val(sessionStorage.getItem("municipio_nombre"));

    $("#alertStatus").html('<div class="alert alert-info"><strong>Esta persona está habilitada para votar.</strong></div>');

    $("#personaInfo").fadeIn(300);

    //Aquí creo el registro de admisión
    createActionLog(202); //Recibió a [persona] para votar.

    $("#votingPerson").load('../../runapp/votingPerson.php?member_dni='+$("#memberDNI").html());

    $('#persona_dni').focus();
    $("#data-loader").fadeOut(300);

    Swal.fire({
        icon: 'success',
        title: '¡Todo bien!',
        text: 'La persona buscada está habilitada para votar en esta MER.',
    });

    $("#votingPerson").load('../../runapp/votingPerson.php?member_dni='+$("#memberDNI").html());

}

function getRndMember()
{
    var data = {};
    var thisURL = thisWebDomain+"_control/_controlSistemaElectoral.php?action=get_rnd_member";

    $.ajax({
        type: "GET",
        dataType: "json",
        data: JSON.stringify(data),
        url: thisURL,
        contentType: "application/json",
    })
        .done(function( data, textStatus, jqXHR )
        {
            if (data.length == 0)
            {
                //NO ha realizado su voto

            }
            else
            {
                Swal.fire({
                    icon: 'success',
                    title: 'Datos de prueba',
                    html: '<b>D.N.I.: </b>' + data[0]["member_dni"]+
                        '<br><b>Contraseña: </b>' + data[0]["member_unhashed"],
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $('#member_dni').val(data[0]["member_dni"]);
                        $("#login_password").val(data[0]["member_unhashed"]);
                    } else if (result.isDenied) {

                    }
                });
            }
        });
}