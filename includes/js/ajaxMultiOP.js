jQuery(document).ready(function ($){
    var data = {
        'action': 'ahop_AjaxMulti',
        'whatever': ajax_object.we_value      // We pass php values differently!
    };
    function init() {
        var button = document.getElementById('ahop_externo1');
        if (button.addEventListener) {
            button.addEventListener("click", function (event) {
                event.preventDefault();
                if (jQuery("#catcon1").val().length <= 0 || jQuery("#idscon1").val().length <= 0 || jQuery("#colorcon1").val().length <= 0 || jQuery("#textColorcon1").val().length <= 0) {

                } else {
                    var htmlMultiOP = jQuery('#ahop_noShow').html();
                    debugger;
                    data = Object.assign({}, data, {htmlMultiOP});
                    jQuery.post(ajax_object.ajax_url, data, function (response) {

                        alert('Se generó el siguiente código: ' + response);
                        window.location = window.location.href.split("&")[0];


                    }, false);
                }
            });
        } else if(button.attachEvent){

            button.attachEvent("onclick", function (event) {
                event.preventDefault();
                if (jQuery("#catcon1").val().length <= 0 || jQuery("#idscon1").val().length <= 0 || jQuery("#colorcon1").val().length <= 0 || jQuery("#textColorcon1").val().length <= 0) {
                } else {
                    jQuery.post(ajax_object.ajax_url, data, function (response) {
                        alert('Se generó el siguiente código: ' + response);
                    });
                }
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