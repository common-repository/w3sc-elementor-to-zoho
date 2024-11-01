jQuery(document).ready(function () {
    //jQuery(".w3sc-adminbody-last").hide();
    jQuery('.setting-btn').click(function (e) {
        e.preventDefault();
        jQuery('.w3sc-adminbody-first').show();
        jQuery('.w3sc-adminbody-last').hide();
    });
    jQuery('.info-btn').click(function () {
        jQuery('.w3sc-adminbody-last').show();
        jQuery('.w3sc-adminbody-first').hide();
    });
});
