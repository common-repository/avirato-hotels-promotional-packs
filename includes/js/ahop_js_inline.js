
jQuery(document).ready(function () {
    jQuery('#ahop_dropdown select').change(function () {
        jQuery.each(jQuery('.item.offerBox .paCateg'), function (k, value) {
            jQuery(this).parent('.item.offerBox').removeClass('targetHide');
            jQuery(this).parent('.item.offerBox').removeClass('targetNotHide');

            if (!value.innerText.includes(jQuery('#ahop_dropdown select').val()) && jQuery('#ahop_dropdown select').val() != 'All') {
                jQuery(this).parent('.item.offerBox').addClass('targetHide');
            } else if (jQuery('#ahop_dropdown select').val() == 'All') {
                jQuery(this).parent('.item.offerBox').removeClass('targetHide');
            }
        });
    });
});

jQuery(document).ready(function () {
    // Configure/customize these variables.
    var langHtml =  jQuery('html')[0].lang;
    var showChar = 50;  // How many characters are shown by default
    var ellipsestext = "...";
    if(langHtml.indexOf('es') != -1){
        var moretext = "Leer más >";
        var lesstext = "< Leer menos";
    }else if(langHtml.indexOf('en') != -1){
        var moretext = "Read more >";
        var lesstext = "< Read less";
    }else if(langHtml.indexOf('fr') != -1){
        var moretext = "Lire plus >";
        var lesstext = "< Lire moins";
    }else if(langHtml.indexOf('de') != -1){
        var moretext = "Lesen Sie weiter >";
        var lesstext = "< Weniger lesen";
    }else if(langHtml.indexOf('it') != -1){
        var moretext = "Leggi di più >";
        var lesstext = "< Leggi meno";
    }else if(langHtml.indexOf('ru') != -1){
        var moretext = "Читать дальше >";
        var lesstext = "< Читать меньше";
    }else if(langHtml.indexOf('pt') != -1){
        var moretext = "Ler mais >";
        var lesstext = "< Leia menos";
    }else if(langHtml.indexOf('ca') != -1){
        var moretext = "Llegir més >";
        var lesstext = "< Llegir menys";
    }
    
    jQuery('.more').each(function () {
        var content = jQuery(this).html();
        if (content.length > showChar) {
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
            var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink" style="color:' + jQuery(this).prev('p').css('color') + '">' + moretext + '</a></span>';
            jQuery(this).html(html);
        }
    });
    jQuery(".morelink").click(function () {
        if (jQuery(this).hasClass("less")) {
            jQuery(this).removeClass("less");
            jQuery(this).html(moretext);

        } else {
            jQuery(this).addClass("less");
            jQuery(this).html(lesstext);
        }
        jQuery(this).parent().prev().toggle();
        jQuery(this).prev().toggle();
        return false;
    });
});

jQuery(document).ready(function () {
    //initialize swiper when document ready
    var mySwiper = new Swiper('.swiper-container', {
        // Optional parameters
        spaceBetween: 10,
        direction: 'horizontal',
        loop: false,
        autoHeight: false,
        grabCursor: true,
    });

});
