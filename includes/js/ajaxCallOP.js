
jQuery(document).ready(function ($) {
    var data = {
        'action': 'ahop_AjaxConnOP',
        'whatever': ajax_object.we_value      // We pass php values differently!
    };
    function init() {
        var button = document.getElementById('ahop_externo');
        if (button.addEventListener) {

            button.addEventListener("click", function (event) {

                event.preventDefault();
                var codecon = document.getElementById('codecon').value;
            
//                var usercon = document.getElementById('usercon').value;
//                data = Object.assign({}, data, {codecon, usercon});
data = Object.assign({}, data, {codecon});

jQuery.post(ajax_object.ajax_url, data, function (response) {
//                    alert('Se generó el siguiente código: ' + response);

//$("#dialog-confirm").dialog({
  //  position: {my: "center top", at: "center top+5%", of: window},
   // resizable: false,
   // height: "auto",
  //  width: 900,
  //  modal: true,
  //  dialogClass: "no-close",
  //  buttons: {
  //      "OK": function () {
   //         $(this).dialog("close");
                     alert('Se generó el siguiente código: ' + response);
            window.location = window.location.href.split("&")[0];
    //    }
   // }
//});

//                    $('#dialog-confirm p').text(response);
//                    $('#dialog-confirm p').text("Sus Paquetes se importaron con exito");
//$('#dialog-confirm p').text(response);

});
}, false);

        } else if (button.attachEvent) {
            button.attachEvent("onclick", function (event) {
                event.preventDefault();
                jQuery.post(ajax_object.ajax_url, data, function (response) {

                    alert('Se generó el siguiente código: ' + response);
                });
            });
        }
    }
    ;
    if (window.addEventListener) {
        window.addEventListener("load", init, false);
    } else if (window.attachEvent) {
        window.attachEvent("onload", init);
    } else {
        document.addEventListener("load", init, false);
    }
});


