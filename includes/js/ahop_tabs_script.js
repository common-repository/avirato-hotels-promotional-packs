
function valida(e) {
    tecla = (document.all) ? e.keyCode : e.which;

    //Tecla de retroceso para borrar, siempre la permite
    if (tecla == 8 ) {
        return true;
    }

    // Patron de entrada, en este caso solo acepta numeros
    patron = /[0-9/,]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}

function ahop_open_tab(evt, tabName) {
    // Declare all variables
    var i, ahop_tabcontent, ahop_tablinks;

    // Get all elements with class="tabcontent" and hide them
    ahop_tabcontent = document.getElementsByClassName("ahop_tabcontent");
    for (i = 0; i < ahop_tabcontent.length; i++) {
        ahop_tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    ahop_tablinks = document.getElementsByClassName("ahop_tablinks");
    for (i = 0; i < ahop_tablinks.length; i++) {
        ahop_tablinks[i].className = ahop_tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}
function newCat() {

    var count = jQuery('.catCount').length + 1;
    jQuery('#multiEstab').append("<label class='catCount'>Selector " + count + ":</label>" +
            "<input id='catcon" + count + "' name='catcon" + count + "' type='text' required='' placeholder='Category'>" +
            "<input id='idscon" + count + "' name='idscon" + count + "' type='text' required='' placeholder='ID`s' onkeypress='return valida(event)'>" +
            "<label>Text Background Color:</label>" +
            "<input id='colorcon" + count + "' name='colorcon" + count + "' type='color' required=''>" +
            "<label>Text Color:</label>" +
            "<input id='textColorcon" + count + "' name='textColorcon" + count + "' type='color' required='' >");
}
function remNewCat() {
    var count = jQuery('.catCount').length;
    if (count !== 1) {
        jQuery("#catcon" + count).prev('.catCount')[0].remove();
        jQuery("#catcon" + count).remove();
        jQuery("#idscon" + count).remove();
        jQuery("#colorcon" + count).prev('label')[0].remove();
        jQuery("#colorcon" + count).remove();
        jQuery("#textColorcon" + count).prev('label')[0].remove();
        jQuery("#textColorcon" + count).remove();
        jQuery('.catCount:last-child').remove();
    }
}
function ahop_replaceCurrTable() {
    var htmlMultiOP = '';
    var count = jQuery('.catCount').length;
    var CatCodeArray = new Array();
    var idsNomArray = new Array();
    var colorNomArray = new Array();
    var textColorNomArray = new Array();
    var opcionArray = '';
    var i = 0;
    var e = 1;
//    if (jQuery("#catcon1").val().length <= 0 || jQuery("#idscon1").val().length <= 0 || /^[a-zA-Z]+$/.test(jQuery('#catcon1').val())) {
    if (jQuery("#catcon1").val().length <= 0 || jQuery("#idscon1").val().length <= 0 || jQuery("#colorcon1").val().length <= 0 || jQuery("#textColorcon1").val().length <= 0) {

//        jQuery('#acip_alertInput').css('height', '36px');
//        jQuery('#acip_alertInput').css('opacity', '1');
//        setTimeout(function () {
//            jQuery('#acip_alertInput').css('height', '0');
//            jQuery('#acip_alertInput').css('opacity', '0');
//        }, 3000);
    } else {
//        jQuery('#acip_alertInput').css('height', '0');
//        jQuery('#acip_alertInput').css('opacity', '0');
        while (i < count) {
            CatCodeArray[i] = jQuery("#catcon" + e).val();
            idsNomArray[i] = jQuery("#idscon" + e).val();
            colorNomArray[i] = jQuery("#colorcon" + e).val();
            textColorNomArray[i] = jQuery("#textColorcon" + e).val();
            if (jQuery("#catcon" + e).val().length <= 0 || jQuery("#idscon" + e).val().length <= 0 || jQuery("#colorcon" + e).val().length <= 0 || jQuery("#textColorcon1").val().length <= 0) {
            } else {
                opcionArray += CatCodeArray[i] + " ------- " + idsNomArray[i] + " ------- " + colorNomArray[i] + " ------- " + textColorNomArray[i] + "***";
            }
            i++;
            e++;
            if (jQuery("#catcon" + i).val().length <= 0 || jQuery("#idscon" + i).val().length <= 0 || jQuery("#colorcon" + i).val().length <= 0 || jQuery("#textColorcon1").val().length <= 0) {
            } else {
                htmlMultiOP = opcionArray;
            }
        }
    }

    jQuery('#ahop_noShow').html(htmlMultiOP);

}
;
