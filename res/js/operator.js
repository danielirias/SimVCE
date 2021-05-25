// JavaScript Document

function NUMERIC(e)
{
	var keynum = window.event ? window.event.keyCode : e.which;

	if ((keynum == 8 || keynum == 46 || keynum == 37 || keynum == 39) )
	return true;

	return /\d/.test(String.fromCharCode(keynum));
}

function INTEGER(e)
{
	var keynum = window.event ? window.event.keyCode : e.which;


	// 8 = BackSpace, 46 = Supr, 37 = flecha izquierda, 39 = flecha derecha
	if ((keynum == 8 || keynum == 37 || keynum == 39) )
	return true;

	if ((keynum == 46 ) ) //Punto (.)
	return false;

	return /\d/.test(String.fromCharCode(keynum));
}

function ALPHABETIC(e) 
{
	var keynum = (document.all) ? e.keyCode : e.which;

	// 8 = BackSpace, 46 = Supr, 37 = flecha izquierda, 39 = flecha derecha, 32 = space
	if (keynum == 8 || keynum == 46 || keynum == 37 || keynum == 39) {
		return true;
	}

	// Patron de entrada, en este caso solo acepta numeros y letras
	patron = /[A-Za-z ]/;
	tecla_final = String.fromCharCode(keynum);
	return patron.test(tecla_final);
}

function ALPHABETIC_WITH_SPACE(e) 
{
	var keynum = (document.all) ? e.keyCode : e.which;

	// 8 = BackSpace, 46 = Supr, 37 = flecha izquierda, 39 = flecha derecha, 32 = space
	if (keynum == 8 || keynum == 32 || keynum == 46 || keynum == 37 || keynum == 39) {
		return true;
	}

	// Patron de entrada, en este caso solo acepta numeros y letras
	patron = /[A-Za-z ]/;
	tecla_final = String.fromCharCode(keynum);
	return patron.test(tecla_final);
}

function ALPHA_NUMERIC(e) 
{
	var keynum = (document.all) ? e.keyCode : e.which;

	// 8 = BackSpace, 46 = Supr, 37 = flecha izquierda, 39 = flecha derecha
	if (keynum == 8 || keynum == 37 || keynum == 39) {
		return true;
	}
	if ((keynum == 46 ) ) //Punto (.)
	return false;

	// Patron de entrada, en este caso solo acepta numeros y letras
	patron = /[A-Za-z0-9]/;
	tecla_final = String.fromCharCode(keynum);
	return patron.test(tecla_final);
}

function ALPHA_NUMERIC_WITH_SPACE(e) 
{
	var keynum = (document.all) ? e.keyCode : e.which;

	// 8 = BackSpace, 46 = Supr, 37 = flecha izquierda, 39 = flecha derecha
	if (keynum == 8 || keynum == 32 || keynum == 37 || keynum == 39) {
		return true;
	}
	// Patron de entrada, en este caso solo acepta numeros y letras
	patron = /^[0-1a-zA-ZñÑáÁéÉíÍóÓúÚÄËÏÖÜäëïöü.\- ]+$/;
	tecla_final = String.fromCharCode(keynum);
	return patron.test(tecla_final);
}


//Activa el scroll de los post
$( document ).ready(function() {
	$(".booking-button").click(function(){ showBookingForm(); });
	$(".mouse_scroll").click(function(){ showPostInfo(); });
});
function showBookingForm()
{
	$("#bookingForm").fadeIn(300);
	$('#bookingForm').animatescroll({scrollSpeed:1000, padding: 100});
}
function showPostInfo()
{
	//$('#page-content').animatescroll({scrollSpeed:1000, padding: 60});
}



